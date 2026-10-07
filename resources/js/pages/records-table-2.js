document.addEventListener('DOMContentLoaded', function() {

    const recordRows = document.querySelectorAll('.record-row');

    recordRows.forEach(row => {
        row.addEventListener('click', function(e) {
            if (e.target.tagName === 'BUTTON' || e.target.tagName === 'INPUT' || e.target.tagName === 'A' || e.target.closest('button, input, a, .farmer-name-copy')) {
                return;
            }

            const isAlreadyHighlighted = this.classList.contains('highlighted');

            recordRows.forEach(r => r.classList.remove('highlighted'));

            if (!isAlreadyHighlighted) {
                this.classList.add('highlighted');
            }
        });
    });

    const dateOccurrenceFilterType = document.querySelector('select[name="date_occurrence_filter_type"]');
    const dateReceivedFilterType = document.querySelector('select[name="date_received_filter_type"]');

    if (dateOccurrenceFilterType) {
        dateOccurrenceFilterType.addEventListener('change', function() {
            const singleDiv = document.getElementById('date_occurrence_single');
            const rangeDiv = document.getElementById('date_occurrence_range');

            if (this.value === 'single') {
                singleDiv.style.display = 'block';
                rangeDiv.style.display = 'none';
            } else if (this.value === 'range') {
                singleDiv.style.display = 'none';
                rangeDiv.style.display = 'block';
            } else {
                singleDiv.style.display = 'none';
                rangeDiv.style.display = 'none';
            }
        });
    }

    if (dateReceivedFilterType) {
        dateReceivedFilterType.addEventListener('change', function() {
            const singleDiv = document.getElementById('date_received_single');
            const rangeDiv = document.getElementById('date_received_range');

            if (this.value === 'single') {
                singleDiv.style.display = 'block';
                rangeDiv.style.display = 'none';
            } else if (this.value === 'range') {
                singleDiv.style.display = 'none';
                rangeDiv.style.display = 'block';
            } else {
                singleDiv.style.display = 'none';
                rangeDiv.style.display = 'none';
            }
        });
    }
});
