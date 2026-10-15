<dialog class="largeModal landing-view-modal rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(640px,calc(100vw-2rem))]" id="viewModal">
    <div class="modal-header">
        <h3 class="modal-title">Record Details</h3>
    </div>
    <div class="modal-body" id="modalBody"></div>
    <div class="modal-footer">
        <button class="close-btn" onclick="closeModal()">Close</button>
    </div>
</dialog>

<script>
    function viewRecord(button) {
        try {
            const data = JSON.parse(button.dataset.record);
            const escapeHtml = value => String(value ?? 'N/A').replace(/[&<>"']/g, character => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[character]);
            const accountValue = data.accounts
                ? data.facebook_page_url && /^https?:\/\//i.test(data.facebook_page_url)
                    ? `<a href="${escapeHtml(data.facebook_page_url)}" target="_blank" rel="noopener noreferrer">${escapeHtml(data.accounts)}</a>`
                    : escapeHtml(data.accounts)
                : 'N/A';

            const modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = `
                <div class="record-detail">
                    <div class="detail-label">Farmer Name:</div>
                    <div class="detail-value">${escapeHtml(data.farmerName)}</div>
                </div>
                <div class="record-detail">
                    <div class="detail-label">Encoder Name:</div>
                    <div class="detail-value">${escapeHtml(data.encoderName)}</div>
                </div>
                <div class="record-detail">
                    <div class="detail-label">Source:</div>
                    <div class="detail-value">${escapeHtml(data.source)}</div>
                </div>
                <div class="record-detail">
                    <div class="detail-label">Municipality:</div>
                    <div class="detail-value">${escapeHtml(data.municipality)}</div>
                </div>
                <div class="record-detail">
                    <div class="detail-label">Barangay:</div>
                    <div class="detail-value">${escapeHtml(data.barangay)}</div>
                </div>
                <div class="record-detail">
                    <div class="detail-label">Date Received:</div>
                    <div class="detail-value">${escapeHtml(data.date_received)}</div>
                </div>
                <div class="record-detail">
                    <div class="detail-label">Date Encoded:</div>
                    <div class="detail-value">${escapeHtml(data.created_at)}</div>
                </div>
                <div class="record-detail">
                    <div class="detail-label">Transmittal #:</div>
                    <div class="detail-value">${escapeHtml(data.admin_transmittal_number)}</div>
                </div>
                <div class="record-detail">
                    <div class="detail-label">Remarks:</div>
                    <div class="detail-value">${escapeHtml(data.remarks)}</div>
                </div>
                <div class="record-detail">
                    <div class="detail-label">Cause of Loss:</div>
                    <div class="detail-value">${escapeHtml(data.causeOfDamage)}</div>
                </div>
                <div class="record-detail">
                    <div class="detail-label">Line:</div>
                    <div class="detail-value">${escapeHtml(data.line)}</div>
                </div>
                <div class="record-detail">
                    <div class="detail-label">Payment Method:</div>
                    <div class="detail-value">${escapeHtml(data.modeOfPayment)}</div>
                </div>
                <div class="record-detail">
                    <div class="detail-label">Account:</div>
                    <div class="detail-value" style="font-weight: bold; color: blue; cursor: pointer;">${accountValue}</div>
                </div>
            `;

            const modal = document.getElementById('viewModal');
            if (typeof modal.showModal === 'function') {
                modal.showModal();
            } else {
                modal.setAttribute('open', 'open');
            }
        } catch (error) {
            console.error('Error loading record details:', error);
            showModalMessage('Unable to display this record. Please reload the page and try again.', 'error');
        }
    }

    function closeModal() {
        document.getElementById('viewModal').close();
    }

    document.getElementById('viewModal').addEventListener('click', function (event) {
        if (event.target === this) {
            closeModal();
        }
    });
</script>
