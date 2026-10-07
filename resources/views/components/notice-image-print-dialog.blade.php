<dialog id="noticeImagePrintDialog" class="notice-image-dialog">
    <div class="notice-image-dialog-header">
        <h2 id="noticeImageDialogTitle">Notice of loss / claim</h2>
        <button type="button" class="notice-image-dialog-close" aria-label="Close image preview">&times;</button>
    </div>
    <div class="notice-image-dialog-content">
        <div id="noticeImagePreviewGallery" class="notice-image-gallery"></div>
        <p id="noticeImagePreviewError" hidden role="alert" class="text-sm font-semibold text-red-700">Unable to load every photo. Refresh the page and try again before printing.</p>
    </div>
    <div class="notice-image-dialog-actions">
        <button type="button" class="notice-image-dialog-close secondary">Close</button>
        <button type="button" id="printNoticeImageButton" class="primary" disabled>Print photos</button>
    </div>
</dialog>

<script data-public-content-script>
window.initializeNoticeImagePrintDialog = function () {
    if (document.documentElement.dataset.noticeImagePrintHandlerInitialized === 'true') {
        return;
    }
    document.documentElement.dataset.noticeImagePrintHandlerInitialized = 'true';

    function openGallery(button) {
        const dialog = document.getElementById('noticeImagePrintDialog');
        const gallery = document.getElementById('noticeImagePreviewGallery');
        const previewError = document.getElementById('noticeImagePreviewError');
        const title = document.getElementById('noticeImageDialogTitle');
        const printButton = document.getElementById('printNoticeImageButton');

        if (!dialog || !gallery || !previewError || !title || !printButton) {
            console.error('Unable to open notice photos: the preview dialog is unavailable.');
            return;
        }

        let imageUrls = [];
        try {
            imageUrls = JSON.parse(button.dataset.imageUrls || '[]');
        } catch (error) {
            console.error('Unable to read notice image URLs.', error);
        }
        if (!Array.isArray(imageUrls) || imageUrls.length === 0) {
            imageUrls = button.dataset.imageUrl ? [button.dataset.imageUrl] : [];
        }
        imageUrls = imageUrls.filter(url => typeof url === 'string' && url !== '');
        if (imageUrls.length === 0) {
            console.error('No notice photos are available to preview.');
            if (typeof window.showModalMessage === 'function') {
                window.showModalMessage('No photos are available to preview.', 'error');
            }
            return;
        }

        const previewImages = [];
        function updatePrintButton() {
            const allImagesReady = previewImages.length > 0 && previewImages.every(image => image.complete && image.naturalWidth > 0);
            printButton.disabled = !allImagesReady;
            previewError.hidden = !previewImages.some(image => image.dataset.failed === 'true');
        }

        gallery.replaceChildren();
        imageUrls.forEach((url, index) => {
            const image = document.createElement('img');
            image.alt = `Uploaded notice of loss or claim, photo ${index + 1} of ${imageUrls.length}`;
            image.addEventListener('load', updatePrintButton);
            image.addEventListener('error', function () {
                image.dataset.failed = 'true';
                updatePrintButton();
            });
            gallery.append(image);
            image.src = url;
            previewImages.push(image);
        });

        previewError.hidden = true;
        title.textContent = `Notice of loss / claim — ${button.dataset.farmerName || ''}`;
        printButton.disabled = true;
        if (typeof dialog.showModal !== 'function') {
            console.error('Unable to open notice photos: this browser does not support modal dialogs.');
            return;
        }
        if (!dialog.open) {
            dialog.showModal();
        }
        updatePrintButton();
    }

    document.addEventListener('click', function (event) {
        const target = event.target instanceof Element ? event.target : null;
        if (!target) {
            return;
        }

        const viewButton = target.closest('.notice-image-view-btn');
        if (viewButton) {
            event.preventDefault();
            event.stopPropagation();
            openGallery(viewButton);
            return;
        }

        const dialog = document.getElementById('noticeImagePrintDialog');
        const closeButton = target.closest('.notice-image-dialog-close');
        if ((closeButton || target === dialog) && dialog?.open) {
            event.preventDefault();
            dialog.close();
            return;
        }

        if (target.closest('#printNoticeImageButton')) {
            const printButton = document.getElementById('printNoticeImageButton');
            if (printButton && !printButton.disabled) {
                window.print();
            }
        }
    });

    document.addEventListener('close', function (event) {
        if (event.target?.id !== 'noticeImagePrintDialog') {
            return;
        }

        const gallery = event.target.querySelector('#noticeImagePreviewGallery');
        const previewError = event.target.querySelector('#noticeImagePreviewError');
        const printButton = event.target.querySelector('#printNoticeImageButton');

        gallery?.replaceChildren();
        if (previewError) {
            previewError.hidden = true;
        }
        if (printButton) {
            printButton.disabled = true;
        }
    }, true);
};
window.initializeNoticeImagePrintDialog();
</script>

<style>
.notice-image-dialog {
    width: min(900px, calc(100vw - 2rem));
    max-height: calc(100vh - 2rem);
    padding: 0;
    border: 1px solid #cbd5e1;
    border-radius: 16px;
    color: #0f172a;
    box-shadow: 0 24px 64px rgb(15 23 42 / 24%);
}

.notice-image-dialog::backdrop {
    background: rgb(15 23 42 / 60%);
}

.notice-image-dialog-header,
.notice-image-dialog-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 14px 18px;
}

.notice-image-dialog-header {
    border-bottom: 1px solid #e2e8f0;
}

.notice-image-dialog-header h2 {
    margin: 0;
    font-size: 16px;
    font-weight: 800;
}

.notice-image-dialog-content {
    display: grid;
    min-height: 180px;
    max-height: 70vh;
    place-items: center;
    overflow: auto;
    padding: 16px;
    background: #f8fafc;
}

.notice-image-gallery {
    display: grid;
    width: 100%;
    gap: 16px;
}

.notice-image-gallery img {
    display: block;
    max-width: 100%;
    max-height: 66vh;
    margin: 0 auto;
    object-fit: contain;
}

.notice-image-dialog-actions {
    justify-content: flex-end;
    border-top: 1px solid #e2e8f0;
}

.notice-image-dialog-actions button,
.notice-image-dialog-close {
    border: 0;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
}

.notice-image-dialog-actions .primary {
    background: #006c35;
    color: white;
}

.notice-image-dialog-actions .primary:disabled {
    cursor: not-allowed;
    opacity: .55;
}

.notice-image-dialog-actions .secondary,
.notice-image-dialog-close {
    background: #e2e8f0;
    color: #334155;
}

.notice-image-view-btn {
    border: 1px solid #bbf7d0;
    border-radius: 7px;
    padding: 6px 10px;
    background: #f0fdf4;
    color: #166534;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
}

.notice-image-view-btn:hover {
    border-color: #16a34a;
    background: #dcfce7;
}

.notice-image-unavailable {
    color: #94a3b8;
}

@media print {
    @page {
        size: portrait;
        margin: 0.25in;
    }

    body * {
        visibility: hidden !important;
    }

    #noticeImagePrintDialog[open],
    #noticeImagePrintDialog[open] * {
        visibility: visible !important;
    }

    #noticeImagePrintDialog[open] {
        position: fixed;
        inset: 0;
        display: block !important;
        width: 100% !important;
        height: 100% !important;
        max-width: none;
        max-height: none;
        overflow: visible;
        margin: 0;
        padding: 0;
        border: 0;
        border-radius: 0;
        box-shadow: none;
    }

    #noticeImagePrintDialog .notice-image-dialog-header,
    #noticeImagePrintDialog .notice-image-dialog-actions {
        display: none !important;
    }

    #noticeImagePrintDialog .notice-image-dialog-content {
        display: block;
        width: 100%;
        height: 100%;
        max-height: none;
        overflow: visible;
        padding: 0;
        background: white;
    }

    #noticeImagePrintDialog .notice-image-gallery {
        display: block;
    }

    #noticeImagePrintDialog .notice-image-gallery img {
        display: block;
        width: 100%;
        height: calc(100vh - 0.5in);
        max-width: none;
        max-height: none;
        margin: 0;
        object-fit: contain;
        break-after: page;
        page-break-after: always;
    }

    #noticeImagePrintDialog .notice-image-gallery img:last-child {
        break-after: auto;
        page-break-after: auto;
    }
}
</style>
