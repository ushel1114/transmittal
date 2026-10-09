const editRecordDialog = document.getElementById('recordEditDialog');
const closeEditRecordModal = document.querySelector('.closeEditRecordDialog');
const editRecordForm = document.getElementById('recordEditForm');

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('editButton') || e.target.closest('.editButton')) {
        const button = e.target.classList.contains('editButton') ? e.target : e.target.closest('.editButton');

        if (!editRecordDialog || !editRecordForm) {
            console.error('Edit dialog or form not found');
            return;
        }

        try {
            const recordId = button.getAttribute('data-id');
            const farmerName = button.getAttribute('data-farmer-name');
            const province = button.getAttribute('data-province');
            const municipality = button.getAttribute('data-municipality');
            const barangay = button.getAttribute('data-barangay');
            const address = button.getAttribute('data-address');
            const program = button.getAttribute('data-program');
            const line = button.getAttribute('data-line');
            const causeOfDamage = button.getAttribute('data-cause-of-damage');
            const modeOfPayment = button.getAttribute('data-mode-of-payment');
            const accounts = button.getAttribute('data-accounts');
            const fbPageUrl = button.getAttribute('data-fb-page-url');
            const dateOccurrence = button.getAttribute('data-date-occurrence');
            const dateReceived = button.getAttribute('data-date-received');
            const remarks = button.getAttribute('data-remarks');
            const controlNumber = button.getAttribute('data-control-number');
            const source = button.getAttribute('data-source');
            const transmittalNumber = button.getAttribute('data-transmittal-number');
            const adminTransmittalNumber = button.getAttribute('data-admin-transmittal-number');

            const farmerNameField = editRecordForm.querySelector('#farmerName');
            const editProvinceField = editRecordForm.querySelector('#editProvince');
            const editMunicipalityField = editRecordForm.querySelector('#editMunicipality');
            const editBarangayField = editRecordForm.querySelector('#editBarangay');
            const addressField = editRecordForm.querySelector('#editRecordAddress');
            const programField = editRecordForm.querySelector('#program');
            const lineField = editRecordForm.querySelector('#line');
            const causeOfDamageField = editRecordForm.querySelector('#causeOfDamage');
            const modeOfPaymentField = editRecordForm.querySelector('#modeOfPayment');
            const accountsField = editRecordForm.querySelector('#accounts');
            const fbPageUrlField = editRecordForm.querySelector('#facebook_page_url');
            const dateOccurrenceField = editRecordForm.querySelector('#date_occurrence');
            const dateReceivedField = editRecordForm.querySelector('#date_received');
            const remarksField = editRecordForm.querySelector('#remarks');
            const controlNumberField = editRecordForm.querySelector('#controlNumber');
            const transmittalNumberField = editRecordForm.querySelector('#transmittal_number');
            const adminTransmittalNumberField = editRecordForm.querySelector('#admin_transmittal_number');
            const sourceField = editRecordForm.querySelector('#source');

            if (farmerNameField) farmerNameField.value = farmerName || '';
            if (editProvinceField) editProvinceField.value = province || '';
            if (editMunicipalityField) editMunicipalityField.value = municipality || '';
            if (editBarangayField) editBarangayField.value = barangay || '';
            if (addressField) addressField.value = address || '';
            if (programField) programField.value = program || '';
            if (lineField) lineField.value = line || '';
            if (causeOfDamageField) causeOfDamageField.value = causeOfDamage || '';
            if (modeOfPaymentField) modeOfPaymentField.value = modeOfPayment || '';
            if (accountsField) accountsField.value = accounts || '';
            if (fbPageUrlField) fbPageUrlField.value = fbPageUrl || '';
            if (dateOccurrenceField) dateOccurrenceField.value = dateOccurrence || '';
            if (dateReceivedField) dateReceivedField.value = dateReceived || '';
            if (remarksField) remarksField.value = remarks || '';
            if (controlNumberField) controlNumberField.value = controlNumber || '';
            if (transmittalNumberField) transmittalNumberField.value = transmittalNumber || '';
            if (adminTransmittalNumberField) adminTransmittalNumberField.value = adminTransmittalNumber || '';
            if (sourceField) sourceField.value = source || '';

            editRecordForm.action = '/records/' + recordId;

            if (editProvinceField && editMunicipalityField && editBarangayField) {
                if (editProvinceField.value) {
                    editMunicipalityField.disabled = false;
                    const event = new Event('change');
                    editProvinceField.dispatchEvent(event);

                    if (editMunicipalityField.value) {
                        editBarangayField.disabled = false;
                        const municipalityEvent = new Event('change');
                        editMunicipalityField.dispatchEvent(municipalityEvent);
                    }
                }
            }

            editRecordDialog.showModal();
        } catch (error) {
            console.error('Error opening edit dialog:', error);
        }
    }
});

if (closeEditRecordModal && editRecordDialog) {
    closeEditRecordModal.addEventListener('click', function() {
        editRecordDialog.close();
    });
}

if (editRecordForm) {
    editRecordForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const editProvinceField = editRecordForm.querySelector('#editProvince');
        const editMunicipalityField = editRecordForm.querySelector('#editMunicipality');
        const editBarangayField = editRecordForm.querySelector('#editBarangay');
        const addressField = editRecordForm.querySelector('#editRecordAddress');
        if (editProvinceField && editMunicipalityField && editBarangayField && addressField) {
            addressField.value = [editBarangayField.value, editMunicipalityField.value, editProvinceField.value]
                .filter(Boolean)
                .join(', ');
        }

        const formData = new FormData(editRecordForm);
        if (!formData.has('_method')) {
            formData.append('_method', 'PUT');
        }
        const formAction = editRecordForm.action;

        console.log('Form action:', formAction);
        console.log('Form data:', Array.from(formData.entries()));

        const submitButton = editRecordForm.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Updating...';
        }

        fetch(formAction, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function(response) {
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
            return response.text().then(function(text) {
                console.log('Response text:', text);
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Failed to parse JSON:', e);
                    throw new Error('Invalid JSON response');
                }
            });
        })
        .then(function(data) {
            console.log('Parsed data:', data);
            if (data.success) {
                editRecordDialog.close();
                window.location.reload();
            } else {
                showModalMessage('Error updating record: ' + (data.message || 'Unknown error'), 'error');
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            showModalMessage('Error updating record. Please try again.', 'error');
        })
        .finally(function() {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = 'Update Record';
            }
        });
    });
}
