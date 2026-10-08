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

    function imageRotation(image, orientation, rotation) {
        if (rotation !== 'auto') {
            return Number(rotation);
        }

        const imageIsLandscape = image.naturalWidth > image.naturalHeight;
        const paperIsLandscape = orientation === 'landscape';

        return imageIsLandscape !== paperIsLandscape ? 90 : 0;
    }

    function imageDimensions(image, orientation, rotation, size, areaWidth, areaHeight) {
        const degrees = imageRotation(image, orientation, rotation);
        const rotated = degrees % 180 !== 0;
        const scale = size / 100;
        const displayWidth = rotated ? image.naturalHeight : image.naturalWidth;
        const displayHeight = rotated ? image.naturalWidth : image.naturalHeight;
        const coverScale = Math.max(areaWidth / displayWidth, areaHeight / displayHeight) * scale;

        return {
            width: image.naturalWidth * coverScale,
            height: image.naturalHeight * coverScale,
            degrees,
        };
    }

    function paperDimensions(paperSize, orientation) {
        const sizes = {
            a4: { width: 210 / 25.4, height: 297 / 25.4 },
            short: { width: 8.5, height: 11 },
            long: { width: 8.5, height: 13 },
        };
        const dimensions = sizes[paperSize] || sizes.short;

        return orientation === 'landscape'
            ? { width: dimensions.height, height: dimensions.width }
            : dimensions;
    }

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
        const editors = [];
        function updatePrintButton() {
            const allImagesReady = previewImages.length > 0 && previewImages.every(image => image.complete && image.naturalWidth > 0);
            printButton.disabled = !allImagesReady;
            previewError.hidden = !previewImages.some(image => image.dataset.failed === 'true');
        }

        function appendOptions(select, options) {
            options.forEach(([value, label]) => {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = label;
                select.append(option);
            });
        }

        gallery.replaceChildren();
        imageUrls.forEach((url, index) => {
            const editor = document.createElement('article');
            editor.className = 'notice-image-editor';

            const controls = document.createElement('div');
            controls.className = 'notice-image-editor-controls';

            const paperSizeLabel = document.createElement('label');
            paperSizeLabel.className = 'notice-image-editor-control';
            paperSizeLabel.textContent = `Paper size ${index + 1}`;
            const paperSizeSelect = document.createElement('select');
            paperSizeSelect.setAttribute('aria-label', `Photo ${index + 1} paper size`);
            appendOptions(paperSizeSelect, [
                ['a4', 'A4 (8.27 × 11.69 in)'],
                ['short', 'Short (8.5 × 11 in)'],
                ['long', 'Long (8.5 × 13 in)'],
            ]);
            paperSizeSelect.value = 'short';
            paperSizeLabel.append(paperSizeSelect);

            const orientationLabel = document.createElement('label');
            orientationLabel.className = 'notice-image-editor-control';
            orientationLabel.textContent = `Paper ${index + 1}`;
            const orientationSelect = document.createElement('select');
            orientationSelect.setAttribute('aria-label', `Photo ${index + 1} paper orientation`);
            appendOptions(orientationSelect, [['portrait', 'Portrait'], ['landscape', 'Landscape']]);
            orientationLabel.append(orientationSelect);

            const rotationLabel = document.createElement('label');
            rotationLabel.className = 'notice-image-editor-control';
            rotationLabel.textContent = 'Image rotation';
            const rotationSelect = document.createElement('select');
            rotationSelect.setAttribute('aria-label', `Photo ${index + 1} rotation`);
            appendOptions(rotationSelect, [
                ['auto', 'Auto-fit'],
                ['0', '0°'],
                ['90', '90°'],
                ['180', '180°'],
                ['270', '270°'],
            ]);
            rotationLabel.append(rotationSelect);

            const sizeLabel = document.createElement('label');
            sizeLabel.className = 'notice-image-editor-control notice-image-size-control';
            const sizeText = document.createElement('span');
            sizeText.textContent = 'Image size';
            const sizeInput = document.createElement('input');
            sizeInput.type = 'range';
            sizeInput.min = '25';
            sizeInput.max = '100';
            sizeInput.step = '5';
            sizeInput.value = '100';
            sizeInput.setAttribute('aria-label', `Photo ${index + 1} image size`);
            const sizeValue = document.createElement('output');
            sizeValue.textContent = '100%';
            sizeLabel.append(sizeText, sizeInput, sizeValue);
            controls.append(paperSizeLabel, orientationLabel, rotationLabel, sizeLabel);

            const paper = document.createElement('div');
            paper.className = 'notice-image-editor-paper is-portrait';

            const image = document.createElement('img');
            image.alt = `Uploaded notice of loss or claim, photo ${index + 1} of ${imageUrls.length}`;
            image.addEventListener('load', function () {
                updateEditor();
                updatePrintButton();
            });
            image.addEventListener('error', function () {
                image.dataset.failed = 'true';
                updatePrintButton();
            });
            paper.append(image);
            editor.append(controls, paper);
            gallery.append(editor);
            image.src = url;
            previewImages.push(image);

            function updateEditor() {
                const orientation = orientationSelect.value;
                const paperSize = paperSizeSelect.value;
                const pageDimensions = paperDimensions(paperSize, orientation);
                paper.classList.toggle('is-portrait', orientation === 'portrait');
                paper.classList.toggle('is-landscape', orientation === 'landscape');
                paper.style.aspectRatio = `${pageDimensions.width} / ${pageDimensions.height}`;
                paper.dataset.paperSize = paperSize;
                sizeValue.textContent = `${sizeInput.value}%`;

                if (!image.naturalWidth || !image.naturalHeight || !paper.clientWidth || !paper.clientHeight) {
                    return;
                }

                const dimensions = imageDimensions(
                    image,
                    orientation,
                    rotationSelect.value,
                    Number(sizeInput.value),
                    paper.clientWidth,
                    paper.clientHeight
                );
                image.style.width = `${dimensions.width}px`;
                image.style.height = `${dimensions.height}px`;
                image.style.transform = `translate(-50%, -50%) rotate(${dimensions.degrees}deg)`;
            }

            [orientationSelect, rotationSelect, sizeInput].forEach(control => {
                control.addEventListener('input', updateEditor);
                control.addEventListener('change', updateEditor);
            });
            editors.push(updateEditor);
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
        requestAnimationFrame(() => editors.forEach(update => update()));
        updatePrintButton();
    }

    function printGallery() {
        const gallery = document.getElementById('noticeImagePreviewGallery');
        const printButton = document.getElementById('printNoticeImageButton');
        if (!gallery || !printButton || printButton.disabled) {
            return;
        }

        const printWindow = window.open('', '_blank');
        if (!printWindow) {
            const message = 'Allow pop-ups for this site to open the print editor.';
            console.error(message);
            if (typeof window.showModalMessage === 'function') {
                window.showModalMessage(message, 'error');
            }
            return;
        }

        const printDocument = printWindow.document;
        printDocument.open();
        printDocument.close();

        printDocument.title = 'Print photos';
        const style = printDocument.createElement('style');
        style.textContent = `
            @page { size: letter portrait; margin: 0.2in; }
            @page a4-portrait { size: 210mm 297mm; margin: 0.2in; }
            @page a4-landscape { size: 297mm 210mm; margin: 0.2in; }
            @page short-portrait { size: 8.5in 11in; margin: 0.2in; }
            @page short-landscape { size: 11in 8.5in; margin: 0.2in; }
            @page long-portrait { size: 8.5in 13in; margin: 0.2in; }
            @page long-landscape { size: 13in 8.5in; margin: 0.2in; }
            html, body { margin: 0; padding: 0; }
            body { color: #000; }
            .print-photo-page {
                position: relative;
                display: block;
                box-sizing: border-box;
                width: 8.5in;
                height: 11in;
                margin: 0;
                overflow: hidden;
                page: portrait;
                break-inside: avoid;
                page-break-inside: avoid;
            }
            .print-photo-page.paper-a4.is-portrait { page: a4-portrait; }
            .print-photo-page.paper-a4.is-landscape { page: a4-landscape; }
            .print-photo-page.paper-short.is-portrait { page: short-portrait; }
            .print-photo-page.paper-short.is-landscape { page: short-landscape; }
            .print-photo-page.paper-long.is-portrait { page: long-portrait; }
            .print-photo-page.paper-long.is-landscape { page: long-landscape; }
            .print-photo-page + .print-photo-page {
                break-before: page;
                page-break-before: always;
            }
            .print-photo-page img {
                position: absolute;
                top: 50%;
                left: 50%;
                display: block;
                max-width: none;
                max-height: none;
                transform-origin: center;
            }
            @media print {
                html, body { margin: 0; padding: 0; }
            }
        `;
        printDocument.head.append(style);

        const printImages = [];
        let printStarted = false;
        function startPrintWhenReady() {
            if (printStarted || printImages.some(image => !image.complete || image.naturalWidth === 0)) {
                return;
            }

            printStarted = true;
            printWindow.focus();
            printWindow.onafterprint = () => printWindow.close();
            printWindow.print();
        }

        gallery.querySelectorAll('.notice-image-editor').forEach(editor => {
            const sourceImage = editor.querySelector('img');
            const paperSize = editor.querySelector('[aria-label$="paper size"]').value;
            const orientation = editor.querySelector('[aria-label$="paper orientation"]').value;
            const rotation = editor.querySelector('[aria-label$="rotation"]').value;
            const size = Number(editor.querySelector('input[type="range"]').value);
            const paper = paperDimensions(paperSize, orientation);
            const printableWidth = paper.width - 0.4;
            const printableHeight = paper.height - 0.4;
            const page = printDocument.createElement('section');
            page.className = `print-photo-page paper-${paperSize} is-${orientation}`;
            page.style.width = `${printableWidth}in`;
            page.style.height = `${printableHeight}in`;

            const image = printDocument.createElement('img');
            const dimensions = imageDimensions(
                sourceImage,
                orientation,
                rotation,
                size,
                printableWidth * 96,
                printableHeight * 96
            );
            image.src = sourceImage.currentSrc || sourceImage.src;
            image.alt = sourceImage.alt;
            image.style.width = `${dimensions.width / 96}in`;
            image.style.height = `${dimensions.height / 96}in`;
            image.style.transform = `translate(-50%, -50%) rotate(${dimensions.degrees}deg)`;
            image.addEventListener('load', startPrintWhenReady, { once: true });
            image.addEventListener('error', function () {
                printWindow.close();
                const message = 'A photo could not be loaded for printing. Reopen the photo editor and try again.';
                console.error(message);
                if (typeof window.showModalMessage === 'function') {
                    window.showModalMessage(message, 'error');
                }
            }, { once: true });
            page.append(image);
            printDocument.body.append(page);
            printImages.push(image);
        });

        startPrintWhenReady();
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
                printGallery();
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

    window.addEventListener('resize', function () {
        document.querySelectorAll('#noticeImagePrintDialog .notice-image-editor').forEach(editor => {
            const paperSize = editor.querySelector('[aria-label$="paper size"]');
            const orientation = editor.querySelector('[aria-label$="paper orientation"]');
            const rotation = editor.querySelector('[aria-label$="rotation"]');
            const size = editor.querySelector('input[type="range"]');
            const paper = editor.querySelector('.notice-image-editor-paper');
            const image = editor.querySelector('img');

            if (!paperSize || !orientation || !rotation || !size || !paper || !image || !image.naturalWidth || !paper.clientWidth || !paper.clientHeight) {
                return;
            }

            const dimensionsInches = paperDimensions(paperSize.value, orientation.value);
            paper.style.aspectRatio = `${dimensionsInches.width} / ${dimensionsInches.height}`;
            paper.dataset.paperSize = paperSize.value;
            const dimensions = imageDimensions(image, orientation.value, rotation.value, Number(size.value), paper.clientWidth, paper.clientHeight);
            image.style.width = `${dimensions.width}px`;
            image.style.height = `${dimensions.height}px`;
            image.style.transform = `translate(-50%, -50%) rotate(${dimensions.degrees}deg)`;
        });
    });
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
    display: block;
    max-height: 72vh;
    overflow: auto;
    padding: 16px;
    background: #f8fafc;
}

.notice-image-gallery {
    display: grid;
    gap: 20px;
    width: min(100%, 760px);
    margin: 0 auto;
}

.notice-image-editor {
    display: grid;
    gap: 12px;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    padding: 14px;
    background: white;
}

.notice-image-editor-controls {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    align-items: end;
    gap: 12px;
}

.notice-image-editor-control {
    display: grid;
    min-width: 0;
    gap: 6px;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
}

.notice-image-editor-control select,
.notice-image-editor-control input[type="range"] {
    width: 100%;
}

.notice-image-editor-control select {
    min-height: 36px;
    border: 1px solid #cbd5e1;
    border-radius: 7px;
    padding: 6px 8px;
    background: white;
    color: #0f172a;
    font: inherit;
}

.notice-image-size-control {
    grid-template-columns: minmax(0, 1fr) auto;
    align-items: center;
}

.notice-image-size-control > span {
    grid-column: 1 / -1;
}

.notice-image-size-control output {
    min-width: 38px;
    text-align: right;
    font-variant-numeric: tabular-nums;
}

.notice-image-editor-paper {
    position: relative;
    display: grid;
    width: min(100%, 340px);
    margin: 0 auto;
    place-items: center;
    overflow: hidden;
    border: 1px solid #cbd5e1;
    background: white;
    box-shadow: 0 2px 8px rgb(15 23 42 / 12%);
}

.notice-image-editor-paper.is-portrait {
    aspect-ratio: 8.5 / 11;
}

.notice-image-editor-paper.is-landscape {
    width: min(100%, 520px);
    aspect-ratio: 11 / 8.5;
}

.notice-image-editor-paper img {
    position: absolute;
    top: 50%;
    left: 50%;
    display: block;
    max-width: none;
    max-height: none;
    transform-origin: center;
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

@media (max-width: 760px) {
    .notice-image-editor-controls {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 440px) {
    .notice-image-editor-controls {
        grid-template-columns: 1fr;
    }
}
</style>
