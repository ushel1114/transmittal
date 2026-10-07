(function () {
            var toggle = document.getElementById('unassigned-toggle');
            var bg = document.getElementById('unassigned-toggle-bg');
            var dot = document.getElementById('unassigned-toggle-dot');

            if (toggle && bg && dot) {
                function updateToggle() {
                    if (toggle.checked) {
                        bg.style.backgroundColor = '#006c35';
                        dot.style.transform = 'translateX(24px)';
                    } else {
                        bg.style.backgroundColor = '#cbd5e1';
                        dot.style.transform = 'translateX(0)';
                    }
                }

                updateToggle();
                toggle.addEventListener('change', function() {
                    updateToggle();
                    var filterForm = document.getElementById('filter-form');
                    if (filterForm && typeof submitFilterForm === 'function') {
                        submitFilterForm();
                    }
                });
            }
        })();
