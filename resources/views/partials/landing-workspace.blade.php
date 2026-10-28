<div class="landing-page">
    <header class="landing-header">
        <div class="landing-header-brand">
            <img src="{{ asset('images/PCIC_RO3A_LOGO.jpg') }}" alt="PCIC Regional Office III-A">
            <div>
                <p>PCIC Regional Office III-A</p>
                <h1>NL Records Monitoring</h1>
            </div>
        </div>
    </header>

    <main class="landing-workspace">
        <aside class="landing-sidebar">
            <section class="landing-module-group">
                <h2 class="landing-module-title">Receiving channels</h2>
                <button type="button" class="channelLogin landing-module-link" data-channel="Facebook">
                    <img src="{{ asset('images/facebook.svg') }}" alt="" width="24" height="24">
                    <span>Facebook</span>
                    <span class="landing-module-arrow" aria-hidden="true">›</span>
                </button>
                <button type="button" class="channelLogin landing-module-link" data-channel="OD">
                    <img src="{{ asset('images/officer-of-the-day.svg') }}" alt="" width="24" height="24">
                    <span>Officer of the Day</span>
                    <span class="landing-module-arrow" aria-hidden="true">›</span>
                </button>
                <button type="button" class="channelLogin landing-module-link" data-channel="Email">
                    <img src="{{ asset('images/email.svg') }}" alt="" width="24" height="24">
                    <span>Email</span>
                    <span class="landing-module-arrow" aria-hidden="true">›</span>
                </button>
            </section>

            <section class="landing-admin-group">
                <h2 class="landing-module-title">Administration</h2>
                <button type="button" class="adminLoginButton landing-module-link">
                    <img src="{{ asset('images/admin.svg') }}" alt="" width="24" height="24">
                    <span>Administrator Login</span>
                    <span class="landing-module-arrow" aria-hidden="true">›</span>
                </button>
            </section>

            <section class="landing-dashboard-summary" aria-label="Notice of Loss summary">
                <article>
                    <span>Total NLs</span>
                    <strong>{{ number_format($landingTotalNlCount) }}</strong>
                    <small>All Notice of Loss records</small>
                </article>
                <article>
                    <span>NLs this week</span>
                    <strong>{{ number_format($landingWeeklyNlCount) }}</strong>
                    <small>Records added in the last 7 days</small>
                </article>
                <div class="landing-line-breakdown">
                    <h3>NLs by line</h3>
                    @if ($landingRecordsByLine->isNotEmpty())
                        @php
                            $maxLineCount = max((int) $landingRecordsByLine->max(), 1);
                        @endphp
                        @foreach ($landingRecordsByLine as $line => $count)
                            <div class="landing-line-row">
                                <span class="landing-line-label">{{ filled($line) ? $line : 'Unspecified' }}</span>
                                <div
                                    class="landing-line-track"
                                    role="progressbar"
                                    aria-label="{{ filled($line) ? $line : 'Unspecified' }} records"
                                    aria-valuemin="0"
                                    aria-valuemax="{{ $maxLineCount }}"
                                    aria-valuenow="{{ $count }}"
                                ><i style="width: {{ ($count / $maxLineCount) * 100 }}%">{{ number_format($count) }}</i></div>
                            </div>
                        @endforeach
                    @else
                        <p class="landing-line-empty">No line data available.</p>
                    @endif
                </div>
            </section>
        </aside>

        <section class="landing-records-panel" aria-labelledby="landingRecordsTitle">
            <div class="landing-records-header">
                <div>
                    <span class="landing-eyebrow">Public records</span>
                    <h2 id="landingRecordsTitle">All NL Records</h2>
                    <p>Search Notice of Loss records by farmer and location.</p>
                </div>
                <a href="{{ route('all-records', array_filter([
                    'farmerName' => $landingFilters['name'] ?? null,
                    'province' => $landingFilters['province'] ?? null,
                    'municipality' => $landingFilters['municipality'] ?? null,
                    'barangay' => $landingFilters['barangay'] ?? null,
                ], fn ($value) => filled($value))) }}" class="landing-open-full">
                    <span aria-hidden="true">⤢</span>
                    View full records
                </a>
            </div>

            <p data-landing-filter-error role="alert" hidden style="margin: 12px 0; color: #b42318;"></p>

            <form class="landing-record-filters" method="GET" action="{{ route('welcome') }}" data-location-options="{{ json_encode($landingLocationData, JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_TAG) }}">
                <label>Farmer name
                    <input type="search" name="name" value="{{ $landingFilters['name'] ?? '' }}" placeholder="Search farmer">
                </label>
                <label>Province
                    <select name="province">
                        <option value="">All provinces</option>
                        @foreach($landingProvinces as $province)
                            <option value="{{ $province }}" @selected(strcasecmp(trim((string) ($landingFilters['province'] ?? '')), trim($province)) === 0)>{{ $province }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Municipality
                    <select name="municipality">
                        <option value="">All municipalities</option>
                        @foreach($landingMunicipalities as $municipality)
                            <option value="{{ $municipality }}" @selected(strcasecmp(trim((string) ($landingFilters['municipality'] ?? '')), trim($municipality)) === 0)>{{ $municipality }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Barangay
                    <select name="barangay">
                        <option value="">All barangays</option>
                        @foreach($landingBarangays as $barangay)
                            <option value="{{ $barangay }}" @selected(strcasecmp(trim((string) ($landingFilters['barangay'] ?? '')), trim($barangay)) === 0)>{{ $barangay }}</option>
                        @endforeach
                    </select>
                </label>
                <div class="landing-filter-actions">
                    <button type="submit">Apply filters</button>
                    <a href="{{ route('welcome') }}">Clear</a>
                </div>
            </form>

            <div class="landing-records-summary">
                <span><strong>{{ number_format($landingTotalRecords) }}</strong> matching records</span>
                <span>Latest records first</span>
            </div>

            <div class="landing-table-scroll">
                <table class="landing-records-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Farmer</th>
                            <th>Province</th>
                            <th>Municipality</th>
                            <th>Barangay</th>
                            <th>Date received</th>
                            <th>Date of occurrence</th>
                            <th>Transmittal #</th>
                            <th>Source</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($landingRecords as $record)
                            @php
                                $viewRecordData = [
                                    'id' => $record->id,
                                    'farmerName' => $record->farmerName,
                                    'encoderName' => $record->encoderName,
                                    'source' => $record->source,
                                    'municipality' => $record->municipality,
                                    'barangay' => $record->barangay,
                                    'date_received' => $record->date_received ? \Illuminate\Support\Carbon::parse($record->date_received)->format('M d, Y') : null,
                                    'created_at' => $record->created_at?->format('M d, Y h:i A'),
                                    'admin_transmittal_number' => $record->admin_transmittal_number,
                                    'remarks' => $record->remarks,
                                    'causeOfDamage' => $record->causeOfDamage,
                                    'line' => $record->line,
                                    'modeOfPayment' => $record->modeOfPayment,
                                    'accounts' => $record->accounts,
                                    'facebook_page_url' => $record->facebook_page_url,
                                ];
                            @endphp
                            <tr>
                                <td class="landing-record-actions-cell">
                                    <div class="landing-record-actions">
                                        <button
                                            type="button"
                                            class="landing-record-action view-btn"
                                            data-record="{{ json_encode($viewRecordData, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG) }}"
                                            onclick="viewRecord(this)"
                                        >View</button>
                                        @if ($record->attachments->where('type', 'image')->isNotEmpty())
                                            <button
                                                type="button"
                                                class="notice-image-view-btn"
                                                data-image-urls="{{ $record->attachments->where('type', 'image')->map(fn ($attachment) => route('all-records.attachments.show', [$record, $attachment], false))->values()->toJson() }}"
                                                data-farmer-name="{{ $record->farmerName }}"
                                            >View / Print photos</button>
                                        @endif
                                        @foreach ($record->attachments->where('type', 'pdf') as $pdfAttachment)
                                            <a
                                                class="notice-pdf-view-btn"
                                                href="{{ route('all-records.attachments.show', [$record, $pdfAttachment], false) }}"
                                                title="View {{ $pdfAttachment->original_name }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            >View PDF</a>
                                        @endforeach
                                    </div>
                                </td>
                                <td title="{{ $record->farmerName }}">{{ $record->farmerName }}</td>
                                <td title="{{ $record->province }}">{{ $record->province }}</td>
                                <td title="{{ $record->municipality }}">{{ $record->municipality }}</td>
                                <td title="{{ $record->barangay }}">{{ $record->barangay }}</td>
                                <td>{{ $record->date_received ? $record->date_received->format('M d, Y') : 'N/A' }}</td>
                                <td>{{ $record->date_occurrence ?: 'N/A' }}</td>
                                <td>{{ $record->admin_transmittal_number ?? 'N/A' }}</td>
                                <td>{{ $record->source ?: 'Unspecified' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="landing-empty">No records match the selected filters.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="landing-records-footer">
                <span>Showing {{ $landingRecords->firstItem() ?? 0 }}–{{ $landingRecords->lastItem() ?? 0 }} of {{ number_format($landingRecords->total()) }}</span>
                <nav aria-label="Landing records pagination">
                    @if($landingRecords->onFirstPage())
                        <span class="landing-page-disabled">Previous</span>
                    @else
                        <a href="{{ $landingRecords->previousPageUrl() }}">Previous</a>
                    @endif
                    <span class="landing-page-current">Page {{ $landingRecords->currentPage() }} of {{ $landingRecords->lastPage() }}</span>
                    @if($landingRecords->hasMorePages())
                        <a href="{{ $landingRecords->nextPageUrl() }}">Next</a>
                    @else
                        <span class="landing-page-disabled">Next</span>
                    @endif
                </nav>
            </div>
        </section>
    </main>
    @include('components.record-view-dialog')
    @include('components.notice-image-print-dialog')
</div>

<script>
    (function () {
        let requestSequence = 0;
        function parseLocationOptions(form) {
            try {
                return JSON.parse(form.dataset.locationOptions || '{}');
            } catch (error) {
                console.error('Unable to read landing-page location options.', error);
                return {};
            }
        }

        function locationMatches(first, second) {
            return first.trim().toLocaleLowerCase() === second.trim().toLocaleLowerCase();
        }

        function findLocationKey(locations, value) {
            return Object.keys(locations).find(location => locationMatches(location, value)) || '';
        }

        function uniqueOptions(options) {
            const unique = new Map();
            options.forEach(option => {
                const normalizedOption = option.trim().toLocaleLowerCase();
                if (!unique.has(normalizedOption)) {
                    unique.set(normalizedOption, option);
                }
            });

            return Array.from(unique.values()).sort((first, second) => first.localeCompare(second, 'en', { sensitivity: 'base' }));
        }

        function populateLocationSelect(select, options, placeholder, selectedValue = '') {
            select.replaceChildren(new Option(placeholder, ''));

            uniqueOptions(options).forEach(option => {
                select.add(new Option(option, option));
            });

            const selectedOption = Array.from(select.options).find(option => locationMatches(option.value, selectedValue));
            select.value = selectedOption?.value || '';
        }

        function getMunicipalityOptions(locations, province) {
            if (province) {
                const provinceKey = findLocationKey(locations, province);
                return Object.keys(locations[provinceKey] || {});
            }

            return Object.values(locations).flatMap(municipalities => Object.keys(municipalities));
        }

        function getBarangayOptions(locations, province, municipality) {
            if (province) {
                const provinceKey = findLocationKey(locations, province);
                const municipalities = locations[provinceKey] || {};
                const municipalityKey = findLocationKey(municipalities, municipality);

                return municipalities[municipalityKey] || [];
            }

            return Object.values(locations).flatMap(municipalities => {
                const municipalityKey = findLocationKey(municipalities, municipality);
                return municipalities[municipalityKey] || [];
            });
        }

        function resetDependentLocationOptions(form, changedSelect) {
            const provinceSelect = form.elements.namedItem('province');
            const municipalitySelect = form.elements.namedItem('municipality');
            const barangaySelect = form.elements.namedItem('barangay');
            const locations = parseLocationOptions(form);

            if (changedSelect === provinceSelect) {
                const municipalityOptions = getMunicipalityOptions(locations, provinceSelect.value);
                populateLocationSelect(municipalitySelect, municipalityOptions, 'All municipalities');

            }

            const barangayOptions = municipalitySelect.value
                ? getBarangayOptions(locations, provinceSelect.value, municipalitySelect.value)
                : [];
            populateLocationSelect(barangaySelect, barangayOptions, 'All barangays');
        }

        async function updateLandingRecords(url, updateHistory) {
            const requestId = ++requestSequence;

            try {
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error(`Landing records request failed with status ${response.status}.`);
                }

                const html = await response.text();
                const documentFromResponse = new DOMParser().parseFromString(html, 'text/html');
                const updatedPanel = documentFromResponse.querySelector('.landing-records-panel');
                const currentPanel = document.querySelector('.landing-records-panel');

                if (!updatedPanel || !currentPanel) {
                    throw new Error('The landing records response did not contain the expected records panel.');
                }

                if (requestId !== requestSequence) {
                    return;
                }

                currentPanel.replaceWith(updatedPanel);

                if (updateHistory) {
                    window.history.pushState({}, '', url);
                }
            } catch (error) {
                if (requestId !== requestSequence) {
                    return;
                }

                console.error('Unable to update landing records.', error);
                const errorMessage = document.querySelector('[data-landing-filter-error]');
                if (errorMessage) {
                    errorMessage.textContent = 'Unable to update records without reloading. Please try again.';
                    errorMessage.hidden = false;
                }
            }
        }

        document.addEventListener('submit', function (event) {
            const form = event.target;
            if (!(form instanceof HTMLFormElement) || !form.matches('.landing-record-filters')) {
                return;
            }

            event.preventDefault();

            const url = new URL(form.action, window.location.href);
            for (const [key, value] of new FormData(form)) {
                if (['province', 'municipality', 'barangay'].includes(key) || String(value).trim() !== '') {
                    url.searchParams.set(key, String(value));
                }
            }

            updateLandingRecords(url.toString(), true);
        });

        document.addEventListener('change', function (event) {
            if (!(event.target instanceof HTMLSelectElement)) {
                return;
            }

            const form = event.target.closest('.landing-record-filters');
            if (!form || !['province', 'municipality'].includes(event.target.name)) {
                return;
            }

            resetDependentLocationOptions(form, event.target);
        });

        document.addEventListener('click', function (event) {
            if (!(event.target instanceof Element)) {
                return;
            }

            const link = event.target.closest('.landing-records-footer nav a, .landing-filter-actions a');
            if (!link || event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
                return;
            }

            event.preventDefault();
            updateLandingRecords(link.href, true);
        });

        window.addEventListener('popstate', function () {
            updateLandingRecords(window.location.href, false);
        });
    })();
</script>
