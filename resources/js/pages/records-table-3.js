(function () {
    let selectedPreviewUrl = null;

    document.addEventListener('click', function (event) {
        const clearSelectionButton = event.target.closest('.clear-notice-image-selection');
        if (clearSelectionButton) {
            const form = clearSelectionButton.closest('form');
            const imageInput = form?.querySelector('input[type="file"][name="notice_image"]');

            if (imageInput) {
                imageInput.value = '';
                clearSelectionButton.hidden = true;
            }

            if (imageInput?.id === 'editNoticeImage') {
                if (selectedPreviewUrl) {
                    URL.revokeObjectURL(selectedPreviewUrl);
                    selectedPreviewUrl = null;
                }

                const currentImageUrl = imageInput.dataset.currentImageUrl || '';
                const preview = form.querySelector('#editNoticeImagePreview');
                const previewContainer = form.querySelector('#editNoticeImagePreviewContainer');
                const printButton = form.querySelector('#editNoticeImagePrintButton');
                const removeImageInput = form.querySelector('[name="remove_notice_image"]');
                const removeImageButton = form.querySelector('#removeNoticeImageButton');
                const status = form.querySelector('#editNoticeImageStatus');

                if (preview && previewContainer) {
                    preview.hidden = !currentImageUrl;
                    preview.src = currentImageUrl;
                    previewContainer.hidden = !currentImageUrl;
                }
                if (printButton) {
                    printButton.dataset.imageUrl = currentImageUrl;
                    printButton.hidden = !currentImageUrl;
                }
                if (removeImageInput) {
                    removeImageInput.value = '0';
                }
                if (removeImageButton) {
                    removeImageButton.hidden = !currentImageUrl;
                }
                if (status) {
                    status.textContent = currentImageUrl
                        ? 'Current image restored. Choose a replacement or remove it.'
                        : 'No image uploaded.';
                }
            }

            return;
        }

        const removeImageActionButton = event.target.closest('#removeNoticeImageButton');
        if (removeImageActionButton) {
            if (selectedPreviewUrl) {
                URL.revokeObjectURL(selectedPreviewUrl);
                selectedPreviewUrl = null;
            }

            const form = removeImageActionButton.closest('form');
            const imageInput = form?.querySelector('#editNoticeImage');
            const removeImageInput = form?.querySelector('[name="remove_notice_image"]');
            const preview = form?.querySelector('#editNoticeImagePreview');
            const previewContainer = form?.querySelector('#editNoticeImagePreviewContainer');
            const printButton = form?.querySelector('#editNoticeImagePrintButton');
            const status = form?.querySelector('#editNoticeImageStatus');

            if (imageInput) {
                imageInput.value = '';
            }
            if (removeImageInput) {
                removeImageInput.value = '1';
            }
            if (preview) {
                preview.hidden = true;
                preview.removeAttribute('src');
            }
            if (previewContainer) {
                previewContainer.hidden = true;
            }
            if (printButton) {
                printButton.hidden = true;
                printButton.dataset.imageUrl = '';
            }

            removeImageActionButton.hidden = true;
            if (status) {
                status.textContent = 'This image will be removed when you save.';
            }

            return;
        }

        const editButton = event.target.closest('.editButton');
        if (!editButton) {
            return;
        }

        const form = document.getElementById('recordEditForm');
        const preview = form?.querySelector('#editNoticeImagePreview');
        const previewContainer = form?.querySelector('#editNoticeImagePreviewContainer');
        const imageInput = form?.querySelector('#editNoticeImage');
        const printButton = form?.querySelector('#editNoticeImagePrintButton');
        const removeImageInput = form?.querySelector('[name="remove_notice_image"]');
        const removeImageButton = form?.querySelector('#removeNoticeImageButton');
        const editClearSelectionButton = form?.querySelector('.clear-notice-image-selection');
        const status = form?.querySelector('#editNoticeImageStatus');
        const imageUrl = editButton.dataset.noticeImageUrl;

        if (selectedPreviewUrl) {
            URL.revokeObjectURL(selectedPreviewUrl);
            selectedPreviewUrl = null;
        }

        if (imageInput) {
            imageInput.value = '';
            imageInput.dataset.currentImageUrl = imageUrl || '';
        }
        if (editClearSelectionButton) {
            editClearSelectionButton.hidden = true;
        }
        if (removeImageInput) {
            removeImageInput.value = '0';
        }

        if (preview && previewContainer) {
            previewContainer.hidden = !imageUrl;
            preview.hidden = !imageUrl;
            preview.src = imageUrl || '';
            if (printButton) {
                printButton.dataset.imageUrl = imageUrl || '';
                printButton.hidden = !imageUrl;
            }
        }
        if (removeImageButton) {
            removeImageButton.hidden = !imageUrl;
        }
        if (status) {
            status.textContent = imageUrl ? 'Current image. Choose a replacement or remove it.' : 'No image uploaded.';
        }
    });

    document.addEventListener('change', function (event) {
        const imageInput = event.target.closest('input[type="file"][name="notice_image"]');
        if (!imageInput) {
            return;
        }

        const form = imageInput.form;
        const clearSelectionButton = form?.querySelector('.clear-notice-image-selection');
        const image = imageInput.files?.[0];

        if (clearSelectionButton) {
            clearSelectionButton.hidden = !image;
        }

        if (imageInput.id !== 'editNoticeImage') {
            return;
        }

        const preview = form?.querySelector('#editNoticeImagePreview');
        const previewContainer = form?.querySelector('#editNoticeImagePreviewContainer');
        const printButton = form?.querySelector('#editNoticeImagePrintButton');
        const removeImageInput = form?.querySelector('[name="remove_notice_image"]');
        const removeImageButton = form?.querySelector('#removeNoticeImageButton');
        const status = form?.querySelector('#editNoticeImageStatus');
        if (!preview || !previewContainer) {
            return;
        }

        if (selectedPreviewUrl) {
            URL.revokeObjectURL(selectedPreviewUrl);
            selectedPreviewUrl = null;
        }

        if (image) {
            selectedPreviewUrl = URL.createObjectURL(image);
            preview.src = selectedPreviewUrl;
            preview.hidden = false;
            previewContainer.hidden = false;
            if (printButton) {
                printButton.dataset.imageUrl = selectedPreviewUrl;
                printButton.hidden = false;
            }
            if (removeImageInput) {
                removeImageInput.value = '0';
            }
            if (removeImageButton) {
                removeImageButton.hidden = false;
            }
            if (status) {
                status.textContent = 'Selected image will replace the current image when you save.';
            }
        }
    });

    document.addEventListener('close', function (event) {
        if (event.target.id !== 'recordEditDialog' || !selectedPreviewUrl) {
            return;
        }

        URL.revokeObjectURL(selectedPreviewUrl);
        selectedPreviewUrl = nul

l;
    }, true);
})();
