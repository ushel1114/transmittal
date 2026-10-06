<dialog id="noticeImagePrintDialog" class="notice-image-dialog">
    <div class="notice-image-dialog-header">
        <h2 id="noticeImageDialogTitle">Notice of loss / claim</h2>
        <button type="button" class="notice-image-dialog-close" aria-label="Close image preview">&times;</button>
    </div>
    <div class="notice-image-dialog-content">
        <img id="noticeImagePreview" alt="Uploaded notice of loss or claim">
        <p id="noticeImagePreviewError" hidden role="alert" class="text-sm font-semibold text-red-700">Unable to load this image. It may have been moved or deleted; refresh the page and try again.</p>
    </div>
    <div class="notice-image-dialog-actions">
        <button type="button" class="notice-image-dialog-close secondary">Close</button>
        <button type="button" id="printNoticeImageButton" class="primary">Print image</button>
    </div>
</dialog>

<script data-public-content-script>
window.initializeNoticeImagePrintDialog = function () {
    const dialog = document.getElementById('noticeImagePrintDialog');
    const preview = document.getElementById('noticeImagePreview');
    const previewError = document.getElementById('noticeImagePreviewError');
    const title = document.getElementById('noticeImageDialogTitle');
    const printButton = document.getElementById('printNoticeImageButton');

    if (!dialog || !preview || !previewError || !title || !printButton) {
        return;
    }

    preview.addEventListener('load', function () {
        previewError.hidden = true;
    });

    preview.addEventListener('error', function () {
        preview.hidden = true;
        previewError.hidden = false;
    });

    dialog.addEventListener('close', function () {
        preview.removeAttribute('src');
        preview.hidden = false;
        previewError.hidden = true;
    });

    printButton.addEventListener('click', function () {
        if (!preview.complete || preview.naturalWidth === 0) {
            console.error('The notice image is not ready to print.');
            if (typeof window.showModalMessage === 'function') {
                window.showModalMessage('The notice image could not be loaded for printing.', 'error');
            }

            return;
        }

        window.print();
    });

    if (!window.noticeImagePrintDelegationBound) {
        document.addEventListener('click', function (event) {
            const viewButton = event.target.closest('.notice-image-view-btn');
            if (viewButton) {
                const activeDialog = document.getElementById('noticeImagePrintDialog');
                const activePreview = document.getElementById('noticeImagePreview');
                const activeTitle = document.getElementById('noticeImageDialogTitle');
                if (!activeDialog || !activePreview || !activeTitle) {
                    return;
                }

                event.preventDefault();
                event.stopPropagation();
                activePreview.hidden = false;
                activePreview.src = viewButton.dataset.imageUrl;
                activeTitle.textContent = `Notice of loss / claim — ${viewButton.dataset.farmerName}`;
                activeDialog.showModal();
                return;
            }

            const closeButton = event.target.closest('.notice-image-dialog-close');
            const activeDialog = document.getElementById('noticeImagePrintDialog');
            if (closeButton && activeDialog?.open) {
                activeDialog.close();
            }

            if (event.target === activeDialog && activeDialog?.open) {
                activeDialog.close();
            }
        });
        window.noticeImagePrintDelegationBound = true;
    }
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

.notice-image-dialog-content img {
    display: block;
    max-width: 100%;
    max-height: 66vh;
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

    #noticeImagePrintDialog .notice-image-dialog-content img {
        display: block;
        width: 100%;
        height: 100%;
        max-width: none;
        max-height: none;
        object-fit: contain;
    }
}
</style>
