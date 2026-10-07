document.addEventListener('DOMContentLoaded', function() {
    function updateAccountStyling() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"].record-checkbox, input[type="checkbox"].record-checkbox-transmit');

        checkboxes.forEach(checkbox => {
            const row = checkbox.closest('tr');
            if (row) {
                if (checkbox.checked) {
                    row.classList.add('selected');
                } else {
                    row.classList.remove('selected');
                }
            }
        });
    }

    updateAccountStyling();

    document.addEventListener('change', function(e) {
        if (e.target.type === 'checkbox' && (e.target.classList.contains('record-checkbox') || e.target.classList.contains('record-checkbox-transmit'))) {
            const row = e.target.closest('tr');
            if (row) {
                if (e.target.checked) {
                    row.classList.add('selected');
                } else {
                    row.classList.remove('selected');
                }
            }
        }
    });

    document.addEventListener('change', function(e) {
        if (e.target.id === 'select-all' || e.target.id === 'select-all-transmit') {
            setTimeout(updateAccountStyling, 10);
        }
    });

    window.syncTableScrollbars = function() {
        const scrollTops = document.querySelectorAll('.table-scroll-sync-top');
        const scrollBottoms = document.querySelectorAll('.table-scroll-sync-bottom');

        scrollTops.forEach(function(scrollTop) {
            const scrollWrapper = scrollTop.nextElementSibling;
            const scrollSpacer = scrollTop.querySelector('.table-scroll-spacer');
            const table = scrollWrapper ? scrollWrapper.querySelector('.records-table') : null;
            const scrollBottom = scrollWrapper ? scrollWrapper.nextElementSibling : null;
            const scrollSpacerBottom = scrollBottom ? scrollBottom.querySelector('.table-scroll-spacer') : null;

            if (!scrollTop || !scrollWrapper || !scrollSpacer || !table || !scrollBottom || !scrollSpacerBottom) {
                return;
            }

            function updateSpacerWidth() {
                const tableWidth = table.scrollWidth;
                scrollSpacer.style.width = tableWidth + 'px';
                scrollSpacerBottom.style.width = tableWidth + 'px';
            }

            updateSpacerWidth();

            if (scrollWrapper.dataset.scrollSyncInitialized !== 'true') {
                function syncScrollPosition(source) {
                    scrollTop.scrollLeft = source.scrollLeft;
                    scrollWrapper.scrollLeft = source.scrollLeft;
                    scrollBottom.scrollLeft = source.scrollLeft;
                }

                scrollTop.addEventListener('scroll', function() {
                    syncScrollPosition(scrollTop);
                });

                scrollWrapper.addEventListener('scroll', function() {
                    syncScrollPosition(scrollWrapper);
                });

                scrollBottom.addEventListener('scroll', function() {
                    syncScrollPosition(scrollBottom);
                });

                scrollWrapper.dataset.scrollSyncInitialized = 'true';
            }

            if (scrollWrapper.dataset.scrollResizeInitialized !== 'true') {
                window.addEventListener('resize', updateSpacerWidth);

                if (typeof ResizeObserver !== 'undefined') {
                    const resizeObserver = new ResizeObserver(function() {
                        updateSpacerWidth();
                    });
                    resizeObserver.observe(table);
                }

                scrollWrapper.dataset.scrollResizeInitialized = 'true';
            }
        });
    }

    setTimeout(syncTableScrollbars, 100);

    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length > 0) {
                setTimeout(syncTableScrollbars, 50);
            }
        });
    });

    const tableWrappers = document.querySelectorAll('.table-wrapper');
    tableWrappers.forEach(function(tableWrapper) {
        observer.observe(tableWrapper, { childList: true, subtree: true });
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('farmer-name-copy')) {
            e.stopPropagation();
            const farmerName = e.target.getAttribute('data-farmer-name');
            if (farmerName) {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(farmerName).then(function() {
                        if (typeof showModalMessage === 'function') {
                            showModalMessage('Farmer name copied to clipboard!', 'success');
                        }
                    }).catch(function(err) {
                        console.error('Clipboard API failed, trying fallback:', err);
                        copyToClipboardFallback(farmerName);
                    });
                } else {
                    copyToClipboardFallback(farmerName);
                }
            }
        }
    });

    function copyToClipboardFallback(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.left = '-999999px';
        textarea.style.top = '-999999px';
        document.body.appendChild(textarea);
        textarea.focus();
        textarea.select();

        try {
            const successful = document.execCommand('copy');
            document.body.removeChild(textarea);
            if (successful) {
                if (typeof showModalMessage === 'function') {
                    showModalMessage('Farmer name copied to clipboard!', 'success');
                }
            } else {
                if (typeof showModalMessage === 'function') {
                    showModalMessage('Failed to copy farmer name', 'error');
                }
            }
        } catch (err) {
            console.error('Fallback copy failed:', err);
            document.body.removeChild(textarea);
            if (typeof showModalMessage === 'function') {
                showModalMessage('Failed to copy farmer name', 'error');
            }
        }
    }
});
