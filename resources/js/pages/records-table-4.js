(function() {
    let modal = null;
    let closeBtn = null;
    let closeFooterBtn = null;
    let recordDetails = null;
    let isModalOpen = false;

    function initModal() {
        modal = document.getElementById('viewRecordModal');
        closeBtn = document.getElementById('closeModalBtn');
        closeFooterBtn = document.getElementById('closeModalFooterBtn');
        recordDetails = document.getElementById('recordDetails');

        if (!modal || !closeBtn || !closeFooterBtn || !recordDetails) {
            console.error('Modal elements not found');
            return false;
        }

        closeBtn.removeEventListener('click', closeModal);
        closeFooterBtn.removeEventListener('click', closeModal);
        modal.removeEventListener('click', handleBackdropClick);

        closeBtn.addEventListener('click', closeModal);
        closeFooterBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', handleBackdropClick);

        return true;
    }

    function handleBackdropClick(e) {
        if (e.target === modal) {
            closeModal(e);
        }
    }

    function closeModal(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        if (modal && isModalOpen) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
            isModalOpen = false;
        }
    }

    function openViewModal(recordId, e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        if (!initModal()) {
            console.error('Failed to initialize modal');
            return;
        }

        if (isModalOpen) {
            return;
        }

        const row = document.querySelector(`.view-record-btn[data-record-id="${recordId}"]`).closest('tr');
        if (!row) {
            console.error('Record row not found');
            return;
        }

        const recordData = extractRecordData(row);

        populateModal(recordData);

        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        isModalOpen = true;
    }

    function extractRecordData(row) {
        const viewBtn = row.querySelector('.view-record-btn');
        const editBtn = row.querySelector('.editButton');

        const data = {
            id: viewBtn.getAttribute('data-record-id') || 'N/A',
            farmerName: editBtn.getAttribute('data-farmer-name') || 'N/A',
            province: editBtn.getAttribute('data-province') || 'N/A',
            municipality: editBtn.getAttribute('data-municipality') || 'N/A',
            barangay: editBtn.getAttribute('data-barangay') || 'N/A',
            address: editBtn.getAttribute('data-address') || 'N/A',
            program: editBtn.getAttribute('data-program') || 'N/A',
            line: editBtn.getAttribute('data-line') || 'N/A',
            causeOfDamage: editBtn.getAttribute('data-cause-of-damage') || 'N/A',
            modeOfPayment: editBtn.getAttribute('data-mode-of-payment') || 'N/A',
            accounts: editBtn.getAttribute('data-accounts') || 'N/A',
            dateOccurrence: editBtn.getAttribute('data-date-occurrence') || 'N/A',
            dateReceived: editBtn.getAttribute('data-date-received') || 'N/A',
            dateEncoded: editBtn.getAttribute('data-created-at') || 'N/A',
            remarks: editBtn.getAttribute('data-remarks') || '',
            source: editBtn.getAttribute('data-source') || 'N/A',
            adminTransmittalNumber: editBtn.getAttribute('data-admin-transmittal-number') || 'N/A',
            encoderName: editBtn.getAttribute('data-encoder-name') || 'N/A'
        };

        if (data.encoderName === 'N/A') {
            const encoderCell = row.querySelector('.col-encoder');
            if (encoderCell) {
                data.encoderName = encoderCell.textContent.trim() || 'N/A';
            }
        }

        const adminTransmittalAssignedAt = editBtn.getAttribute('data-admin-transmittal-assigned-at');
        const transmittalCell = row.querySelector('.col-control-number');
        if (transmittalCell) {
            data.transmittalNumber = transmittalCell.textContent.trim() || 'N/A';
        }
        data.adminTransmittalAssignedAt = adminTransmittalAssignedAt || 'N/A';

        return data;
    }

    function populateModal(data) {
        recordDetails.innerHTML = `
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">

                <div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 12px; padding: 20px; border: 1px solid #e2e8f0;">
                    <h3 style="color: #1e293b; font-size: 18px; font-weight: bold; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="m22 21-3-3"/>
                        </svg>
                        FARMER DETAILS
                    </h3>
                    <div style="display: grid; gap: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">
                            <span style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">NAME</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.farmerName}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">
                            <span style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">PROVINCE</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.province}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">
                            <span style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">MUNICIPALITY</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.municipality}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">
                            <span style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">BARANGAY</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.barangay}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">
                            <span style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">LINE</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.line}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">
                            <span style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">PROGRAM</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.program}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">
                            <span style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">ACCOUNT</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.accounts}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">MODE OF PAYMENT</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.modeOfPayment}</span>
                        </div>
                    </div>
                </div>


                <div style="background: linear-gradient(135deg, #fef7f0 0%, #fef3e2 100%); border-radius: 12px; padding: 20px; border: 1px solid #fbbf24;">
                    <h3 style="color: #1e293b; font-size: 18px; font-weight: bold; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        OTHER DETAILS
                    </h3>
                    <div style="display: grid; gap: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #fbbf24;">
                            <span style="font-size: 12px; font-weight: 600; color: #92400e; text-transform: uppercase;">DATE RECEIVED</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.dateReceived}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #fbbf24;">
                            <span style="font-size: 12px; font-weight: 600; color: #92400e; text-transform: uppercase;">DATE ENCODED</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.dateEncoded}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #fbbf24;">
                            <span style="font-size: 12px; font-weight: 600; color: #92400e; text-transform: uppercase;">DATE OF OCCURRENCE</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.dateOccurrence}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #fbbf24;">
                            <span style="font-size: 12px; font-weight: 600; color: #92400e; text-transform: uppercase;">ENCODER</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.encoderName}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #fbbf24;">
                            <span style="font-size: 12px; font-weight: 600; color: #92400e; text-transform: uppercase;">SOURCE</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.source}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #fbbf24;">
                            <span style="font-size: 12px; font-weight: 600; color: #92400e; text-transform: uppercase;">CONTROL NUMBER</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.transmittalNumber}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #fbbf24;">
                            <span style="font-size: 12px; font-weight: 600; color: #92400e; text-transform: uppercase;">ADMIN TRANSMITTAL #</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.adminTransmittalNumber || 'N/A'}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #fbbf24;">
                            <span style="font-size: 12px; font-weight: 600; color: #92400e; text-transform: uppercase;">ADMIN TRANSMITTAL ASSIGNED</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.adminTransmittalAssignedAt || 'N/A'}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #fbbf24;">
                            <span style="font-size: 12px; font-weight: 600; color: #92400e; text-transform: uppercase;">CAUSE OF DAMAGE</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.causeOfDamage}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid #fbbf24;">
                            <span style="font-size: 12px; font-weight: 600; color: #92400e; text-transform: uppercase;">RECORD ID</span>
                            <span style="font-size: 14px; color: #1e293b; font-weight: 500;">${data.id}</span>
                        </div>
                        <div style="margin-top: 20px;">
                            <div style="font-size: 12px; font-weight: 600; color: #92400e; text-transform: uppercase; margin-bottom: 8px;">REMARKS</div>
                            <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #fbbf24; min-height: 80px; max-height: 150px; overflow-y: auto; white-space: pre-wrap; font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace; font-size: 13px; line-height: 1.5; color: #374151;">${data.remarks || 'No remarks available'}</div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isModalOpen) {
            closeModal(e);
        }
    });

    document.addEventListener('click', function(e) {
        const target = e.target instanceof Element ? e.target : null;
        const viewBtn = target?.closest('.view-record-btn');
        if (viewBtn) {
            e.preventDefault();
            e.stopPropagation();
            const recordId = viewBtn.getAttribute('data-record-id');
            if (recordId) {
                openViewModal(recordId);
            }
        }
    });
})();
