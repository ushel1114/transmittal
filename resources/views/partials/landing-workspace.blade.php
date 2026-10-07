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

            <form class="landing-record-filters" method="GET" action="{{ route('welcome') }}">
                <label>Farmer name
                    <input type="search" name="name" value="{{ $landingFilters['name'] ?? '' }}" placeholder="Search farmer">
                </label>
                <label>Province
                    <select name="province">
                        <option value="">All provinces</option>
                        @foreach($landingProvinces as $province)
                            <option value="{{ $province }}" @selected(($landingFilters['province'] ?? '') === $province)>{{ $province }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Municipality
                    <select name="municipality">
                        <option value="">All municipalities</option>
                        @foreach($landingMunicipalities as $municipality)
                            <option value="{{ $municipality }}" @selected(($landingFilters['municipality'] ?? '') === $municipality)>{{ $municipality }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Barangay
                    <select name="barangay">
                        <option value="">All barangays</option>
                        @foreach($landingBarangays as $barangay)
                            <option value="{{ $barangay }}" @selected(($landingFilters['barangay'] ?? '') === $barangay)>{{ $barangay }}</option>
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
                            <th>Farmer</th>
                            <th>Province</th>
                            <th>Municipality</th>
                            <th>Barangay</th>
                            <th>Source</th>
                            <th>Line</th>
                            <th>Date received</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($landingRecords as $record)
                            <tr>
                                <td title="{{ $record->farmerName }}">{{ $record->farmerName }}</td>
                                <td title="{{ $record->province }}">{{ $record->province }}</td>
                                <td title="{{ $record->municipality }}">{{ $record->municipality }}</td>
                                <td title="{{ $record->barangay }}">{{ $record->barangay }}</td>
                                <td><span class="landing-source">{{ $record->source ?: 'Unspecified' }}</span></td>
                                <td title="{{ $record->line }}">{{ $record->line }}</td>
                                <td>{{ $record->date_received ? $record->date_received->format('M d, Y') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="landing-empty">No records match the selected filters.</td></tr>
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

            <section class="landing-dashboard-summary" aria-label="Dashboard update">
                <p>TBD PA PO CURRENTLY WORKING ON IT. TY :)</p>
            </section>
        </section>
    </main>
</div>

<script>
    (function () {
        let requestSequence = 0;

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
                if (String(value).trim() !== '') {
                    url.searchParams.append(key, String(value));
                }
            }

            updateLandingRecords(url.toString(), true);
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
