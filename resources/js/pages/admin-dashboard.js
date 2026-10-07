window.toggleDashDateFilters = function () {
                            var dateType = document.getElementById('dashDateType').value;
                            document.querySelectorAll('.dash-date-filter').forEach(function(el) {
                                el.style.display = 'none';
                            });
                            if (dateType === 'single') {
                                document.getElementById('dashSingleDate').style.display = 'flex';
                            } else if (dateType === 'range') {
                                document.getElementById('dashDateRange').style.display = 'flex';
                                document.getElementById('dashDateRangeTo').style.display = 'flex';
                            }
                        };
