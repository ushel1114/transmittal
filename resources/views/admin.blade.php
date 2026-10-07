@extends('layout.layout')

@section('title', 'Admin')

@push('styles')
@vite('resources/css/pages/admin.css')
@endpush

@section('content')
    <div class="admin-shell public-workspace-shell">
        @include('partials.public-workspace-nav', ['adminNavigation' => true])

        <main class="admin-main">
            <div class="admin-topbar no-print">
                <div class="topbar-content">
                    <div class="topbar-left">
                        <div class="topbar-brand">
                            <div class="brand-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                    <path d="M2 17l10 5 10-5"/>
                                    <path d="M2 12l10 5 10-5"/>
                                </svg>
                            </div>
                            <div class="brand-text">
                                <h1>NL Records Admin</h1>
                                <p>NL monitoring and transmittal</p>
                            </div>
                        </div>
                    </div>
                    <div class="topbar-right">
                        <div class="topbar-actions">
                            <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
                                @csrf
                                <button type="submit" class="logout-btn" title="Logout">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                                        <polyline points="16,17 21,12 16,7"/>
                                        <line x1="21" y1="12" x2="9" y2="12"/>
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



    <dialog class="largeModal rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(640px,calc(100vw-2rem))]" id="adminUsersModal">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-black text-gray-900">Admin Users</h3>
            <button type="button" class="addAdminButton h-8 px-3 rounded-lg bg-pcic-700 text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Add New Admin</button>
        </div>
        <div class="px-5 py-4">
        @if($admins->isEmpty())
            <p class="text-center py-8 text-sm text-gray-400">No admin users found.</p>
        @else
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left px-3 py-2 text-xs font-bold text-gray-500 w-2/5">Username</th>
                        <th class="text-left px-3 py-2 text-xs font-bold text-gray-500 w-1/3">Password</th>
                        <th class="text-left px-3 py-2 text-xs font-bold text-gray-500 w-1/4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                        <tr class="border-b border-gray-100">
                            <td class="px-3 py-2 text-sm text-gray-800">{{ $admin->username }}</td>
                            <td class="px-3 py-2 text-sm text-gray-400">••••••••</td>
                            <td class="px-3 py-2">
                                <button type="button" class="editAdminButton h-7 px-3 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer" data-id="{{ $admin->id }}" data-username="{{ $admin->username }}">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <div class="mt-5 flex justify-end">
            <button type="button" class="closeAdminUsersModal h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Close</button>
        </div>
        </div>
    </dialog>


    <dialog class="largeModal rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(800px,calc(100vw-2rem))]" id="activeUsersModal">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Active Users</h3>
        </div>
        <div class="px-5 py-4">
            <div id="activeUsersContent">
                <div class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-pcic-700"></div>
                    <p class="text-sm text-gray-500 mt-2">Loading active users...</p>
                </div>
            </div>
            <div class="mt-5 flex justify-end">
                <button type="button" class="closeActiveUsersModal h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Close</button>
            </div>
        </div>
    </dialog>


    <dialog class="largeModal rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(500px,calc(100vw-2rem))]" id="reportsModal">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Reports</h3>
        </div>
        <div class="px-5 py-4">
            <div class="grid grid-cols-1 gap-3">
                <button type="button" class="openEncoderReportModal h-12 px-4 rounded-lg border border-gray-200 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:border-pcic-700 transition-colors cursor-pointer flex items-center justify-between">
                    <span>Encoder Report</span>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                <button type="button" class="openTransmittalReportModal h-12 px-4 rounded-lg border border-gray-200 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:border-pcic-700 transition-colors cursor-pointer flex items-center justify-between">
                    <span>Transmittal Report</span>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-5 flex justify-end">
                <button type="button" class="closeReportsModal h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Close</button>
            </div>
        </div>
    </dialog>


    <dialog class="largeModal rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(500px,calc(100vw-2rem))]" id="encoderReportModal">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Encoder Report</h3>
        </div>
        <div class="px-5 py-4">
            <form id="encoderReportForm" action="{{ route('admin.encoder-report') }}" method="GET" target="_blank">
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-700 mb-2">Select User/Officer</label>
                    <select name="user_id" required class="w-full h-10 px-3 rounded-lg border border-gray-300 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pcic-700 focus:border-transparent">
                        <option value="">-- Select User --</option>
                        @foreach($activeOfficers as $officer)
                            <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-700 mb-2">From Date</label>
                    <input type="date" name="from_date" required class="w-full h-10 px-3 rounded-lg border border-gray-300 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pcic-700 focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-700 mb-2">To Date</label>
                    <input type="date" name="to_date" required class="w-full h-10 px-3 rounded-lg border border-gray-300 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pcic-700 focus:border-transparent">
                </div>
                <div class="mt-5 flex justify-end gap-2">
                    <button type="button" class="closeEncoderReportModal h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Cancel</button>
                    <button type="submit" class="h-9 px-4 rounded-lg bg-pcic-700 text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Generate Report</button>
                </div>
            </form>
        </div>
    </dialog>


    <dialog class="largeModal rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(500px,calc(100vw-2rem))]" id="transmittalReportModal">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Transmittal Report</h3>
        </div>
        <div class="px-5 py-4">
            <form id="transmittalReportForm" action="{{ route('admin.transmittal-report') }}" method="GET" target="_blank">
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-700 mb-2">From Date</label>
                    <input type="date" name="from_date" required class="w-full h-10 px-3 rounded-lg border border-gray-300 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pcic-700 focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-700 mb-2">To Date</label>
                    <input type="date" name="to_date" required class="w-full h-10 px-3 rounded-lg border border-gray-300 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pcic-700 focus:border-transparent">
                </div>
                <div class="mt-5 flex justify-end gap-2">
                    <button type="button" class="closeTransmittalReportModal h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Cancel</button>
                    <button type="submit" class="h-9 px-4 rounded-lg bg-pcic-700 text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Generate Report</button>
                </div>
            </form>
        </div>
    </dialog>


    <div id="dashboard-section" class="admin-workspace-panel" role="region" aria-label="Dashboard" aria-hidden="false">

        @php
            $summaryDate = '';
            if(request('dash_date_type') == 'single' && request('dash_date_single')) {
                $summaryDate = date('F j, Y', strtotime(request('dash_date_single')));
            } elseif(request('dash_date_type') == 'range' && (request('dash_date_from') || request('dash_date_to'))) {
                $from = request('dash_date_from') ? date('F j, Y', strtotime(request('dash_date_from'))) : null;
                $to = request('dash_date_to') ? date('F j, Y', strtotime(request('dash_date_to'))) : null;
                if ($from && $to) {
                    $summaryDate = $from . ' to ' . $to;
                } elseif ($from) {
                    $summaryDate = 'From ' . $from;
                } elseif ($to) {
                    $summaryDate = 'Until ' . $to;
                }
            }

            $summaryProgram = request('dash_program') ? request('dash_program') : 'All Programs';
            $summaryLine = request('dash_line') ? request('dash_line') : 'All Lines';

            $dash3MetaText = $summaryProgram . ' • ' . $summaryLine . ' • ' . ($summaryDate ? $summaryDate : 'All dates');

            $provinceTables = [
                'AURORA' => $dashCountsByProvince['AURORA'] ?? [],
                'NUEVA ECIJA' => $dashCountsByProvince['NUEVA ECIJA'] ?? [],
                'TARLAC' => $dashCountsByProvince['TARLAC'] ?? [],
            ];
        @endphp

        <div class="dash3-shell">
            <div class="dash3-layout">
            <div class="admin-card no-print">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">NL Dashboard</h3>
                        <p class="card-subtitle">Aurora, Nueva Ecija and Tarlac municipality summary. Click a municipality for barangays.</p>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin') }}" class="dash3-filter-form">
                        <input type="hidden" name="tab" value="dashboard">
                        <div class="dash3-filter-row">
                            <div class="form-field">
                                <label>Program</label>
                                <select name="dash_program">
                                    <option value="">All Programs</option>
                                    @foreach($allPrograms as $program)
                                        <option value="{{ $program }}" {{ request('dash_program') == $program ? 'selected' : '' }}>{{ $program }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-field">
                                <label>Line</label>
                                <select name="dash_line">
                                    <option value="">All Lines</option>
                                    @foreach($allLines as $line)
                                        <option value="{{ $line }}" {{ request('dash_line') == $line ? 'selected' : '' }}>{{ $line }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-field">
                                <label>Date filter</label>
                                <select name="dash_date_type" id="dashDateType" onchange="toggleDashDateFilters()">
                                    <option value="">All Dates</option>
                                    <option value="single" {{ request('dash_date_type') == 'single' ? 'selected' : '' }}>Specific Date</option>
                                    <option value="range" {{ request('dash_date_type') == 'range' ? 'selected' : '' }}>Date Range</option>
                                </select>
                            </div>

                            <div class="form-field dash-date-filter" id="dashSingleDate" style="display: {{ request('dash_date_type') == 'single' ? 'flex' : 'none' }};">
                                <label>Date</label>
                                <input type="date" name="dash_date_single" value="{{ request('dash_date_single') }}">
                            </div>

                            <div class="form-field dash-date-filter" id="dashDateRange" style="display: {{ request('dash_date_type') == 'range' ? 'flex' : 'none' }};">
                                <label>From</label>
                                <input type="date" name="dash_date_from" value="{{ request('dash_date_from') }}">
                            </div>

                            <div class="form-field dash-date-filter" id="dashDateRangeTo" style="display: {{ request('dash_date_type') == 'range' ? 'flex' : 'none' }};">
                                <label>To</label>
                                <input type="date" name="dash_date_to" value="{{ request('dash_date_to') }}">
                            </div>
                        </div>

                        <div class="dash3-actions">
                            <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                            <a href="{{ route('admin', ['tab' => 'dashboard']) }}" class="btn btn-muted btn-sm">Clear</a>
                        </div>
                    </form>

                    @vite('resources/js/pages/admin-dashboard.js')

                    <div class="dash3-summary">
                        <div class="dash3-summary-title">Filters</div>
                        <div class="dash3-summary-sub">
                            {{ $summaryProgram }} • {{ $summaryDate ? $summaryDate : 'All dates' }}
                        </div>
                    </div>
                </div>
            </div>


            <div class="dash3-charts-row">
                @php
                    $chartMax = max($recordsByProgram->max() ?? 1, $recordsByLine->max() ?? 1, $recordsByMunicipality->max() ?? 1, 1);
                    $sourceTotal = $recordsBySource->sum();
                    $sourceColors = ['OD' => '#50a3a4', 'Email' => '#fcaf38', 'Facebook' => '#f95335'];
                    $lineColors = [
                        '#ae3c60',
                        '#df473c',
                        '#f3c33c',
                        '#255e79',
                        '#267778',
                        '#82b4bb',
                        '#036534'
                    ];
                    $sourceConicParts = [];
                    $sourceOffset = 0;
                    foreach (['OD', 'Email', 'Facebook'] as $src) {
                        $count = $recordsBySource->get($src, 0);
                        if ($count > 0 && $sourceTotal > 0) {
                            $pct = ($count / $sourceTotal) * 100;
                            $sourceConicParts[] = $sourceColors[$src] . ' ' . $sourceOffset . '% ' . ($sourceOffset + $pct) . '%';
                            $sourceOffset += $pct;
                        }
                    }
                    $sourceConic = count($sourceConicParts) > 0 ? implode(',', $sourceConicParts) : '#e2e8f0 0% 100%';

                    // Mode of payment chart
                    $modeOfPaymentTotal = $recordsByModeOfPayment->sum() ?? 0;
                    $modeOfPaymentColors = [
                        'CHECK' => '#10b981',
                        'PALAWAN' => '#f59e0b',
                        'GCASH' => '#3b82f6',
                        'NOT_INDICATED' => '#6b7280'
                    ];
                    $modeOfPaymentConicParts = [];
                    $modeOfPaymentOffset = 0;
                    foreach ($recordsByModeOfPayment as $mode => $count) {
                        if ($count > 0 && $modeOfPaymentTotal > 0) {
                            $pct = ($count / $modeOfPaymentTotal) * 100;
                            $color = $modeOfPaymentColors[$mode] ?? '#94a3b8';
                            $modeOfPaymentConicParts[] = $color . ' ' . $modeOfPaymentOffset . '% ' . ($modeOfPaymentOffset + $pct) . '%';
                            $modeOfPaymentOffset += $pct;
                        }
                    }
                    $modeOfPaymentConic = count($modeOfPaymentConicParts) > 0 ? implode(',', $modeOfPaymentConicParts) : '#e2e8f0 0% 100%';
                @endphp

                <div class="admin-card dash3-chart-card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">By Line</h3>
                            <p class="card-subtitle">NL count per insurance line</p>
                        </div>
                    </div>
                    <div class="card-body dash3-chart-body">
                        @php $lineIndex = 0; @endphp
                        @foreach($recordsByLine as $line => $count)
                        <div class="dash3-chart-bar-row">
                            <span class="dash3-chart-label">{{ $line }}</span>
                            <div class="dash3-chart-bar-track">
                                <div class="dash3-chart-bar-fill" style="width: {{ $chartMax > 0 ? round($count / $chartMax * 100) : 0 }}%; background: {{ $lineColors[$lineIndex % count($lineColors)] }};"></div>
                            </div>
                            <span class="dash3-chart-value">{{ number_format($count) }}</span>
                        </div>
                        @php $lineIndex++; @endphp
                        @endforeach
                        @if($recordsByLine->isEmpty())
                            <div class="dash3-empty">No data</div>
                        @endif
                    </div>
                </div>


                <div class="admin-card dash3-chart-card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">By Source</h3>
                            <p class="card-subtitle">OD vs Email vs Facebook</p>
                        </div>
                    </div>
                    <div class="card-body dash3-chart-body dash3-donut-body">
                        @if($sourceTotal > 0)
                        <div class="dash3-donut" style="background: conic-gradient({{ $sourceConic }});">
                            <div class="dash3-donut-hole">
                                <span class="dash3-donut-total">{{ number_format($sourceTotal) }}</span>
                                <span class="dash3-donut-label">total</span>
                            </div>
                        </div>
                        <div class="dash3-donut-legend">
                            @foreach(['OD', 'Email', 'Facebook'] as $src)
                            @if($recordsBySource->has($src))
                            <div class="dash3-donut-legend-item">
                                <span class="dash3-donut-dot" style="background:{{ $sourceColors[$src] }}"></span>
                                <span class="dash3-donut-legend-label">{{ $src }}</span>
                                <span class="dash3-donut-legend-value">{{ number_format($recordsBySource->get($src)) }}</span>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @else
                            <div class="dash3-empty">No data</div>
                        @endif
                    </div>
                </div>

                <div class="admin-card dash3-chart-card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">By Mode of Payment</h3>
                            <p class="card-subtitle">NL count per payment method</p>
                        </div>
                        <button type="button" class="dash3-view-more-btn" id="viewModeOfPaymentBtn">View More</button>
                    </div>
                    <div class="card-body dash3-chart-body dash3-donut-body">
                        @if($modeOfPaymentTotal > 0)
                        <div class="dash3-donut" style="background: conic-gradient({{ $modeOfPaymentConic }});">
                            <div class="dash3-donut-hole">
                                <span class="dash3-donut-total">{{ number_format($modeOfPaymentTotal) }}</span>
                                <span class="dash3-donut-label">total</span>
                            </div>
                        </div>
                        <div class="dash3-donut-legend">
                            @foreach($recordsByModeOfPayment as $mode => $count)
                            <div class="dash3-donut-legend-item">
                                <span class="dash3-donut-dot" style="background:{{ $modeOfPaymentColors[$mode] ?? '#94a3b8' }}"></span>
                                <span class="dash3-donut-legend-label">{{ ucwords(str_replace('_', ' ', $mode)) }}</span>
                                <span class="dash3-donut-legend-value">{{ number_format($count) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                            <div class="dash3-empty">No data</div>
                        @endif
                    </div>
                </div>
            </div>

            <div id="dash3-grid" class="dash3-grid">
                @foreach($provinceTables as $province => $rows)
                    @php
                        $provinceTotal = array_sum(array_map(function ($r) { return (int) ($r['count'] ?? 0); }, $rows));
                    @endphp
                    <div class="admin-card">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">{{ ucwords(strtolower($province)) }}</h3>
                                <p class="card-subtitle">Municipality • Number of NLs</p>
                                <div class="dash3-province-total">Total NLs: <span>{{ number_format($provinceTotal) }}</span></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dash3-table-wrap">
                                <table class="dash3-table">
                                    <thead>
                                        <tr>
                                            <th>Municipality</th>
                                            <th class="dash3-num">Number of NLs</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($rows as $row)
                                            <tr>
                                                <td>
                                                    <button type="button" class="dash3-muni-btn" data-province="{{ $province }}" data-municipality="{{ $row['municipality'] }}">
                                                        {{ $row['municipality'] }}
                                                    </button>
                                                </td>
                                                <td class="dash3-num">{{ number_format($row['count']) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="dash3-empty">No data for {{ $province }} with the selected filters.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            </div>

            <dialog id="dash3BarangayDialog" class="dash3-dialog">
                <div class="dash3-dialog-card">
                    <div class="dash3-dialog-header">
                        <div class="dash3-dialog-title" id="dash3DialogTitle">Barangays</div>
                        <button type="button" class="btn btn-muted btn-sm" id="dash3DialogClose">Close</button>
                    </div>
                    <div class="dash3-dialog-meta" id="dash3DialogMeta"></div>
                    <div class="dash3-dialog-body">
                        <div class="dash3-table-wrap">
                            <table class="dash3-table">
                                <thead>
                                    <tr>
                                        <th>Barangay</th>
                                        <th class="dash3-num">Number of NLs</th>
                                    </tr>
                                </thead>
                                <tbody id="dash3BarangayTbody"></tbody>
                            </table>
                        </div>
                        <div id="dash3BarangayEmpty" class="dash3-empty" style="display: none;">No barangay data found.</div>
                    </div>
                </div>
            </dialog>

            <dialog id="modeOfPaymentDialog" class="dash3-dialog">
                <div class="dash3-dialog-card">
                    <div class="dash3-dialog-header">
                        <div class="dash3-dialog-title">Top Municipalities by Mode of Payment</div>
                        <button type="button" class="btn btn-muted btn-sm" id="modeOfPaymentDialogClose">Close</button>
                    </div>
                    <div class="dash3-dialog-body">
                        <div id="modeOfPaymentContent"></div>
                    </div>
                </div>
            </dialog>

            <script>
                (function () {
                    var barangayData = @json($dashBarangayBreakdown ?? []);
                    var dialog = document.getElementById('dash3BarangayDialog');
                    var titleEl = document.getElementById('dash3DialogTitle');
                    var metaEl = document.getElementById('dash3DialogMeta');
                    var tbodyEl = document.getElementById('dash3BarangayTbody');
                    var emptyEl = document.getElementById('dash3BarangayEmpty');
                    var closeBtn = document.getElementById('dash3DialogClose');

                    if (!dialog || !titleEl || !metaEl || !tbodyEl || !emptyEl || !closeBtn) {
                        return;
                    }

                    function renderBarangays(rows) {
                        tbodyEl.innerHTML = '';
                        if (!rows || rows.length === 0) {
                            emptyEl.style.display = 'block';
                            return;
                        }
                        emptyEl.style.display = 'none';
                        rows.forEach(function (row) {
                            var tr = document.createElement('tr');
                            var td1 = document.createElement('td');
                            var td2 = document.createElement('td');
                            td1.textContent = row.barangay;
                            td2.textContent = row.count;
                            td2.className = 'dash3-num';
                            tr.appendChild(td1);
                            tr.appendChild(td2);
                            tbodyEl.appendChild(tr);
                        });
                    }

                    function openDialog(province, municipality) {
                        var rows = [];
                        if (barangayData[province] && barangayData[province][municipality]) {
                            rows = barangayData[province][municipality];
                        }
                        titleEl.textContent = municipality + ' — ' + province;
                        metaEl.textContent = @json($dash3MetaText);
                        renderBarangays(rows);
                        if (typeof dialog.showModal === 'function') {
                            dialog.showModal();
                        } else {
                            dialog.setAttribute('open', 'open');
                        }
                    }

                    document.querySelectorAll('.dash3-muni-btn').forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            openDialog(btn.dataset.province, btn.dataset.municipality);
                        });
                    });

                    closeBtn.addEventListener('click', function () {
                        dialog.close();
                    });

                    dialog.addEventListener('click', function (e) {
                        if (e.target === dialog) {
                            dialog.close();
                        }
                    });
                })();

                (function () {
                    var modeOfPaymentData = @json($modeOfPaymentMunicipalityData ?? []);
                    var mopDialog = document.getElementById('modeOfPaymentDialog');
                    var mopContent = document.getElementById('modeOfPaymentContent');
                    var mopCloseBtn = document.getElementById('modeOfPaymentDialogClose');
                    var viewMopBtn = document.getElementById('viewModeOfPaymentBtn');

                    if (!mopDialog || !mopContent || !mopCloseBtn || !viewMopBtn) {
                        return;
                    }

                    function renderModeOfPaymentData() {
                        var html = '';
                        var modeColors = {
                            'CHECK': '#10b981',
                            'PALAWAN': '#f59e0b',
                            'GCASH': '#3b82f6',
                            'NOT_INDICATED': '#6b7280'
                        };

                        var processedModes = new Set();

                        for (var mode in modeOfPaymentData) {
                            if (processedModes.has(mode)) continue;
                            processedModes.add(mode);

                            var provinces = modeOfPaymentData[mode];
                            var modeLabel = mode.replace(/_/g, ' ').toLowerCase().replace(/\b\w/g, function(l) { return l.toUpperCase(); });
                            var modeColor = modeColors[mode] || '#94a3b8';

                            html += '<div style="margin-bottom: 24px;">';
                            html += '<h4 style="font-size: 16px; font-weight: 600; color: #1e293b; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">';
                            html += '<span style="width: 12px; height: 12px; border-radius: 50%; background: ' + modeColor + ';"></span>';
                            html += modeLabel;
                            html += '</h4>';

                            var processedProvinces = new Set();

                            for (var province in provinces) {
                                if (processedProvinces.has(province)) continue;
                                processedProvinces.add(province);

                                var municipalities = provinces[province];
                                var provinceLabel = province.toLowerCase().replace(/\b\w/g, function(l) { return l.toUpperCase(); });

                                html += '<div style="margin-bottom: 16px; padding-left: 20px;">';
                                html += '<h5 style="font-size: 14px; font-weight: 600; color: #475569; margin-bottom: 8px;">' + provinceLabel + '</h5>';
                                html += '<table class="dash3-table" style="font-size: 13px;">';
                                html += '<thead><tr><th>Municipality</th><th class="dash3-num">NL Count</th></tr></thead>';
                                html += '<tbody>';

                                for (var i = 0; i < municipalities.length; i++) {
                                    var muni = municipalities[i];
                                    html += '<tr>';
                                    html += '<td>' + muni.municipality + '</td>';
                                    html += '<td class="dash3-num">' + muni.count.toLocaleString() + '</td>';
                                    html += '</tr>';
                                }

                                html += '</tbody></table>';
                                html += '</div>';
                            }

                            html += '</div>';
                        }

                        if (html === '') {
                            html = '<div class="dash3-empty">No data available.</div>';
                        }

                        mopContent.innerHTML = html;
                    }

                    viewMopBtn.addEventListener('click', function () {
                        renderModeOfPaymentData();
                        if (typeof mopDialog.showModal === 'function') {
                            mopDialog.showModal();
                        } else {
                            mopDialog.setAttribute('open', 'open');
                        }
                    });

                    mopCloseBtn.addEventListener('click', function () {
                        mopDialog.close();
                    });

                    mopDialog.addEventListener('click', function (e) {
                        if (e.target === mopDialog) {
                            mopDialog.close();
                        }
                    });
                })();
            </script>
        </div>

    </div>


    <div id="nl-records-section" class="admin-workspace-panel" role="region" aria-label="NL records" aria-hidden="true" style="display: none;">


    <div class="no-print nl-unassigned-card" style="margin-bottom: 12px; padding: 16px 20px; border-radius: 12px; background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
        <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; margin: 0;">
            <div style="position: relative; width: 48px; height: 24px;">
                <input type="checkbox" id="unassigned-toggle" {{ request()->boolean('unassigned_only') ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;" onchange="window.applyUnassignedRecordsFilter(this)">
                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ request()->boolean('unassigned_only') ? '#006c35' : '#cbd5e1' }}; transition: 0.3s; border-radius: 24px;" id="unassigned-toggle-bg"></span>
                <span style="position: absolute; cursor: pointer; content: ''; height: 18px; width: 18px; left: {{ request()->boolean('unassigned_only') ? '27px' : '3px' }}; bottom: 3px; background-color: white; transition: 0.3s; border-radius: 50%; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);" id="unassigned-toggle-dot"></span>
            </div>
            <span class="nl-unassigned-copy">
                <strong>Show records awaiting an admin transmittal</strong>
                <span>Filters the table to records that have not yet been assigned a transmittal number.</span>
            </span>
        </label>
    </div>

    <script>
        window.applyUnassignedRecordsFilter = function (toggle) {
            const url = new URL(window.location.href);

            if (toggle.checked) {
                url.searchParams.set('unassigned_only', '1');
            } else {
                url.searchParams.delete('unassigned_only');
            }

            url.searchParams.set('tab', 'nl-records');
            url.searchParams.set('page', '1');
            window.location.assign(url.toString());
        };
    </script>

    @vite('resources/js/pages/admin-unassigned-toggle.js')


    <div class="no-print table-filters" style="margin-bottom: 16px; padding: 20px; border-radius: 12px; background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
        <div class="nl-filter-heading" style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
            <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #006c35 0%, #008a43 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <svg width="18" height="18" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
            </div>
            <div>
                <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: #1e293b;">Find and filter records</h3>
                <p style="margin: 3px 0 0; font-size: 12px; color: #64748b;">Narrow the list before selecting records for transmittal.</p>
            </div>
        </div>


        <div id="active-filters-display" style="margin-bottom: 16px; padding: 12px 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; min-height: 40px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
            <span style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Active Filters:</span>
            <div id="active-filters-list" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <span id="no-filters-message" style="font-size: 13px; color: #94a3b8; font-style: italic;">No filters applied</span>
            </div>
        </div>

        @php
            $activeFilters = [];
            if(request('farmerName')) $activeFilters['Farmer'] = request('farmerName');
            if(request('encoderName')) $activeFilters['Encoder'] = request('encoderName');
            if(request('program')) $activeFilters['Program'] = request('program');
            if(request('line')) $activeFilters['Line'] = request('line');
            if(request('province')) $activeFilters['Province'] = request('province');
            if(request('municipality')) $activeFilters['Municipality'] = request('municipality');
            if(request('barangay')) $activeFilters['Barangay'] = request('barangay');
            if(request('source')) $activeFilters['Source'] = request('source');
            if(request('modeOfPayment')) $activeFilters['Mode of Payment'] = request('modeOfPayment');
            if(request('accounts')) $activeFilters['Account'] = request('accounts');
            if(request('admin_transmittal_number')) $activeFilters['Admin Transmittal'] = request('admin_transmittal_number');
            if(request('created_at')) $activeFilters['Date Created'] = request('created_at');
            if(request('date_received_type') == 'single' && request('date_single')) $activeFilters['Date Received'] = request('date_single');
            if(request('date_received_type') == 'range' && (request('date_from') || request('date_to'))) {
                $dateRange = '';
                if(request('date_from')) $dateRange .= 'From: ' . request('date_from') . ' ';
                if(request('date_to')) $dateRange .= 'To: ' . request('date_to');
                $activeFilters['Date Received'] = trim($dateRange);
            }
        @endphp

        @if(count($activeFilters) > 0)
        <div style="margin-bottom: 16px; padding: 12px 16px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 8px; color: #166534; font-weight: 600; font-size: 13px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Active Filters:</span>
            </div>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                @foreach($activeFilters as $label => $value)
                <span style="padding: 4px 10px; background: #dcfce7; color: #166534; border-radius: 6px; font-size: 12px; font-weight: 500;">
                    <strong>{{ $label }}:</strong> {{ $value }}
                </span>
                @endforeach
            </div>
        </div>
        @endif
        <form method="GET" action="{{ route('admin') }}" style="margin: 0;" id="filter-form">
            <input type="hidden" name="tab" value="nl-records">
            <input type="hidden" name="selected_transmit_ids" id="filter-selected-transmit-ids" value="{{ request('selected_transmit_ids') }}">
            <input type="hidden" name="selected_delete_ids" id="filter-selected-delete-ids" value="{{ request('selected_delete_ids') }}">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px; align-items: start;">
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Search Farmer</label>
                    <input type="text" name="farmerName" value="{{ request('farmerName') }}" style="padding: 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);" placeholder="Enter farmer name">
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Search Encoder</label>
                    <input type="text" name="encoderName" value="{{ request('encoderName') }}" style="padding: 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);" placeholder="Enter encoder name">
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px; position: relative;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Program</label>
                    <div style="position: relative;">
                        <select name="program" style="padding: 10px 36px 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); appearance: none; cursor: pointer; width: 100%;">
                            <option value="">All Programs</option>
                            @foreach($allPrograms as $program)
                            <option value="{{ $program }}" {{ request('program') == $program ? 'selected' : '' }}>{{ $program }}</option>
                            @endforeach
                        </select>
                        <svg style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; pointer-events: none; color: #64748b;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px; position: relative;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Line</label>
                    <div style="position: relative;">
                        <select name="line" style="padding: 10px 36px 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); appearance: none; cursor: pointer; width: 100%;">
                            <option value="">All Lines</option>
                            @foreach($allLines as $line)
                            <option value="{{ $line }}" {{ request('line') == $line ? 'selected' : '' }}>{{ $line }}</option>
                            @endforeach
                        </select>
                        <svg style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; pointer-events: none; color: #64748b;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px; position: relative;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Province</label>
                    <div style="position: relative;">
                        <select name="province" id="tableProvince" style="padding: 10px 36px 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); appearance: none; cursor: pointer; width: 100%;">
                            <option value="">All Provinces</option>
                            <option value="Aurora" {{ request('province') == 'Aurora' ? 'selected' : '' }}>Aurora</option>
                            <option value="Nueva Ecija" {{ request('province') == 'Nueva Ecija' ? 'selected' : '' }}>Nueva Ecija</option>
                            <option value="Tarlac" {{ request('province') == 'Tarlac' ? 'selected' : '' }}>Tarlac</option>
                        </select>
                        <svg style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; pointer-events: none; color: #64748b;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px; position: relative;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Municipality</label>
                    <div style="position: relative;">
                        <select name="municipality" id="tableMunicipality" style="padding: 10px 36px 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); appearance: none; cursor: pointer; width: 100%;">
                            <option value="">All Municipalities</option>
                        </select>
                        <svg style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; pointer-events: none; color: #64748b;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px; position: relative;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Barangay</label>
                    <div style="position: relative;">
                        <select name="barangay" id="tableBarangay" style="padding: 10px 36px 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); appearance: none; cursor: pointer; width: 100%;">
                            <option value="">All Barangays</option>
                        </select>
                        <svg style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; pointer-events: none; color: #64748b;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px; position: relative;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Source</label>
                    <div style="position: relative;">
                        <select name="source" style="padding: 10px 36px 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); appearance: none; cursor: pointer; width: 100%;">
                            <option value="">All Sources</option>
                            @foreach($allSources as $source)
                            <option value="{{ $source }}" {{ request('source') == $source ? 'selected' : '' }}>{{ $source }}</option>
                            @endforeach
                        </select>
                        <svg style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; pointer-events: none; color: #64748b;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px; position: relative;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Mode of Payment</label>
                    <div style="position: relative;">
                        <select name="modeOfPayment" style="padding: 10px 36px 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); appearance: none; cursor: pointer; width: 100%;">
                            <option value="">All Modes</option>
                            @foreach($allModes as $mode)
                            <option value="{{ $mode }}" {{ request('modeOfPayment') == $mode ? 'selected' : '' }}>{{ $mode }}</option>
                            @endforeach
                        </select>
                        <svg style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; pointer-events: none; color: #64748b;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Account</label>
                    <input type="text" name="accounts" value="{{ request('accounts') }}" style="padding: 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);" placeholder="Email / username">
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Admin Transmittal</label>
                    <input type="text" name="admin_transmittal_number" value="{{ request('admin_transmittal_number') }}" style="padding: 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);" placeholder="Enter transmittal #">
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Date Encoded</label>
                    <input type="date" name="created_at" value="{{ request('created_at') }}" style="padding: 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Date Received</label>
                    <select name="date_received_type" id="tableDateReceivedType" style="padding: 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                        <option value="">All Dates</option>
                        <option value="single" {{ request('date_received_type') == 'single' ? 'selected' : '' }}>Specific Date</option>
                        <option value="range" {{ request('date_received_type') == 'range' ? 'selected' : '' }}>Date Range</option>
                    </select>
                </div>
                <div id="tableDateReceivedSingleWrap" style="display: {{ request('date_received_type') == 'single' ? 'flex' : 'none' }}; flex-direction: column; gap: 6px;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Date</label>
                    <input type="date" name="date_single" value="{{ request('date_single') }}" style="padding: 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);" {{ request('date_received_type') == 'single' ? '' : 'disabled' }}>
                </div>
                <div id="tableDateReceivedFromWrap" style="display: {{ request('date_received_type') == 'range' ? 'flex' : 'none' }}; flex-direction: column; gap: 6px;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" style="padding: 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);" {{ request('date_received_type') == 'range' ? '' : 'disabled' }}>
                </div>
                <div id="tableDateReceivedToWrap" style="display: {{ request('date_received_type') == 'range' ? 'flex' : 'none' }}; flex-direction: column; gap: 6px;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" style="padding: 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);" {{ request('date_received_type') == 'range' ? '' : 'disabled' }}>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Rows per page</label>
                    <select name="per_page" style="padding: 10px 12px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 8px; background: #ffffff; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                        <option value="40" {{ request('per_page', '40') == '40' ? 'selected' : '' }}>40</option>
                        <option value="80" {{ request('per_page', '40') == '80' ? 'selected' : '' }}>80</option>
                        <option value="120" {{ request('per_page') == '120' ? 'selected' : '' }}>120</option>
                    </select>
                </div>
            </div>
            <div style="display: flex; gap: 12px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                <button type="button" id="apply-filters-btn" style="padding: 12px 24px; background: linear-gradient(135deg, #006c35 0%, #008a43 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; box-shadow: 0 2px 4px rgba(0, 108, 53, 0.2); transition: all 0.2s;">Apply Filters</button>
                <button type="button" id="clear-filters-shortcut-btn" style="padding: 12px 24px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; box-shadow: 0 2px 4px rgba(220, 38, 38, 0.2); transition: all 0.2s;">Clear Filters</button>
            </div>
        </form>

        <script>
            (function () {
                var typeEl = document.getElementById('tableDateReceivedType');
                var singleWrap = document.getElementById('tableDateReceivedSingleWrap');
                var fromWrap = document.getElementById('tableDateReceivedFromWrap');
                var toWrap = document.getElementById('tableDateReceivedToWrap');
                if (!typeEl || !singleWrap || !fromWrap || !toWrap) {
                    return;
                }

                function setEnabled(wrap, enabled) {
                    var input = wrap.querySelector('input');
                    if (input) {
                        input.disabled = !enabled;
                    }
                }

                function toggle() {
                    var v = typeEl.value;
                    singleWrap.style.display = (v === 'single') ? 'flex' : 'none';
                    fromWrap.style.display = (v === 'range') ? 'flex' : 'none';
                    toWrap.style.display = (v === 'range') ? 'flex' : 'none';
                    setEnabled(singleWrap, v === 'single');
                    setEnabled(fromWrap, v === 'range');
                    setEnabled(toWrap, v === 'range');
                }

                typeEl.addEventListener('change', toggle);
                toggle();
            })();

            var locationCsv = `BARANGAY,MUNICIPALITY,PROVINCE
Betes,Aliaga,Nueva Ecija
Bibiclat,Aliaga,Nueva Ecija
Bucot,Aliaga,Nueva Ecija
La Purisima,Aliaga,Nueva Ecija
Magsaysay,Aliaga,Nueva Ecija
Macabucod,Aliaga,Nueva Ecija
Pantoc,Aliaga,Nueva Ecija
Poblacion Centro,Aliaga,Nueva Ecija
Poblacion East I,Aliaga,Nueva Ecija
Poblacion East II,Aliaga,Nueva Ecija
Poblacion West III,Aliaga,Nueva Ecija
Poblacion West IV,Aliaga,Nueva Ecija
San Carlos,Aliaga,Nueva Ecija
San Emiliano,Aliaga,Nueva Ecija
San Eustacio,Aliaga,Nueva Ecija
San Felipe Bata,Aliaga,Nueva Ecija
San Felipe Matanda,Aliaga,Nueva Ecija
San Juan,Aliaga,Nueva Ecija
San Pablo Bata,Aliaga,Nueva Ecija
San Pablo Matanda,Aliaga,Nueva Ecija
Santa Monica,Aliaga,Nueva Ecija
Santiago,Aliaga,Nueva Ecija
Santo Rosario,Aliaga,Nueva Ecija
Santo Tomas,Aliaga,Nueva Ecija
Sunson,Aliaga,Nueva Ecija
Umangan,Aliaga,Nueva Ecija
Antipolo,Bongabon,Nueva Ecija
Ariendo,Bongabon,Nueva Ecija
Bantug,Bongabon,Nueva Ecija
Calaanan,Bongabon,Nueva Ecija
Commercial,Bongabon,Nueva Ecija
Cruz,Bongabon,Nueva Ecija
Digmala,Bongabon,Nueva Ecija
Curva,Bongabon,Nueva Ecija
Kaingin,Bongabon,Nueva Ecija
Labi,Bongabon,Nueva Ecija
Larcon,Bongabon,Nueva Ecija
Lusok,Bongabon,Nueva Ecija
Macabaclay,Bongabon,Nueva Ecija
Magtanggol,Bongabon,Nueva Ecija
Mantile,Bongabon,Nueva Ecija
Olivete,Bongabon,Nueva Ecija
Palo Maria,Bongabon,Nueva Ecija
Pesa,Bongabon,Nueva Ecija
Rizal,Bongabon,Nueva Ecija
Sampalucan,Bongabon,Nueva Ecija
San Roque,Bongabon,Nueva Ecija
Santor,Bongabon,Nueva Ecija
Sinipit,Bongabon,Nueva Ecija
Sisilang na Ligaya,Bongabon,Nueva Ecija
Social,Bongabon,Nueva Ecija
Tugatug,Bongabon,Nueva Ecija
Tulay na Bato,Bongabon,Nueva Ecija
Vega,Bongabon,Nueva Ecija
Aduas Centro,City of Cabanatuan,Nueva Ecija
Bagong Sikat,City of Cabanatuan,Nueva Ecija
Bagong Buhay,City of Cabanatuan,Nueva Ecija
Bakero,City of Cabanatuan,Nueva Ecija
Bakod Bayan,City of Cabanatuan,Nueva Ecija
Balite,City of Cabanatuan,Nueva Ecija
Bangad,City of Cabanatuan,Nueva Ecija
Bantug Bulalo,City of Cabanatuan,Nueva Ecija
Bantug Norte,City of Cabanatuan,Nueva Ecija
Barlis,City of Cabanatuan,Nueva Ecija
Barrera District,City of Cabanatuan,Nueva Ecija
Bernardo District,City of Cabanatuan,Nueva Ecija
Bitas,City of Cabanatuan,Nueva Ecija
Bonifacio District,City of Cabanatuan,Nueva Ecija
Buliran,City of Cabanatuan,Nueva Ecija
Caalibangbangan,City of Cabanatuan,Nueva Ecija
Cabu,City of Cabanatuan,Nueva Ecija
Campo Tinio,City of Cabanatuan,Nueva Ecija
Kapitan Pepe,City of Cabanatuan,Nueva Ecija
Cinco-Cinco,City of Cabanatuan,Nueva Ecija
City Supermarket,City of Cabanatuan,Nueva Ecija
Caudillo,City of Cabanatuan,Nueva Ecija
Communal,City of Cabanatuan,Nueva Ecija
Cruz Roja,City of Cabanatuan,Nueva Ecija
Daang Sarile,City of Cabanatuan,Nueva Ecija
Dalampang,City of Cabanatuan,Nueva Ecija
Dicarma,City of Cabanatuan,Nueva Ecija
Dimasalang,City of Cabanatuan,Nueva Ecija
Dionisio S. Garcia,City of Cabanatuan,Nueva Ecija
Fatima,City of Cabanatuan,Nueva Ecija
General Luna,City of Cabanatuan,Nueva Ecija
Ibabao Bana,City of Cabanatuan,Nueva Ecija
Imelda District,City of Cabanatuan,Nueva Ecija
Isla,City of Cabanatuan,Nueva Ecija
Calawagan,City of Cabanatuan,Nueva Ecija
Kalikid Norte,City of Cabanatuan,Nueva Ecija
Kalikid Sur,City of Cabanatuan,Nueva Ecija
Lagare,City of Cabanatuan,Nueva Ecija
M. S. Garcia,City of Cabanatuan,Nueva Ecija
Mabini Extension,City of Cabanatuan,Nueva Ecija
Mabini Homesite,City of Cabanatuan,Nueva Ecija
Macatbong,City of Cabanatuan,Nueva Ecija
Magsaysay District,City of Cabanatuan,Nueva Ecija
Matadero,City of Cabanatuan,Nueva Ecija
Lourdes,City of Cabanatuan,Nueva Ecija
Lawang Kawayan,City of Cabanatuan,Nueva Ecija
Lomboy,City of Cabanatuan,Nueva Ecija
Mabini Extension,City of Cabanatuan,Nueva Ecija
Mabini Homesite,City of Cabanatuan,Nueva Ecija
Mabini Ward,City of Cabanatuan,Nueva Ecija
Mag-Asawa,City of Cabanatuan,Nueva Ecija
Malagena,City of Cabanatuan,Nueva Ecija
Malaria,City of Cabanatuan,Nueva Ecija
Malingting,City of Cabanatuan,Nueva Ecija
Mangga,City of Cabanatuan,Nueva Ecija
Managap,City of Cabanatuan,Nueva Ecija
Manaoag,City of Cabanatuan,Nueva Ecija
Marcos District,City of Cabanatuan,Nueva Ecija
Melting Pot,City of Cabanatuan,Nueva Ecija
Minano,City of Cabanatuan,Nueva Ecija
Narvaez,City of Cabanatuan,Nueva Ecija
Ocampo,City of Cabanatuan,Nueva Ecija
Padre Burgos,City of Cabanatuan,Nueva Ecija
Paltok,City of Cabanatuan,Nueva Ecija
Pangatulan,City of Cabanatuan,Nueva Ecija
Pantay Bata,City of Cabanatuan,Nueva Ecija
Pantay Matayog,City of Cabanatuan,Nueva Ecija
Pob. Central,City of Cabanatuan,Nueva Ecija
Polilio,City of Cabanatuan,Nueva Ecija
Primera,City of Cabanatuan,Nueva Ecija
Quezon District,City of Cabanatuan,Nueva Ecija
Rizal District,City of Cabanatuan,Nueva Ecija
Rizal Extension,City of Cabanatuan,Nueva Ecija
Sanglayang,City of Cabanatuan,Nueva Ecija
San Isidro,City of Cabanatuan,Nueva Ecija
San Jose,City of Cabanatuan,Nueva Ecija
San Juan,City of Cabanatuan,Nueva Ecija
San Roque,City of Cabanatuan,Nueva Ecija
Sampaguita,City of Cabanatuan,Nueva Ecija
Sindulan,City of Cabanatuan,Nueva Ecija
Sumacab,City of Cabanatuan,Nueva Ecija
Valdez,City of Cabanatuan,Nueva Ecija
Villa Piedad,City of Cabanatuan,Nueva Ecija
Villa Verano,City of Cabanatuan,Nueva Ecija
Zabarte,City of Cabanatuan,Nueva Ecija
Mayapyap Norte,City of Cabanatuan,Nueva Ecija
Mayapyap Sur,City of Cabanatuan,Nueva Ecija
Melojavilla,City of Cabanatuan,Nueva Ecija
Obrero,City of Cabanatuan,Nueva Ecija
Padre Crisostomo,City of Cabanatuan,Nueva Ecija
Pagas,City of Cabanatuan,Nueva Ecija
Palagay,City of Cabanatuan,Nueva Ecija
Pamaldan,City of Cabanatuan,Nueva Ecija
Pangatian,City of Cabanatuan,Nueva Ecija
Patalac,City of Cabanatuan,Nueva Ecija
Pula,City of Cabanatuan,Nueva Ecija
Rizdelis,City of Cabanatuan,Nueva Ecija
Samon,City of Cabanatuan,Nueva Ecija
San Isidro,City of Cabanatuan,Nueva Ecija
San Josef Norte,City of Cabanatuan,Nueva Ecija
San Josef Sur,City of Cabanatuan,Nueva Ecija
San Juan Pob.,City of Cabanatuan,Nueva Ecija
San Roque Norte,City of Cabanatuan,Nueva Ecija
San Roque Sur,City of Cabanatuan,Nueva Ecija
Sanbermicristi,City of Cabanatuan,Nueva Ecija
Sangitan,City of Cabanatuan,Nueva Ecija
Santa Arcadia,City of Cabanatuan,Nueva Ecija
Sumacab Norte,City of Cabanatuan,Nueva Ecija
Valdefuente,City of Cabanatuan,Nueva Ecija
Valle Cruz,City of Cabanatuan,Nueva Ecija
Vijandre District,City of Cabanatuan,Nueva Ecija
Villa Ofelia-Caridad,City of Cabanatuan,Nueva Ecija
Zulueta District,City of Cabanatuan,Nueva Ecija
Nabao,City of Cabanatuan,Nueva Ecija
Padre Burgos,City of Cabanatuan,Nueva Ecija
Talipapa,City of Cabanatuan,Nueva Ecija
Aduas Norte,City of Cabanatuan,Nueva Ecija
Aduas Sur,City of Cabanatuan,Nueva Ecija
Sapang,City of Cabanatuan,Nueva Ecija
Sumacab Este,City of Cabanatuan,Nueva Ecija
Sumacab South,City of Cabanatuan,Nueva Ecija
Caridad,City of Cabanatuan,Nueva Ecija
Magsaysay South,City of Cabanatuan,Nueva Ecija
Maria Theresa,City of Cabanatuan,Nueva Ecija
Sangitan East,City of Cabanatuan,Nueva Ecija
Santo Niño,City of Cabanatuan,Nueva Ecija
Bagong Buhay,Cabiao,Nueva Ecija
Bagong Sikat,Cabiao,Nueva Ecija
Bagong Silang,Cabiao,Nueva Ecija
Concepcion,Cabiao,Nueva Ecija
Entablado,Cabiao,Nueva Ecija
Maligaya,Cabiao,Nueva Ecija
Natividad North,Cabiao,Nueva Ecija
Natividad South,Cabiao,Nueva Ecija
Palasinan,Cabiao,Nueva Ecija
San Antonio,Cabiao,Nueva Ecija
San Fernando Norte,Cabiao,Nueva Ecija
San Fernando Sur,Cabiao,Nueva Ecija
San Gregorio,Cabiao,Nueva Ecija
San Juan North,Cabiao,Nueva Ecija
San Juan South,Cabiao,Nueva Ecija
San Roque,Cabiao,Nueva Ecija
San Vicente,Cabiao,Nueva Ecija
Santa Rita,Cabiao,Nueva Ecija
Sinipit,Cabiao,Nueva Ecija
Polilio,Cabiao,Nueva Ecija
San Carlos,Cabiao,Nueva Ecija
Santa Isabel,Cabiao,Nueva Ecija
Santa Ines,Cabiao,Nueva Ecija
R.A.Padilla,Carranglan,Nueva Ecija
Bantug,Carranglan,Nueva Ecija
Bunga,Carranglan,Nueva Ecija
Burgos,Carranglan,Nueva Ecija
Capintalan,Carranglan,Nueva Ecija
Joson,Carranglan,Nueva Ecija
General Luna,Carranglan,Nueva Ecija
Minuli,Carranglan,Nueva Ecija
Piut,Carranglan,Nueva Ecija
Puncan,Carranglan,Nueva Ecija
Putlan,Carranglan,Nueva Ecija
Salazar,Carranglan,Nueva Ecija
San Agustin,Carranglan,Nueva Ecija
T. L. Padilla Pob.,Carranglan,Nueva Ecija
F. C. Otic Pob.,Carranglan,Nueva Ecija
D. L. Maglanoc Pob.,Carranglan,Nueva Ecija
G. S. Rosario Pob.,Carranglan,Nueva Ecija
Baloy,Cuyapo,Nueva Ecija
Bambanaba,Cuyapo,Nueva Ecija
Bantug,Cuyapo,Nueva Ecija
Bentigan,Cuyapo,Nueva Ecija
Bibiclat,Cuyapo,Nueva Ecija
Bonifacio,Cuyapo,Nueva Ecija
Bued,Cuyapo,Nueva Ecija
Bulala,Cuyapo,Nueva Ecija
Burgos,Cuyapo,Nueva Ecija
Cabileo,Cuyapo,Nueva Ecija
Cabatuan,Cuyapo,Nueva Ecija
Cacapasan,Cuyapo,Nueva Ecija
Calancuasan Norte,Cuyapo,Nueva Ecija
Calancuasan Sur,Cuyapo,Nueva Ecija
Colosboa,Cuyapo,Nueva Ecija
Columbitin,Cuyapo,Nueva Ecija
Curva,Cuyapo,Nueva Ecija
District I,Cuyapo,Nueva Ecija
District II,Cuyapo,Nueva Ecija
District IV,Cuyapo,Nueva Ecija
District V,Cuyapo,Nueva Ecija
District VI,Cuyapo,Nueva Ecija
District VII,Cuyapo,Nueva Ecija
District VIII,Cuyapo,Nueva Ecija
Landig,Cuyapo,Nueva Ecija
Latap,Cuyapo,Nueva Ecija
Loob,Cuyapo,Nueva Ecija
Luna,Cuyapo,Nueva Ecija
Malbeg-Patalan,Cuyapo,Nueva Ecija
Malineng,Cuyapo,Nueva Ecija
Matindeg,Cuyapo,Nueva Ecija
Maycaban,Cuyapo,Nueva Ecija
Nagcuralan,Cuyapo,Nueva Ecija
Nagmisahan,Cuyapo,Nueva Ecija
Paitan Norte,Cuyapo,Nueva Ecija
Paitan Sur,Cuyapo,Nueva Ecija
Piglisan,Cuyapo,Nueva Ecija
Pugo,Cuyapo,Nueva Ecija
Rizal,Cuyapo,Nueva Ecija
Sabit,Cuyapo,Nueva Ecija
Salagusog,Cuyapo,Nueva Ecija
San Antonio,Cuyapo,Nueva Ecija
San Jose,Cuyapo,Nueva Ecija
San Juan,Cuyapo,Nueva Ecija
Santa Clara,Cuyapo,Nueva Ecija
Santa Cruz,Cuyapo,Nueva Ecija
Simimbaan,Cuyapo,Nueva Ecija
Tagtagumbao,Cuyapo,Nueva Ecija
Tutuloy,Cuyapo,Nueva Ecija
Ungab,Cuyapo,Nueva Ecija
Villaflores,Cuyapo,Nueva Ecija
Bagong Sikat,Gabaldon,Nueva Ecija
Bagting,Gabaldon,Nueva Ecija
Bantug,Gabaldon,Nueva Ecija
Bitulok,Gabaldon,Nueva Ecija
Bugnan,Gabaldon,Nueva Ecija
Calabasa,Gabaldon,Nueva Ecija
Camachile,Gabaldon,Nueva Ecija
Cuyapa,Gabaldon,Nueva Ecija
Ligaya,Gabaldon,Nueva Ecija
Macasandal,Gabaldon,Nueva Ecija
Malinao,Gabaldon,Nueva Ecija
Pantoc,Gabaldon,Nueva Ecija
Pinamalisan,Gabaldon,Nueva Ecija
South Poblacion,Gabaldon,Nueva Ecija
Sawmill,Gabaldon,Nueva Ecija
Tagumpay,Gabaldon,Nueva Ecija
Bayanihan,City of Gapan,Nueva Ecija
Bulak,City of Gapan,Nueva Ecija
Kapalangan,City of Gapan,Nueva Ecija
Mahipon,City of Gapan,Nueva Ecija
Malimba,City of Gapan,Nueva Ecija
Mangino,City of Gapan,Nueva Ecija
Marelo,City of Gapan,Nueva Ecija
Pambuan,City of Gapan,Nueva Ecija
Parcutela,City of Gapan,Nueva Ecija
San Lorenzo,City of Gapan,Nueva Ecija
San Nicolas,City of Gapan,Nueva Ecija
San Roque,City of Gapan,Nueva Ecija
San Vicente,City of Gapan,Nueva Ecija
Santa Cruz,City of Gapan,Nueva Ecija
Santo Cristo Norte,City of Gapan,Nueva Ecija
Santo Cristo Sur,City of Gapan,Nueva Ecija
Santo Niño,City of Gapan,Nueva Ecija
Makabaclay,City of Gapan,Nueva Ecija
Balante,City of Gapan,Nueva Ecija
Bungo,City of Gapan,Nueva Ecija
Mabunga,City of Gapan,Nueva Ecija
Maburak,City of Gapan,Nueva Ecija
Puting Tubig,City of Gapan,Nueva Ecija
Balangkare Norte,General Mamerto Natividad,Nueva Ecija
Balangkare Sur,General Mamerto Natividad,Nueva Ecija
Balaring,General Mamerto Natividad,Nueva Ecija
Belen,General Mamerto Natividad,Nueva Ecija
Bravo,General Mamerto Natividad,Nueva Ecija
Burol,General Mamerto Natividad,Nueva Ecija
Kabulihan,General Mamerto Natividad,Nueva Ecija
Mag-asawang Sampaloc,General Mamerto Natividad,Nueva Ecija
Manarog,General Mamerto Natividad,Nueva Ecija
Mataas na Kahoy,General Mamerto Natividad,Nueva Ecija
Panacsac,General Mamerto Natividad,Nueva Ecija
Picaleon,General Mamerto Natividad,Nueva Ecija
Pinahan,General Mamerto Natividad,Nueva Ecija
Platero,General Mamerto Natividad,Nueva Ecija
Poblacion,General Mamerto Natividad,Nueva Ecija
Pula,General Mamerto Natividad,Nueva Ecija
Pulong Singkamas,General Mamerto Natividad,Nueva Ecija
Sapang Bato,General Mamerto Natividad,Nueva Ecija
Talabutab Norte,General Mamerto Natividad,Nueva Ecija
Talabutab Sur,General Mamerto Natividad,Nueva Ecija
Bago,General Tinio,Nueva Ecija
Concepcion,General Tinio,Nueva Ecija
Nazareth,General Tinio,Nueva Ecija
Padolina,General Tinio,Nueva Ecija
Pias,General Tinio,Nueva Ecija
San Pedro,General Tinio,Nueva Ecija
Poblacion East,General Tinio,Nueva Ecija
Poblacion West,General Tinio,Nueva Ecija
Rio Chico,General Tinio,Nueva Ecija
Poblacion Central,General Tinio,Nueva Ecija
Pulong Matong,General Tinio,Nueva Ecija
Sampaguita,General Tinio,Nueva Ecija
Palale,General Tinio,Nueva Ecija
Agcano,Guimba,Nueva Ecija
Ayos Lomboy,Guimba,Nueva Ecija
Bacayao,Guimba,Nueva Ecija
Bagong Barrio,Guimba,Nueva Ecija
Balbalino,Guimba,Nueva Ecija
Balingog East,Guimba,Nueva Ecija
Balingog West,Guimba,Nueva Ecija
Banitan,Guimba,Nueva Ecija
Bantug,Guimba,Nueva Ecija
Bulakid,Guimba,Nueva Ecija
Caballero,Guimba,Nueva Ecija
Cabaruan,Guimba,Nueva Ecija
Caingin Tabing Ilog,Guimba,Nueva Ecija
Calem,Guimba,Nueva Ecija
Camiing,Guimba,Nueva Ecija
Cardinal,Guimba,Nueva Ecija
Casongsong,Guimba,Nueva Ecija
Catimon,Guimba,Nueva Ecija
Cavite,Guimba,Nueva Ecija
Cawayan Bugtong,Guimba,Nueva Ecija
Consuelo,Guimba,Nueva Ecija
Culong,Guimba,Nueva Ecija
Escano,Guimba,Nueva Ecija
Faigal,Guimba,Nueva Ecija
Galvan,Guimba,Nueva Ecija
Guiset,Guimba,Nueva Ecija
Lamorito,Guimba,Nueva Ecija
Lennec,Guimba,Nueva Ecija
Macamias,Guimba,Nueva Ecija
Macapabellag,Guimba,Nueva Ecija
Macatcatuit,Guimba,Nueva Ecija
Manacsac,Guimba,Nueva Ecija
Manggang Marikit,Guimba,Nueva Ecija
Maturanoc,Guimba,Nueva Ecija
Maybubon,Guimba,Nueva Ecija
Naglabrahan,Guimba,Nueva Ecija
Nagpandayan,Guimba,Nueva Ecija
Narvacan I,Guimba,Nueva Ecija
Narvacan II,Guimba,Nueva Ecija
Pacac,Guimba,Nueva Ecija
Partida I,Guimba,Nueva Ecija
Partida II,Guimba,Nueva Ecija
Pasong Inchic,Guimba,Nueva Ecija
Saint John District,Guimba,Nueva Ecija
San Agustin,Guimba,Nueva Ecija
San Andres,Guimba,Nueva Ecija
San Bernardino,Guimba,Nueva Ecija
San Marcelino,Guimba,Nueva Ecija
San Miguel,Guimba,Nueva Ecija
San Rafael,Guimba,Nueva Ecija
San Roque,Guimba,Nueva Ecija
Santa Ana,Guimba,Nueva Ecija
Santa Cruz,Guimba,Nueva Ecija
Santa Lucia,Guimba,Nueva Ecija
Santa Veronica District,Guimba,Nueva Ecija
Santo Cristo District,Guimba,Nueva Ecija
Saranay District,Guimba,Nueva Ecija
Sinulatan,Guimba,Nueva Ecija
Subol,Guimba,Nueva Ecija
Tampac I,Guimba,Nueva Ecija
Tampac II & III,Guimba,Nueva Ecija
Triala,Guimba,Nueva Ecija
Yuson,Guimba,Nueva Ecija
Bunol,Guimba,Nueva Ecija
Calabasa,Jaen,Nueva Ecija
Dampulan,Jaen,Nueva Ecija
Hilera,Jaen,Nueva Ecija
Imbunia,Jaen,Nueva Ecija
Imelda Pob.,Jaen,Nueva Ecija
Lambakin,Jaen,Nueva Ecija
Langla,Jaen,Nueva Ecija
Magsalisi,Jaen,Nueva Ecija
Malabon-Kaingin,Jaen,Nueva Ecija
Marawa,Jaen,Nueva Ecija
Don Mariano Marcos,Jaen,Nueva Ecija
San Josef,Jaen,Nueva Ecija
Niyugan,Jaen,Nueva Ecija
Pamacpacan,Jaen,Nueva Ecija
Pakol,Jaen,Nueva Ecija
Pinanggaan,Jaen,Nueva Ecija
Ulanin-Pitak,Jaen,Nueva Ecija
Putlod,Jaen,Nueva Ecija
Ocampo-Rivera District,Jaen,Nueva Ecija
San Jose,Jaen,Nueva Ecija
San Pablo,Jaen,Nueva Ecija
San Roque,Jaen,Nueva Ecija
San Vicente,Jaen,Nueva Ecija
Santa Rita,Jaen,Nueva Ecija
Santo Tomas North,Jaen,Nueva Ecija
Santo Tomas South,Jaen,Nueva Ecija
Sapang,Jaen,Nueva Ecija
Barangay I,Laur,Nueva Ecija
Barangay II,Laur,Nueva Ecija
Barangay III,Laur,Nueva Ecija
Barangay IV,Laur,Nueva Ecija
Betania,Laur,Nueva Ecija
Canantong,Laur,Nueva Ecija
Nauzon,Laur,Nueva Ecija
Pangarulong,Laur,Nueva Ecija
Pinagbayanan,Laur,Nueva Ecija
Sagana,Laur,Nueva Ecija
San Fernando,Laur,Nueva Ecija
San Isidro,Laur,Nueva Ecija
San Josef,Laur,Nueva Ecija
San Juan,Laur,Nueva Ecija
San Vicente,Laur,Nueva Ecija
Siclong,Laur,Nueva Ecija
San Felipe,Laur,Nueva Ecija
Linao,Licab,Nueva Ecija
Poblacion Norte,Licab,Nueva Ecija
Poblacion Sur,Licab,Nueva Ecija
San Casimiro,Licab,Nueva Ecija
San Cristobal,Licab,Nueva Ecija
San Jose,Licab,Nueva Ecija
San Juan,Licab,Nueva Ecija
Santa Maria,Licab,Nueva Ecija
Tabing Ilog,Licab,Nueva Ecija
Villarosa,Licab,Nueva Ecija
Aquino,Licab,Nueva Ecija
A. Bonifacio,Llanera,Nueva Ecija
Caridad Norte,Llanera,Nueva Ecija
Caridad Sur,Llanera,Nueva Ecija
Casile,Llanera,Nueva Ecija
Florida Blanca,Llanera,Nueva Ecija
General Luna,Llanera,Nueva Ecija
General Ricarte,Llanera,Nueva Ecija
Gomez,Llanera,Nueva Ecija
Inanama,Llanera,Nueva Ecija
Ligaya,Llanera,Nueva Ecija
Mabini,Llanera,Nueva Ecija
Murcon,Llanera,Nueva Ecija
Plaridel,Llanera,Nueva Ecija
Bagumbayan,Llanera,Nueva Ecija
San Felipe,Llanera,Nueva Ecija
San Francisco,Llanera,Nueva Ecija
San Nicolas,Llanera,Nueva Ecija
San Vicente,Llanera,Nueva Ecija
Santa Barbara,Llanera,Nueva Ecija
Victoria,Llanera,Nueva Ecija
Villa Viniegas,Llanera,Nueva Ecija
Bosque,Llanera,Nueva Ecija
Agupalo Este,Lupao,Nueva Ecija
Agupalo Weste,Lupao,Nueva Ecija
Alalay Chica,Lupao,Nueva Ecija
Alalay Grande,Lupao,Nueva Ecija
J. U. Tienzo,Lupao,Nueva Ecija
Bagong Flores,Lupao,Nueva Ecija
Balbalungao,Lupao,Nueva Ecija
Burgos,Lupao,Nueva Ecija
Cordero,Lupao,Nueva Ecija
Mapangpang,Lupao,Nueva Ecija
Namulandayan,Lupao,Nueva Ecija
Parista,Lupao,Nueva Ecija
Poblacion East,Lupao,Nueva Ecija
Poblacion North,Lupao,Nueva Ecija
Poblacion South,Lupao,Nueva Ecija
Poblacion West,Lupao,Nueva Ecija
Salvacion I,Lupao,Nueva Ecija
Salvacion II,Lupao,Nueva Ecija
San Antonio Este,Lupao,Nueva Ecija
San Antonio Weste,Lupao,Nueva Ecija
San Isidro,Lupao,Nueva Ecija
San Pedro,Lupao,Nueva Ecija
San Roque,Lupao,Nueva Ecija
Santo Domingo,Lupao,Nueva Ecija
Bagong Sikat,Science City of Muñoz,Nueva Ecija
Balante,Science City of Muñoz,Nueva Ecija
Bantug,Science City of Muñoz,Nueva Ecija
Bical,Science City of Muñoz,Nueva Ecija
Cabisuculan,Science City of Muñoz,Nueva Ecija
Calabalabaan,Science City of Muñoz,Nueva Ecija
Calisitan,Science City of Muñoz,Nueva Ecija
Catalanacan,Science City of Muñoz,Nueva Ecija
Curva,Science City of Muñoz,Nueva Ecija
Franza,Science City of Muñoz,Nueva Ecija
Gabaldon,Science City of Muñoz,Nueva Ecija
Labney,Science City of Muñoz,Nueva Ecija
Licaong,Science City of Muñoz,Nueva Ecija
Linglingay,Science City of Muñoz,Nueva Ecija
Mangandingay,Science City of Muñoz,Nueva Ecija
Magtanggol,Science City of Muñoz,Nueva Ecija
Maligaya,Science City of Muñoz,Nueva Ecija
Mapangpang,Science City of Muñoz,Nueva Ecija
Maragol,Science City of Muñoz,Nueva Ecija
Matingkis,Science City of Muñoz,Nueva Ecija
Naglabrahan,Science City of Muñoz,Nueva Ecija
Palusapis,Science City of Muñoz,Nueva Ecija
Pandalla,Science City of Muñoz,Nueva Ecija
Poblacion East,Science City of Muñoz,Nueva Ecija
Poblacion North,Science City of Muñoz,Nueva Ecija
Poblacion South,Science City of Muñoz,Nueva Ecija
Poblacion West,Science City of Muñoz,Nueva Ecija
Rang-ayan,Science City of Muñoz,Nueva Ecija
Rizal,Science City of Muñoz,Nueva Ecija
San Andres,Science City of Muñoz,Nueva Ecija
San Antonio,Science City of Muñoz,Nueva Ecija
San Felipe,Science City of Muñoz,Nueva Ecija
Sapang Cawayan,Science City of Muñoz,Nueva Ecija
Villa Isla,Science City of Muñoz,Nueva Ecija
Villa Nati,Science City of Muñoz,Nueva Ecija
Villa Santos,Science City of Muñoz,Nueva Ecija
Villa Cuizon,Science City of Muñoz,Nueva Ecija
Alemania,Nampicuan,Nueva Ecija
Ambasador Alzate Village,Nampicuan,Nueva Ecija
Cabaducan East,Nampicuan,Nueva Ecija
Cabaducan West,Nampicuan,Nueva Ecija
Cabawangan,Nampicuan,Nueva Ecija
East Central Poblacion,Nampicuan,Nueva Ecija
Edy,Nampicuan,Nueva Ecija
Maeling,Nampicuan,Nueva Ecija
Mayantoc,Nampicuan,Nueva Ecija
Medico,Nampicuan,Nueva Ecija
Monic,Nampicuan,Nueva Ecija
North Poblacion,Nampicuan,Nueva Ecija
Northwest Poblacion,Nampicuan,Nueva Ecija
Estacion,Nampicuan,Nueva Ecija
West Poblacion,Nampicuan,Nueva Ecija
Recuerdo,Nampicuan,Nueva Ecija
South Central Poblacion,Nampicuan,Nueva Ecija
Southeast Poblacion,Nampicuan,Nueva Ecija
Southwest Poblacion,Nampicuan,Nueva Ecija
Tony,Nampicuan,Nueva Ecija
West Central Poblacion,Nampicuan,Nueva Ecija
Aulo,City of Palayan,Nueva Ecija
Bo. Militar,City of Palayan,Nueva Ecija
Ganaderia,City of Palayan,Nueva Ecija
Maligaya,City of Palayan,Nueva Ecija
Manacnac,City of Palayan,Nueva Ecija
Mapait,City of Palayan,Nueva Ecija
Marcos Village,City of Palayan,Nueva Ecija
Malate,City of Palayan,Nueva Ecija
Sapang Buho,City of Palayan,Nueva Ecija
Singalat,City of Palayan,Nueva Ecija
Atate,City of Palayan,Nueva Ecija
Caballero,City of Palayan,Nueva Ecija
Caimito,City of Palayan,Nueva Ecija
Doña Josefa,City of Palayan,Nueva Ecija
Imelda Valley,City of Palayan,Nueva Ecija
Langka,City of Palayan,Nueva Ecija
Santolan,City of Palayan,Nueva Ecija
Popolon Pagas,City of Palayan,Nueva Ecija
Bagong Buhay,City of Palayan,Nueva Ecija
Cadaclan,Pantabangan,Nueva Ecija
Cambitala,Pantabangan,Nueva Ecija
Conversion,Pantabangan,Nueva Ecija
Ganduz,Pantabangan,Nueva Ecija
Liberty,Pantabangan,Nueva Ecija
Malbang,Pantabangan,Nueva Ecija
Marikit,Pantabangan,Nueva Ecija
Napon-Napon,Pantabangan,Nueva Ecija
Poblacion East,Pantabangan,Nueva Ecija
Poblacion West,Pantabangan,Nueva Ecija
Sampaloc,Pantabangan,Nueva Ecija
San Juan,Pantabangan,Nueva Ecija
Villarica,Pantabangan,Nueva Ecija
Fatima,Pantabangan,Nueva Ecija
Callos,Peñaranda,Nueva Ecija
Las Piñas,Peñaranda,Nueva Ecija
Poblacion I,Peñaranda,Nueva Ecija
Poblacion II,Peñaranda,Nueva Ecija
Poblacion III,Peñaranda,Nueva Ecija
Poblacion IV,Peñaranda,Nueva Ecija
Santo Tomas,Peñaranda,Nueva Ecija
Sinasajan,Peñaranda,Nueva Ecija
San Josef,Peñaranda,Nueva Ecija
San Mariano,Peñaranda,Nueva Ecija
Bertese,Quezon,Nueva Ecija
Doña Lucia,Quezon,Nueva Ecija
Dulong Bayan,Quezon,Nueva Ecija
Ilog Baliwag,Quezon,Nueva Ecija
Barangay I,Quezon,Nueva Ecija
Barangay II,Quezon,Nueva Ecija
Pulong Bahay,Quezon,Nueva Ecija
San Alejandro,Quezon,Nueva Ecija
San Andres I,Quezon,Nueva Ecija
San Andres II,Quezon,Nueva Ecija
San Manuel,Quezon,Nueva Ecija
Santa Clara,Quezon,Nueva Ecija
Santa Rita,Quezon,Nueva Ecija
Santo Cristo,Quezon,Nueva Ecija
Santo Tomas Feria,Quezon,Nueva Ecija
San Miguel,Quezon,Nueva Ecija
Agbannawag,Rizal,Nueva Ecija
Bicos,Rizal,Nueva Ecija
Cabucbucan,Rizal,Nueva Ecija
Calaocan District,Rizal,Nueva Ecija
Canaan East,Rizal,Nueva Ecija
Canaan West,Rizal,Nueva Ecija
Casilagan,Rizal,Nueva Ecija
Aglipay,Rizal,Nueva Ecija
Del Pilar,Rizal,Nueva Ecija
Estrella,Rizal,Nueva Ecija
General Luna,Rizal,Nueva Ecija
Macapsing,Rizal,Nueva Ecija
Maligaya,Rizal,Nueva Ecija
Paco Roman,Rizal,Nueva Ecija
Pag-asa,Rizal,Nueva Ecija
Poblacion Central,Rizal,Nueva Ecija
Poblacion East,Rizal,Nueva Ecija
Poblacion Norte,Rizal,Nueva Ecija
Poblacion Sur,Rizal,Nueva Ecija
Poblacion West,Rizal,Nueva Ecija
Portal,Rizal,Nueva Ecija
San Esteban,Rizal,Nueva Ecija
Santa Monica,Rizal,Nueva Ecija
Villa Labrador,Rizal,Nueva Ecija
Villa Paraiso,Rizal,Nueva Ecija
San Gregorio,Rizal,Nueva Ecija
Buliran,San Antonio,Nueva Ecija
Cama Juan,San Antonio,Nueva Ecija
Julo,San Antonio,Nueva Ecija
Lawang Kupang,San Antonio,Nueva Ecija
Luyos,San Antonio,Nueva Ecija
Maugat,San Antonio,Nueva Ecija
Panabingan,San Antonio,Nueva Ecija
Papaya,San Antonio,Nueva Ecija
Poblacion,San Antonio,Nueva Ecija
San Francisco,San Antonio,Nueva Ecija
San Jose,San Antonio,Nueva Ecija
San Mariano,San Antonio,Nueva Ecija
Santa Cruz,San Antonio,Nueva Ecija
Santo Cristo,San Antonio,Nueva Ecija
Santa Barbara,San Antonio,Nueva Ecija
Tikiw,San Antonio,Nueva Ecija
Alua,San Isidro,Nueva Ecija
Calaba,San Isidro,Nueva Ecija
Malapit,San Isidro,Nueva Ecija
Mangga,San Isidro,Nueva Ecija
Poblacion,San Isidro,Nueva Ecija
Pulo,San Isidro,Nueva Ecija
San Roque,San Isidro,Nueva Ecija
Sto. Cristo,San Isidro,Nueva Ecija
Tabon,San Isidro,Nueva Ecija
A. Pascual,San Jose City,Nueva Ecija
Abar Ist,San Jose City,Nueva Ecija
Abar 2nd,San Jose City,Nueva Ecija
Bagong Sikat,San Jose City,Nueva Ecija
Caanawan,San Jose City,Nueva Ecija
Calaocan,San Jose City,Nueva Ecija
Camanacsacan,San Jose City,Nueva Ecija
Culaylay,San Jose City,Nueva Ecija
Dizol,San Jose City,Nueva Ecija
Kaliwanagan,San Jose City,Nueva Ecija
Kita-Kita,San Jose City,Nueva Ecija
Malasin,San Jose City,Nueva Ecija
Manicla,San Jose City,Nueva Ecija
Palestina,San Jose City,Nueva Ecija
Parang Mangga,San Jose City,Nueva Ecija
Villa Joson,San Jose City,Nueva Ecija
Pinili,San Jose City,Nueva Ecija
Ferdinand E. Marcos Pob.,San Jose City,Nueva Ecija
Canuto Ramos Pob.,San Jose City,Nueva Ecija
Raymundo Eugenio Pob.,San Jose City,Nueva Ecija
Crisanto Sanchez Pob.,San Jose City,Nueva Ecija
Porais,San Jose City,Nueva Ecija
San Agustin,San Jose City,Nueva Ecija
San Juan,San Jose City,Nueva Ecija
San Mauricio,San Jose City,Nueva Ecija
Santo Niño 1st,San Jose City,Nueva Ecija
Santo Niño 2nd,San Jose City,Nueva Ecija
Santo Tomas,San Jose City,Nueva Ecija
Sibut,San Jose City,Nueva Ecija
Sinipit Bubon,San Jose City,Nueva Ecija
Santo Niño 3rd,San Jose City,Nueva Ecija
Tabulac,San Jose City,Nueva Ecija
Tayabo,San Jose City,Nueva Ecija
Tondod,San Jose City,Nueva Ecija
Tulat,San Jose City,Nueva Ecija
Villa Floresca,San Jose City,Nueva Ecija
Villa Marina,San Jose City,Nueva Ecija
Bonifacio District,San Leonardo,Nueva Ecija
Burgos District,San Leonardo,Nueva Ecija
Castellano,San Leonardo,Nueva Ecija
Diversion,San Leonardo,Nueva Ecija
Magpapalayoc,San Leonardo,Nueva Ecija
Mallorca,San Leonardo,Nueva Ecija
Mambangnan,San Leonardo,Nueva Ecija
Nieves,San Leonardo,Nueva Ecija
San Bartolome,San Leonardo,Nueva Ecija
Rizal District,San Leonardo,Nueva Ecija
San Anton,San Leonardo,Nueva Ecija
San Roque,San Leonardo,Nueva Ecija
Tabuating,San Leonardo,Nueva Ecija
Tagumpay,San Leonardo,Nueva Ecija
Tambo Adorable,San Leonardo,Nueva Ecija
Cojuangco,Santa Rosa,Nueva Ecija
La Fuente,Santa Rosa,Nueva Ecija
Liwayway,Santa Rosa,Nueva Ecija
Malacañang,Santa Rosa,Nueva Ecija
Maliolio,Santa Rosa,Nueva Ecija
Mapalad,Santa Rosa,Nueva Ecija
Rizal,Santa Rosa,Nueva Ecija
Rajal Centro,Santa Rosa,Nueva Ecija
Rajal Norte,Santa Rosa,Nueva Ecija
Rajal Sur,Santa Rosa,Nueva Ecija
San Gregorio,Santa Rosa,Nueva Ecija
San Mariano,Santa Rosa,Nueva Ecija
San Pedro,Santa Rosa,Nueva Ecija
Santo Rosario,Santa Rosa,Nueva Ecija
Soledad,Santa Rosa,Nueva Ecija
Valenzuela,Santa Rosa,Nueva Ecija
Zamora,Santa Rosa,Nueva Ecija
Aguinaldo,Santa Rosa,Nueva Ecija
Berang,Santa Rosa,Nueva Ecija
Burgos,Santa Rosa,Nueva Ecija
Del Pilar,Santa Rosa,Nueva Ecija
Gomez,Santa Rosa,Nueva Ecija
Inspector,Santa Rosa,Nueva Ecija
Isla,Santa Rosa,Nueva Ecija
Lourdes,Santa Rosa,Nueva Ecija
Luna,Santa Rosa,Nueva Ecija
Mabini,Santa Rosa,Nueva Ecija
San Isidro,Santa Rosa,Nueva Ecija
San Josep,Santa Rosa,Nueva Ecija
Santa Teresita,Santa Rosa,Nueva Ecija
Sapsap,Santa Rosa,Nueva Ecija
Tagpos,Santa Rosa,Nueva Ecija
Tramo,Santa Rosa,Nueva Ecija
Baloc,Santo Domingo,Nueva Ecija
Buasao,Santo Domingo,Nueva Ecija
Burgos,Santo Domingo,Nueva Ecija
Cabugao,Santo Domingo,Nueva Ecija
Casulucan,Santo Domingo,Nueva Ecija
Comitang,Santo Domingo,Nueva Ecija
Concepcion,Santo Domingo,Nueva Ecija
Dolores,Santo Domingo,Nueva Ecija
General Luna,Santo Domingo,Nueva Ecija
Hulo,Santo Domingo,Nueva Ecija
Mabini,Santo Domingo,Nueva Ecija
Malasin,Santo Domingo,Nueva Ecija
Malayantoc,Santo Domingo,Nueva Ecija
Mambarao,Santo Domingo,Nueva Ecija
Poblacion,Santo Domingo,Nueva Ecija
Malaya,Santo Domingo,Nueva Ecija
Pulong Buli,Santo Domingo,Nueva Ecija
Sagaba,Santo Domingo,Nueva Ecija
San Agustin,Santo Domingo,Nueva Ecija
San Fabian,Santo Domingo,Nueva Ecija
San Francisco,Santo Domingo,Nueva Ecija
San Pascual,Santo Domingo,Nueva Ecija
Santa Rita,Santo Domingo,Nueva Ecija
Santo Rosario,Santo Domingo,Nueva Ecija
Andal Alino,Talavera,Nueva Ecija
Bagong Sikat,Talavera,Nueva Ecija
Bagong Silang,Talavera,Nueva Ecija
Bakal I,Talavera,Nueva Ecija
Bakal II,Talavera,Nueva Ecija
Bakal III,Talavera,Nueva Ecija
Baluga,Talavera,Nueva Ecija
Bantug,Talavera,Nueva Ecija
Bantug Hacienda,Talavera,Nueva Ecija
Bantug Hamog,Talavera,Nueva Ecija
Bugtong na Buli,Talavera,Nueva Ecija
Bulac,Talavera,Nueva Ecija
Burnay,Talavera,Nueva Ecija
Calipahan,Talavera,Nueva Ecija
Campos,Talavera,Nueva Ecija
Casulucan Este,Talavera,Nueva Ecija
Collado,Talavera,Nueva Ecija
Dimasalang Norte,Talavera,Nueva Ecija
Dimasalang Sur,Talavera,Nueva Ecija
Dinarayat,Talavera,Nueva Ecija
Esguerra District,Talavera,Nueva Ecija
Gulod,Talavera,Nueva Ecija
Homestead I,Talavera,Nueva Ecija
Homestead II,Talavera,Nueva Ecija
Cabubulaonan,Talavera,Nueva Ecija
Caaniplahan,Talavera,Nueva Ecija
Caputican,Talavera,Nueva Ecija
Kinalanguyan,Talavera,Nueva Ecija
La Torre,Talavera,Nueva Ecija
Lomboy,Talavera,Nueva Ecija
Mabuhay,Talavera,Nueva Ecija
Maestrang Kikay,Talavera,Nueva Ecija
Mamandil,Talavera,Nueva Ecija
Marcos District,Talavera,Nueva Ecija
Purok Matias,Talavera,Nueva Ecija
Matingkis,Talavera,Nueva Ecija
Minabuyoc,Talavera,Nueva Ecija
Pag-asa,Talavera,Nueva Ecija
Paludpod,Talavera,Nueva Ecija
Pantoc Bulac,Talavera,Nueva Ecija
Pinagpanaan,Talavera,Nueva Ecija
Poblacion Sur,Talavera,Nueva Ecija
Pula,Talavera,Nueva Ecija
Pulong San Miguel,Talavera,Nueva Ecija
Sampaloc,Talavera,Nueva Ecija
San Miguel na Munti,Talavera,Nueva Ecija
San Pascual,Talavera,Nueva Ecija
San Ricardo,Talavera,Nueva Ecija
Sibul,Talavera,Nueva Ecija
Sicsican Matanda,Talavera,Nueva Ecija
Tabacao,Talavera,Nueva Ecija
Tagaytay,Talavera,Nueva Ecija
Valle,Talavera,Nueva Ecija
Alula,Talugtug,Nueva Ecija
Baybayabas,Talugtug,Nueva Ecija
Buted,Talugtug,Nueva Ecija
Cabiangan,Talugtug,Nueva Ecija
Calisitan,Talugtug,Nueva Ecija
Cinense,Talugtug,Nueva Ecija
Culiat,Talugtug,Nueva Ecija
Maasin,Talugtug,Nueva Ecija
Magsaysay,Talugtug,Nueva Ecija
Mayamot I,Talugtug,Nueva Ecija
Mayamot II,Talugtug,Nueva Ecija
Nangabulan,Talugtug,Nueva Ecija
Osmeña,Talugtug,Nueva Ecija
Pangit,Talugtug,Nueva Ecija
Patola,Talugtug,Nueva Ecija
Quezon,Talugtug,Nueva Ecija
Quirino,Talugtug,Nueva Ecija
Roxas,Talugtug,Nueva Ecija
Saguing,Talugtug,Nueva Ecija
Sampaloc,Talugtug,Nueva Ecija
Santa Catalina,Talugtug,Nueva Ecija
Santo Domingo,Talugtug,Nueva Ecija
Saringaya,Talugtug,Nueva Ecija
Saverona,Talugtug,Nueva Ecija
Tandoc,Talugtug,Nueva Ecija
Tibag,Talugtug,Nueva Ecija
Villa Rosario,Talugtug,Nueva Ecija
Villa Boado,Talugtug,Nueva Ecija
Batitang,Zaragoza,Nueva Ecija
Carmen,Zaragoza,Nueva Ecija
Concepcion,Zaragoza,Nueva Ecija
Del Pilar,Zaragoza,Nueva Ecija
General Luna,Zaragoza,Nueva Ecija
H. Romero,Zaragoza,Nueva Ecija
Macarse,Zaragoza,Nueva Ecija
Manaul,Zaragoza,Nueva Ecija
Mayamot,Zaragoza,Nueva Ecija
Pantoc,Zaragoza,Nueva Ecija
San Vicente,Zaragoza,Nueva Ecija
San Isidro,Zaragoza,Nueva Ecija
San Rafael,Zaragoza,Nueva Ecija
Santa Cruz,Zaragoza,Nueva Ecija
Santa Lucia Old,Zaragoza,Nueva Ecija
Santa Lucia Young,Zaragoza,Nueva Ecija
Santo Rosario Old,Zaragoza,Nueva Ecija
Santo Rosario Young,Zaragoza,Nueva Ecija
Valeriana,Zaragoza,Nueva Ecija
Agtipalo,Baler,Aurora
Babat,Baler,Aurora
Bacong,Baler,Aurora
Baliag,Baler,Aurora
Bansaan,Baler,Aurora
Bantay,Baler,Aurora
Bukal,Baler,Aurora
Buru-Buru,Baler,Aurora
Calabuanan,Baler,Aurora
Calantas,Baler,Aurora
Calungayan,Baler,Aurora
Caniogan,Baler,Aurora
Colongcolong,Baler,Aurora
Dibalo,Baler,Aurora
Dibut,Baler,Aurora
Dimalangat,Baler,Aurora
Ditumabo,Baler,Aurora
Duongan,Baler,Aurora
Fulgador,Baler,Aurora
Sabang,Baler,Aurora
San Isidro,Baler,Aurora
San Jose,Baler,Aurora
San Luis,Baler,Aurora
San Pablo,Baler,Aurora
San Pedro,Baler,Aurora
Santa Maria,Baler,Aurora
Suklayin,Baler,Aurora
Suclayin,Baler,Aurora
Zabali,Baler,Aurora
Bato,Casiguran,Aurora
Bibitinan,Casiguran,Aurora
Bilao,Casiguran,Aurora
Biniguni,Casiguran,Aurora
Bulawit,Casiguran,Aurora
Calabgan,Casiguran,Aurora
Calatagan,Casiguran,Aurora
Culaba,Casiguran,Aurora
Dibaraybay,Casiguran,Aurora
Dibet,Casiguran,Aurora
Dikapinisan,Casiguran,Aurora
Dingasan,Casiguran,Aurora
Dita,Casiguran,Aurora
Esteves,Casiguran,Aurora
Hinipaan,Casiguran,Aurora
Ilot,Casiguran,Aurora
Lual,Casiguran,Aurora
Lual Bati,Casiguran,Aurora
Lual Malalim,Casiguran,Aurora
Marikit,Casiguran,Aurora
Molave,Casiguran,Aurora
Pinaglabasan,Casiguran,Aurora
Poblacion,Casiguran,Aurora
San Isidro,Casiguran,Aurora
Tanada,Casiguran,Aurora
Tawag,Casiguran,Aurora
Umiray,Casiguran,Aurora
Agtasa,Dilasag,Aurora
Bacong,Dilasag,Aurora
Bagto,Dilasag,Aurora
Barangay 1,Dilasag,Aurora
Barangay 2,Dilasag,Aurora
Barangay 3,Dilasag,Aurora
Barangay 4,Dilasag,Aurora
Barangay 5,Dilasag,Aurora
Barangay 6,Dilasag,Aurora
Barangay 7,Dilasag,Aurora
Barangay 8,Dilasag,Aurora
Barangay 9,Dilasag,Aurora
Barangay 10,Dilasag,Aurora
Barangay 11,Dilasag,Aurora
Calabagan,Dilasag,Aurora
Dimalangat,Dilasag,Aurora
Diwayan,Dilasag,Aurora
Ditumabo,Dilasag,Aurora
Lawang Kawayan,Dilasag,Aurora
Masese,Dilasag,Aurora
Poblacion,Dilasag,Aurora
San Isidro,Dilasag,Aurora
Tanag,Dilasag,Aurora
Yapara,Dilasag,Aurora
Babat,Dinalungan,Aurora
Bacuit,Dinalungan,Aurora
Bucay,Dinalungan,Aurora
Caragsacan,Dinalungan,Aurora
Dibaraybay,Dinalungan,Aurora
Dibet,Dinalungan,Aurora
Dimalangat,Dinalungan,Aurora
Dipaculao,Dinalungan,Aurora
Gumabat,Dinalungan,Aurora
Lual,Dinalungan,Aurora
Poblacion,Dinalungan,Aurora
Simbahan,Dinalungan,Aurora
Umiray,Dinalungan,Aurora
Yapara,Dinalungan,Aurora
Agtipalo,Dipaculao,Aurora
Babat,Dipaculao,Aurora
Bacong,Dipaculao,Aurora
Baliag,Dipaculao,Aurora
Bansaan,Dipaculao,Aurora
Bantay,Dipaculao,Aurora
Bukal,Dipaculao,Aurora
Buru-Buru,Dipaculao,Aurora
Calabuanan,Dipaculao,Aurora
Calantas,Dipaculao,Aurora
Calungayan,Dipaculao,Aurora
Caniogan,Dipaculao,Aurora
Colongcolong,Dipaculao,Aurora
Dibalo,Dipaculao,Aurora
Dibut,Dipaculao,Aurora
Dimalangat,Dipaculao,Aurora
Ditumabo,Dipaculao,Aurora
Duongan,Dipaculao,Aurora
Fulgador,Dipaculao,Aurora
Gumabat,Dipaculao,Aurora
Poblacion,Dipaculao,Aurora
Simbahan,Dipaculao,Aurora
Umiray,Dipaculao,Aurora
Yapara,Dipaculao,Aurora
Agtipalo,Maria Aurora,Aurora
Babat,Maria Aurora,Aurora
Bacong,Maria Aurora,Aurora
Baliag,Maria Aurora,Aurora
Bansaan,Maria Aurora,Aurora
Bantay,Maria Aurora,Aurora
Bukal,Maria Aurora,Aurora
Buru-Buru,Maria Aurora,Aurora
Calabuanan,Maria Aurora,Aurora
Calantas,Maria Aurora,Aurora
Calungayan,Maria Aurora,Aurora
Caniogan,Maria Aurora,Aurora
Colongcolong,Maria Aurora,Aurora
Dibalo,Maria Aurora,Aurora
Dibut,Maria Aurora,Aurora
Dimalangat,Maria Aurora,Aurora
Ditumabo,Maria Aurora,Aurora
Duongan,Maria Aurora,Aurora
Fulgador,Maria Aurora,Aurora
Gumabat,Maria Aurora,Aurora
Poblacion,Maria Aurora,Aurora
Simbahan,Maria Aurora,Aurora
Umiray,Maria Aurora,Aurora
Yapara,Maria Aurora,Aurora
Agtipalo,San Luis,Aurora
Babat,San Luis,Aurora
Bacong,San Luis,Aurora
Baliag,San Luis,Aurora
Bansaan,San Luis,Aurora
Bantay,San Luis,Aurora
Bukal,San Luis,Aurora
Buru-Buru,San Luis,Aurora
Calabuanan,San Luis,Aurora
Calantas,San Luis,Aurora
Calungayan,San Luis,Aurora
Caniogan,San Luis,Aurora
Colongcolong,San Luis,Aurora
Dibalo,San Luis,Aurora
Dibut,San Luis,Aurora
Dimalangat,San Luis,Aurora
Ditumabo,San Luis,Aurora
Duongan,San Luis,Aurora
Fulgador,San Luis,Aurora
Gumabat,San Luis,Aurora
Poblacion,San Luis,Aurora
Simbahan,San Luis,Aurora
Umiray,San Luis,Aurora
Yapara,San Luis,Aurora
Agtipalo,Dingalan,Aurora
Babat,Dingalan,Aurora
Bacong,Dingalan,Aurora
Baliag,Dingalan,Aurora
Bansaan,Dingalan,Aurora
Bantay,Dingalan,Aurora
Bukal,Dingalan,Aurora
Buru-Buru,Dingalan,Aurora
Calabuanan,Dingalan,Aurora
Calantas,Dingalan,Aurora
Calungayan,Dingalan,Aurora
Caniogan,Dingalan,Aurora
Colongcolong,Dingalan,Aurora
Dibalo,Dingalan,Aurora
Dibut,Dingalan,Aurora
Dimalangat,Dingalan,Aurora
Ditumabo,Dingalan,Aurora
Duongan,Dingalan,Aurora
Fulgador,Dingalan,Aurora
Gumabat,Dingalan,Aurora
Poblacion,Dingalan,Aurora
Simbahan,Dingalan,Aurora
Umiray,Dingalan,Aurora
Yapara,Dingalan,Aurora
Baguindoc,Anao,Tarlac
Bantog,Anao,Tarlac
Balete,Anao,Tarlac
Burog,Anao,Tarlac
Cabuluan,Anao,Tarlac
Caguay,Anao,Tarlac
Calungbuyan,Anao,Tarlac
Campos,Anao,Tarlac
Carmen,Anao,Tarlac
Casili,Anao,Tarlac
Don Ramon,Anao,Tarlac
Hernando,Anao,Tarlac
Lourdes,Anao,Tarlac
Nagrebcan,Anao,Tarlac
Poblacion,Anao,Tarlac
Rizal,Anao,Tarlac
San Francisco East,Anao,Tarlac
San Francisco West,Anao,Tarlac
San Jose North,Anao,Tarlac
San Jose South,Anao,Tarlac
San Juan,Anao,Tarlac
San Juan East,Anao,Tarlac
San Juan West,Anao,Tarlac
San Roque,Anao,Tarlac
Santo Domingo,Anao,Tarlac
Sibul,Anao,Tarlac
Silab,Anao,Tarlac
Timba,Anao,Tarlac
Tinang,Anao,Tarlac
Abang-Singit,Bamban,Tarlac
Anupul,Bamban,Tarlac
Banaba,Bamban,Tarlac
Bangcu,Bamban,Tarlac
Culubasa,Bamban,Tarlac
Dela Cruz,Bamban,Tarlac
Fatima,Bamban,Tarlac
Invisible,Bamban,Tarlac
La Paz,Bamban,Tarlac
Lourdes,Bamban,Tarlac
Maliwalo,Bamban,Tarlac
Malonzo,Bamban,Tarlac
Nagrambacan,Bamban,Tarlac
San Nicolas,Bamban,Tarlac
San Pedro,Bamban,Tarlac
San Rafael,Bamban,Tarlac
San Roque,Bamban,Tarlac
San Vicente,Bamban,Tarlac
Santo Niño,Bamban,Tarlac
Virgen de la Paz,Bamban,Tarlac
Anoling 1st,Camiling,Tarlac
Anoling 2nd,Camiling,Tarlac
Anoling 3rd,Camiling,Tarlac
Bacabac,Camiling,Tarlac
Bacsay,Camiling,Tarlac
Bagbag,Camiling,Tarlac
Bancay 1st,Camiling,Tarlac
Bancay 2nd,Camiling,Tarlac
Bilad,Camiling,Tarlac
Birbira,Camiling,Tarlac
Bobon 1st,Camiling,Tarlac
Bobon 2nd,Camiling,Tarlac
Bobon 3rd,Camiling,Tarlac
Botol,Camiling,Tarlac
Cablay,Camiling,Tarlac
Cacatian,Camiling,Tarlac
Calingcuan,Camiling,Tarlac
Capataan,Camiling,Tarlac
Coral 1st,Camiling,Tarlac
Coral 2nd,Camiling,Tarlac
Coral 3rd,Camiling,Tarlac
Coral 4th,Camiling,Tarlac
Coral 5th,Camiling,Tarlac
Coral 6th,Camiling,Tarlac
Coral 7th,Camiling,Tarlac
Coral-Cristal,Camiling,Tarlac
Culipat,Camiling,Tarlac
Curibung,Camiling,Tarlac
Dalayap,Camiling,Tarlac
Del Pilar,Camiling,Tarlac
Hacienda Mary,Camiling,Tarlac
Iba,Camiling,Tarlac
Libueg,Camiling,Tarlac
Malacampa,Camiling,Tarlac
Manupeg,Camiling,Tarlac
Matadero,Camiling,Tarlac
Nagmalitong 1st,Camiling,Tarlac
Nagmalitong 2nd,Camiling,Tarlac
Nagmalitong 3rd,Camiling,Tarlac
Nagmalitong 4th,Camiling,Tarlac
Nagmalitong 5th,Camiling,Tarlac
Nagmalitong 6th,Camiling,Tarlac
Nagrambacan,Camiling,Tarlac
Nambalan,Camiling,Tarlac
Padua,Camiling,Tarlac
Palimbo Proper,Camiling,Tarlac
Palimbo-Camiru,Camiling,Tarlac
Parabur,Camiling,Tarlac
Pindangan 1st,Camiling,Tarlac
Pindangan 2nd,Camiling,Tarlac
Pio,Camiling,Tarlac
Poblacion A,Camiling,Tarlac
Poblacion B,Camiling,Tarlac
Poblacion C,Camiling,Tarlac
Poblacion D,Camiling,Tarlac
Poblacion E,Camiling,Tarlac
Poblacion F,Camiling,Tarlac
Poblacion G,Camiling,Tarlac
Poblacion H,Camiling,Tarlac
Poblacion I,Camiling,Tarlac
Pogo,Camiling,Tarlac
Rang-ayan,Camiling,Tarlac
San Isidro,Camiling,Tarlac
San Jose,Camiling,Tarlac
San Juan,Camiling,Tarlac
San Miguel,Camiling,Tarlac
San Nicolas,Camiling,Tarlac
Santo Niño,Camiling,Tarlac
Sinait,Camiling,Tarlac
Sinulatan,Camiling,Tarlac
Subol,Camiling,Tarlac
Tabacal,Camiling,Tarlac
Buenavista,Capas,Tarlac
Burgos,Capas,Tarlac
Calibung,Capas,Tarlac
Cubcub,Capas,Tarlac
Cutcut 1st,Capas,Tarlac
Cutcut 2nd,Capas,Tarlac
Dadalay,Capas,Tarlac
Desierto,Capas,Tarlac
Dolores,Capas,Tarlac
Estrada,Capas,Tarlac
Fenas,Capas,Tarlac
Iba,Capas,Tarlac
Kinasang,Capas,Tarlac
Lawy,Capas,Tarlac
Mababanaba,Capas,Tarlac
Maruglo,Capas,Tarlac
O'Donnell,Capas,Tarlac
Patling,Capas,Tarlac
Poblacion Center,Capas,Tarlac
Poblacion East,Capas,Tarlac
Poblacion North,Capas,Tarlac
Poblacion South,Capas,Tarlac
Poblacion West,Capas,Tarlac
San Antonio,Capas,Tarlac
San Joaquin,Capas,Tarlac
Santa Juliana,Capas,Tarlac
Santa Lucia,Capas,Tarlac
Santo Cristo,Capas,Tarlac
Santo Domingo,Capas,Tarlac
Santo Niño,Capas,Tarlac
Talaga,Capas,Tarlac
Trapiche,Capas,Tarlac
Alfonso,Concepcion,Tarlac
Balutu,Concepcion,Tarlac
Cafe,Concepcion,Tarlac
Calius Gueco,Concepcion,Tarlac
Caluluan,Concepcion,Tarlac
Calingcuan,Concepcion,Tarlac
Camatbalon,Concepcion,Tarlac
Concepcion Poblacion,Concepcion,Tarlac
Corazon de Jesus,Concepcion,Tarlac
Culaylay,Concepcion,Tarlac
Dagat-dagat,Concepcion,Tarlac
Dolores,Concepcion,Tarlac
Iba,Concepcion,Tarlac
Ilog Cabe,Concepcion,Tarlac
Ilog Centro,Concepcion,Tarlac
Ilog Norte,Concepcion,Tarlac
Ilog Sur,Concepcion,Tarlac
Juan Luna,Concepcion,Tarlac
Lalo,Concepcion,Tarlac
Mabilog,Concepcion,Tarlac
Mabini,Concepcion,Tarlac
Malupa,Concepcion,Tarlac
Minane,Concepcion,Tarlac
New Santa Barbara,Concepcion,Tarlac
Paludpod,Concepcion,Tarlac
Parang,Concepcion,Tarlac
Parulang,Concepcion,Tarlac
Pinili,Concepcion,Tarlac
Plazang Toro,Concepcion,Tarlac
Poblacion Norte,Concepcion,Tarlac
Poblacion Sur,Concepcion,Tarlac
San Juan Bautista,Concepcion,Tarlac
San Martin,Concepcion,Tarlac
San Nicolas,Concepcion,Tarlac
San Vicente,Concepcion,Tarlac
Santa Lucia,Concepcion,Tarlac
Santa Monica,Concepcion,Tarlac
Santa Rita,Concepcion,Tarlac
Santo Cristo,Concepcion,Tarlac
Santo Niño,Concepcion,Tarlac
Sipat,Concepcion,Tarlac
Abagon,Gerona,Tarlac
Ablang Sapang,Gerona,Tarlac
Aglipay,Gerona,Tarlac
Amacalan,Gerona,Tarlac
Amsic,Gerona,Tarlac
Aplaya,Gerona,Tarlac
Balite,Gerona,Tarlac
Baybayabas,Gerona,Tarlac
Buenavista,Gerona,Tarlac
Cabuluan,Gerona,Tarlac
Cadsalan,Gerona,Tarlac
Calayaan,Gerona,Tarlac
Camposanto,Gerona,Tarlac
Caturay,Gerona,Tarlac
Don Basilio,Gerona,Tarlac
Gubat,Gerona,Tarlac
Lambayan,Gerona,Tarlac
Lomboy,Gerona,Tarlac
Lusca,Gerona,Tarlac
Mabini,Gerona,Tarlac
Malayantoc,Gerona,Tarlac
Mangga,Gerona,Tarlac
Mangusing,Gerona,Tarlac
Maticmatic,Gerona,Tarlac
Nagwirong,Gerona,Tarlac
Nagpandayan,Gerona,Tarlac
Padapada,Gerona,Tarlac
Palis,Gerona,Tarlac
Paluka,Gerona,Tarlac
Parang,Gerona,Tarlac
Patag,Gerona,Tarlac
Poblacion,Gerona,Tarlac
Purok,Gerona,Tarlac
Salapungan,Gerona,Tarlac
San Agustin,Gerona,Tarlac
San Antonio,Gerona,Tarlac
San Bartolome,Gerona,Tarlac
San Jose,Gerona,Tarlac
San Juan,Gerona,Tarlac
San Lucas,Gerona,Tarlac
San Miguel,Gerona,Tarlac
San Pedro,Gerona,Tarlac
Santo Niño,Gerona,Tarlac
Sibul,Gerona,Tarlac
Sibul Malaki,Gerona,Tarlac
Sibul Mangga,Gerona,Tarlac
Silang,Gerona,Tarlac
Sulipa,Gerona,Tarlac
Sulo,Gerona,Tarlac
Tagumbao,Gerona,Tarlac
Target,Gerona,Tarlac
Temperancia,Gerona,Tarlac
Toclong,Gerona,Tarlac
Toledo,Gerona,Tarlac
Tres Marias,Gerona,Tarlac
Villa Aglipay,Gerona,Tarlac
Villa Aguas,Gerona,Tarlac
Villa Flores,Gerona,Tarlac
Villa Gavino,Gerona,Tarlac
Villa Ramirez,Gerona,Tarlac
Villa Rizal,Gerona,Tarlac
Balanoy,La Paz,Tarlac
Bantog-Carait,La Paz,Tarlac
Bantog-Saluad,La Paz,Tarlac
Barangay I (Pob.),La Paz,Tarlac
Barangay II (Pob.),La Paz,Tarlac
Barangay III (Pob.),La Paz,Tarlac
Barangay IV (Pob.),La Paz,Tarlac
Barangay V (Pob.),La Paz,Tarlac
Barangay VI (Pob.),La Paz,Tarlac
Cato,La Paz,Tarlac
Colibangbang,La Paz,Tarlac
Dagao,La Paz,Tarlac
Dinep,La Paz,Tarlac
K. Murillo,La Paz,Tarlac
Labney,La Paz,Tarlac
Mabul,La Paz,Tarlac
Macalong,La Paz,Tarlac
Mayang,La Paz,Tarlac
Nagsulang,La Paz,Tarlac
Paz,La Paz,Tarlac
Rizal,La Paz,Tarlac
Ambalingit,Mayantoc,Tarlac
Baybayaoas,Mayantoc,Tarlac
Bigbiga,Mayantoc,Tarlac
Binbinaca,Mayantoc,Tarlac
Calabmayan,Mayantoc,Tarlac
Cabangiran,Mayantoc,Tarlac
Cahabaan,Mayantoc,Tarlac
Calipayan,Mayantoc,Tarlac
Canabay,Mayantoc,Tarlac
Comon,Mayantoc,Tarlac
Gayonggayong,Mayantoc,Tarlac
Guimba,Mayantoc,Tarlac
Ibguit,Mayantoc,Tarlac
Lalapangan,Mayantoc,Tarlac
Lampitak,Mayantoc,Tarlac
Libay,Mayantoc,Tarlac
Mamonit,Mayantoc,Tarlac
Mangolayon,Mayantoc,Tarlac
Mayamat,Mayantoc,Tarlac
Nambalan,Mayantoc,Tarlac
Poblacion Norte,Mayantoc,Tarlac
Poblacion Sur,Mayantoc,Tarlac
San Bartolome,Mayantoc,Tarlac
San Isidro,Mayantoc,Tarlac
Abaga,Moncada,Tarlac
Andarayan,Moncada,Tarlac
Bangar,Moncada,Tarlac
Cabuluan,Moncada,Tarlac
Calitlitan,Moncada,Tarlac
Calma,Moncada,Tarlac
Camangaan East,Moncada,Tarlac
Camangaan West,Moncada,Tarlac
Camiling,Moncada,Tarlac
Camposanto 1 Norte,Moncada,Tarlac
Camposanto 1 Sur,Moncada,Tarlac
Camposanto 2,Moncada,Tarlac
Capao,Moncada,Tarlac
Carcueva,Moncada,Tarlac
Cawayan,Moncada,Tarlac
Cawayan Bugtong,Moncada,Tarlac
Central East,Moncada,Tarlac
Central West,Moncada,Tarlac
Concepcion,Moncada,Tarlac
Dolores,Moncada,Tarlac
Don Ramon,Moncada,Tarlac
Hacienda,Moncada,Tarlac
Lapnit,Moncada,Tarlac
Longos,Moncada,Tarlac
Lourdes,Moncada,Tarlac
Mabini,Moncada,Tarlac
Mabuhay,Moncada,Tarlac
Malate,Moncada,Tarlac
Manaois,Moncada,Tarlac
Matam-is,Moncada,Tarlac
Matanlang,Moncada,Tarlac
Maysan,Moncada,Tarlac
Nampalogan,Moncada,Tarlac
Paso,Moncada,Tarlac
Poblacion I,Moncada,Tarlac
Poblacion II,Moncada,Tarlac
Poblacion III,Moncada,Tarlac
Poblacion IV,Moncada,Tarlac
Poblacion V,Moncada,Tarlac
Pula,Moncada,Tarlac
Quezon,Moncada,Tarlac
Rizal,Moncada,Tarlac
San Andres,Moncada,Tarlac
San Carlos,Moncada,Tarlac
San Juan,Moncada,Tarlac
San Leon,Moncada,Tarlac
San Miguel,Moncada,Tarlac
San Pedro,Moncada,Tarlac
San Rafael,Moncada,Tarlac
San Roque,Moncada,Tarlac
Santa Lucia,Moncada,Tarlac
Santa Maria,Moncada,Tarlac
Santo Niño,Moncada,Tarlac
Santo Tomas,Moncada,Tarlac
Sapang Maragul,Moncada,Tarlac
Tapiat,Moncada,Tarlac
Toledo,Moncada,Tarlac
Tubigan,Moncada,Tarlac
Villa Hermosa,Moncada,Tarlac
Villa Ilang-Ilang,Moncada,Tarlac
Villa Rizal,Moncada,Tarlac
Abogado,Paniqui,Tarlac
Alcalde,Paniqui,Tarlac
Bacnar,Paniqui,Tarlac
Bagong Bayan,Paniqui,Tarlac
Balanti,Paniqui,Tarlac
Bamban,Paniqui,Tarlac
Bantog,Paniqui,Tarlac
Bisaya,Paniqui,Tarlac
Bobon,Paniqui,Tarlac
Buenavista,Paniqui,Tarlac
Cabayaoasan,Paniqui,Tarlac
Cabuluan,Paniqui,Tarlac
Calingcuan,Paniqui,Tarlac
Camias,Paniqui,Tarlac
Canan,Paniqui,Tarlac
Carino,Paniqui,Tarlac
Carosalesan,Paniqui,Tarlac
Cayao,Paniqui,Tarlac
Colibangbang,Paniqui,Tarlac
Dumarais,Paniqui,Tarlac
Galeran,Paniqui,Tarlac
Garcia,Paniqui,Tarlac
Herrera,Paniqui,Tarlac
Igang,Paniqui,Tarlac
Isla,Paniqui,Tarlac
Lanting,Paniqui,Tarlac
Lomboy,Paniqui,Tarlac
Mabini,Paniqui,Tarlac
Malasa,Paniqui,Tarlac
Mangilaya,Paniqui,Tarlac
Matanlang,Paniqui,Tarlac
Nancamarinan,Paniqui,Tarlac
Naranjo,Paniqui,Tarlac
Padilla,Paniqui,Tarlac
Pagsaluhan,Paniqui,Tarlac
Pambar,Paniqui,Tarlac
Parungao,Paniqui,Tarlac
Poblacion Norte,Paniqui,Tarlac
Poblacion Sur,Paniqui,Tarlac
Ramos,Paniqui,Tarlac
Rizal,Paniqui,Tarlac
Salapungan,Paniqui,Tarlac
San Agustin,Paniqui,Tarlac
San Andres,Paniqui,Tarlac
San Benito,Paniqui,Tarlac
San Francisco,Paniqui,Tarlac
San Isidro,Paniqui,Tarlac
San Jose,Paniqui,Tarlac
San Juan de Regla,Paniqui,Tarlac
San Miguel,Paniqui,Tarlac
San Pedro,Paniqui,Tarlac
San Roque,Paniqui,Tarlac
San Vicente,Paniqui,Tarlac
Santa Barbara,Paniqui,Tarlac
Santa Cruz,Paniqui,Tarlac
Santa Rita,Paniqui,Tarlac
Santo Niño,Paniqui,Tarlac
Santo Rosario,Paniqui,Tarlac
Sapa,Paniqui,Tarlac
Sinulatan,Paniqui,Tarlac
Sulib,Paniqui,Tarlac
Tablang,Paniqui,Tarlac
Tagpos,Paniqui,Tarlac
Tibag,Paniqui,Tarlac
Tinang,Paniqui,Tarlac
Villa,Paniqui,Tarlac
Villaflores,Paniqui,Tarlac
Villanueva,Paniqui,Tarlac
Linao,Pura,Tarlac
Mabilog,Pura,Tarlac
Maasin,Pura,Tarlac
Naya,Pura,Tarlac
Nilasin 1st,Pura,Tarlac
Nilasin 2nd,Pura,Tarlac
Poblacion 1,Pura,Tarlac
Poblacion 2,Pura,Tarlac
Poblacion 3,Pura,Tarlac
Poroc,Pura,Tarlac
Rizal,Pura,Tarlac
Samput,Pura,Tarlac
Singat,Pura,Tarlac
Santo Niño 1st,Pura,Tarlac
Santo Niño 2nd,Pura,Tarlac
Santo Rosario,Pura,Tarlac
Talimundoc,Pura,Tarlac
Calilayan,Ramos,Tarlac
Comillas,Ramos,Tarlac
Guevara,Ramos,Tarlac
Kalang,Ramos,Tarlac
Lapnit,Ramos,Tarlac
Poblacion Center,Ramos,Tarlac
San Juan,Ramos,Tarlac
San Miguel,Ramos,Tarlac
San Sebastian,Ramos,Tarlac
Anonang Norte,San Clemente,Tarlac
Anonang Sur,San Clemente,Tarlac
Bagbag,San Clemente,Tarlac
Bamban,San Clemente,Tarlac
Casecnan,San Clemente,Tarlac
Cuenca,San Clemente,Tarlac
Mangandingay,San Clemente,Tarlac
Masic,San Clemente,Tarlac
Maasin,San Clemente,Tarlac
Pili,San Clemente,Tarlac
Poblacion Norte,San Clemente,Tarlac
Poblacion Sur,San Clemente,Tarlac
San Isidro,San Clemente,Tarlac
San Marcos,San Clemente,Tarlac
San Pablo,San Clemente,Tarlac
Santa Rosa,San Clemente,Tarlac
Santo Niño,San Clemente,Tarlac
Aguilar,San Jose,Tarlac
Burgos,San Jose,Tarlac
Burgos II,San Jose,Tarlac
Burgos III,San Jose,Tarlac
Calaitan,San Jose,Tarlac
Cambing,San Jose,Tarlac
Cameron,San Jose,Tarlac
Candelaria,San Jose,Tarlac
Canrubang,San Jose,Tarlac
Casilagan,San Jose,Tarlac
Corazon,San Jose,Tarlac
Fianza,San Jose,Tarlac
Iba,San Jose,Tarlac
La Consolacion,San Jose,Tarlac
Lanete,San Jose,Tarlac
Luna,San Jose,Tarlac
Mabuhay,San Jose,Tarlac
Malacampa,San Jose,Tarlac
Mangalit,San Jose,Tarlac
Maqueb,San Jose,Tarlac
Maturanoc,San Jose,Tarlac
Nambalan,San Jose,Tarlac
Pinaripad,San Jose,Tarlac
Poblacion,San Jose,Tarlac
Pulong,San Jose,Tarlac
Rizal,San Jose,Tarlac
San Agustin,San Jose,Tarlac
San Andres,San Jose,Tarlac
San Antonio,San Jose,Tarlac
San Bartolome,San Jose,Tarlac
San Fernando,San Jose,Tarlac
San Francisco,San Jose,Tarlac
San Gabriel,San Jose,Tarlac
San Isidro,San Jose,Tarlac
San Juan,San Jose,Tarlac
San Juan Bautista,San Jose,Tarlac
San Juan de Dios,San Jose,Tarlac
San Lorenzo,San Jose,Tarlac
San Luis,San Jose,Tarlac
San Manuel,San Jose,Tarlac
San Miguel,San Jose,Tarlac
San Nicolas,San Jose,Tarlac
San Pablo,San Jose,Tarlac
San Pascual,San Jose,Tarlac
San Pedro,San Jose,Tarlac
San Rafael,San Jose,Tarlac
San Roque,San Jose,Tarlac
San Sebastian,San Jose,Tarlac
San Vicente,San Jose,Tarlac
Santa Catalina,San Jose,Tarlac
Santa Cruz,San Jose,Tarlac
Santa Elena,San Jose,Tarlac
Santa Lucia,San Jose,Tarlac
Santa Maria,San Jose,Tarlac
Santa Rita,San Jose,Tarlac
Santo Cristo,San Jose,Tarlac
Santo Niño,San Jose,Tarlac
Santo Tomas,San Jose,Tarlac
Sapa,San Jose,Tarlac
Sibul,San Jose,Tarlac
Sinigpit,San Jose,Tarlac
Tabao,San Jose,Tarlac
Tagumbao,San Jose,Tarlac
Tibag,San Jose,Tarlac
Tubigan,San Jose,Tarlac
Unib,San Jose,Tarlac
Vietnamburgos,San Jose,Tarlac
Villa Aglipay,San Jose,Tarlac
Villa Concepcion,San Jose,Tarlac
Villa Estrella,San Jose,Tarlac
Villa Gonzalez,San Jose,Tarlac
Villa Maria,San Jose,Tarlac
Villa Nizza,San Jose,Tarlac
Villa Rosario,San Jose,Tarlac
Villa San Jose,San Jose,Tarlac
Abot,San Manuel,Tarlac
Aguso,San Manuel,Tarlac
Alang-alang,San Manuel,Tarlac
Baluyut,San Manuel,Tarlac
Calbalete,San Manuel,Tarlac
Calsib,San Manuel,Tarlac
Canite,San Manuel,Tarlac
Canao,San Manuel,Tarlac
Cayanga,San Manuel,Tarlac
Colibangbang,San Manuel,Tarlac
Garcia,San Manuel,Tarlac
Guevarra,San Manuel,Tarlac
Laruan,San Manuel,Tarlac
Lourdes,San Manuel,Tarlac
Manaoag,San Manuel,Tarlac
Masantol,San Manuel,Tarlac
Nabu,San Manuel,Tarlac
Padapada,San Manuel,Tarlac
Panday Pira,San Manuel,Tarlac
Pannaratan,San Manuel,Tarlac
Poblacion,San Manuel,Tarlac
Radiw,San Manuel,Tarlac
Ramos,San Manuel,Tarlac
Rizam,San Manuel,Tarlac
Salapungan,San Manuel,Tarlac
San Cristobal,San Manuel,Tarlac
San Felipe,San Manuel,Tarlac
San Gregorio,San Manuel,Tarlac
San Isidro,San Manuel,Tarlac
San Jose,San Manuel,Tarlac
San Juan,San Manuel,Tarlac
San Lucas,San Manuel,Tarlac
San Marcelino,San Manuel,Tarlac
San Martin,San Manuel,Tarlac
San Mateo,San Manuel,Tarlac
San Miguel,San Manuel,Tarlac
San Nicolas,San Manuel,Tarlac
San Pablo,San Manuel,Tarlac
San Pedro,San Manuel,Tarlac
San Rafael,San Manuel,Tarlac
San Roque,San Manuel,Tarlac
San Vicente,San Manuel,Tarlac
Santa Ana,San Manuel,Tarlac
Santa Barbara,San Manuel,Tarlac
Santa Cruz,San Manuel,Tarlac
Santa Elena,San Manuel,Tarlac
Santa Fe,San Manuel,Tarlac
Santa Isabel,San Manuel,Tarlac
Santa Lucia,San Manuel,Tarlac
Santa Maria,San Manuel,Tarlac
Santa Monica,San Manuel,Tarlac
Santa Rita,San Manuel,Tarlac
Santa Rosa,San Manuel,Tarlac
Santo Cristo,San Manuel,Tarlac
Santo Domingo,San Manuel,Tarlac
Santo Niño,San Manuel,Tarlac
Santo Tomas,San Manuel,Tarlac
Sinait,San Manuel,Tarlac
Sison,San Manuel,Tarlac
Tabar,San Manuel,Tarlac
Tagabo,San Manuel,Tarlac
Tagumbao,San Manuel,Tarlac
Talimundoc,San Manuel,Tarlac
Tampaan,San Manuel,Tarlac
Tawiran,San Manuel,Tarlac
Toledo,San Manuel,Tarlac
Ugad,San Manuel,Tarlac
Uyong,San Manuel,Tarlac
Villa Aglipay,San Manuel,Tarlac
Villa Cadia,San Manuel,Tarlac
Villa Concepcion,San Manuel,Tarlac
Villa Corazon,San Manuel,Tarlac
Villa Flores,San Manuel,Tarlac
Villa Grace,San Manuel,Tarlac
Villa Leonor,San Manuel,Tarlac
Villa Luz,San Manuel,Tarlac
Villa Paz,San Manuel,Tarlac
Villa Rita,San Manuel,Tarlac
Villa Rosario,San Manuel,Tarlac
Villa Teresa,San Manuel,Tarlac
Villa Victoria,San Manuel,Tarlac
Baldios,Santa Ignacia,Tarlac
Botbotones,Santa Ignacia,Tarlac
Caanamongan,Santa Ignacia,Tarlac
Cabaruan,Santa Ignacia,Tarlac
Cabugbugan,Santa Ignacia,Tarlac
Caduldulaoan,Santa Ignacia,Tarlac
Calipayan,Santa Ignacia,Tarlac
Macaguing,Santa Ignacia,Tarlac
Nambalan,Santa Ignacia,Tarlac
Padapada,Santa Ignacia,Tarlac
Poblacion East,Santa Ignacia,Tarlac
Poblacion West,Santa Ignacia,Tarlac
San Agustin,Santa Ignacia,Tarlac
San Antonio,Santa Ignacia,Tarlac
San Francisco,Santa Ignacia,Tarlac
San Juan,Santa Ignacia,Tarlac
San Lorenzo,Santa Ignacia,Tarlac
San Vicente,Santa Ignacia,Tarlac
Santa Ines,Santa Ignacia,Tarlac
Santa Maria,Santa Ignacia,Tarlac
Santa Rita,Santa Ignacia,Tarlac
Santo Niño,Santa Ignacia,Tarlac
Santo Tomas,Santa Ignacia,Tarlac
Sinalbagan,Santa Ignacia,Tarlac
Aguso,City of Tarlac,Tarlac
Alvindia,City of Tarlac,Tarlac
Amucao,City of Tarlac,Tarlac
Armenia,City of Tarlac,Tarlac
Asturias,City of Tarlac,Tarlac
Balete,City of Tarlac,Tarlac
Balibay I,City of Tarlac,Tarlac
Balibay II,City of Tarlac,Tarlac
Balingcanaway,City of Tarlac,Tarlac
Banaba,City of Tarlac,Tarlac
Bantog,City of Tarlac,Tarlac
Baras-Baras,City of Tarlac,Tarlac
Batang-Batang,City of Tarlac,Tarlac
Buenavista,City of Tarlac,Tarlac
Buscay,City of Tarlac,Tarlac
Calingcuan,City of Tarlac,Tarlac
Camat,City of Tarlac,Tarlac
Capao,City of Tarlac,Tarlac
Cardona,City of Tarlac,Tarlac
Caribang,City of Tarlac,Tarlac
Caringtbucal,City of Tarlac,Tarlac
Carosales,City of Tarlac,Tarlac
Castañeda,City of Tarlac,Tarlac
Concepcion,City of Tarlac,Tarlac
Cristo Rey,City of Tarlac,Tarlac
Cutcut,City of Tarlac,Tarlac
Cutud,City of Tarlac,Tarlac
Dao,City of Tarlac,Tarlac
Dela Paz,City of Tarlac,Tarlac
Embarcadero,City of Tarlac,Tarlac
Faldes,City of Tarlac,Tarlac
Falle,City of Tarlac,Tarlac
Fructuosa,City of Tarlac,Tarlac
Fulo,City of Tarlac,Tarlac
Green Village,City of Tarlac,Tarlac
Hacienda Dolores,City of Tarlac,Tarlac
Hacienda San Bartolome,City of Tarlac,Tarlac
Hacienda San Guillermo,City of Tarlac,Tarlac
Hacienda San Juan,City of Tarlac,Tarlac
Hacienda San Miguel,City of Tarlac,Tarlac
Hacienda Santa Elena,City of Tarlac,Tarlac
Hacienda Santa Ines,City of Tarlac,Tarlac
Hacienda Santa Lucia,City of Tarlac,Tarlac
Hacienda Santa Maria,City of Tarlac,Tarlac
Hacienda Santiago,City of Tarlac,Tarlac
Iba,City of Tarlac,Tarlac
Iba Este,City of Tarlac,Tarlac
Iba Oeste,City of Tarlac,Tarlac
La Paz,City of Tarlac,Tarlac
Laoag,City of Tarlac,Tarlac
Lapun Lapun,City of Tarlac,Tarlac
Lomboy,City of Tarlac,Tarlac
Lourdes,City of Tarlac,Tarlac
Lubigan,City of Tarlac,Tarlac
Luna,City of Tarlac,Tarlac
Lutao,City of Tarlac,Tarlac
Mabalot,City of Tarlac,Tarlac
Mabini,City of Tarlac,Tarlac
Mabilog,City of Tarlac,Tarlac
Macalino,City of Tarlac,Tarlac
Macamias,City of Tarlac,Tarlac
Maliwalo,City of Tarlac,Tarlac
Matatalaib,City of Tarlac,Tarlac
Mining,City of Tarlac,Tarlac
Nancamarinan,City of Tarlac,Tarlac
Ngoyog,City of Tarlac,Tarlac
Oapal,City of Tarlac,Tarlac
Paludpod,City of Tarlac,Tarlac
Parang,City of Tarlac,Tarlac
Parlas,City of Tarlac,Tarlac
Pitombayog,City of Tarlac,Tarlac
Pob. Block 1,City of Tarlac,Tarlac
Pob. Block 2,City of Tarlac,Tarlac
Pob. Block 3,City of Tarlac,Tarlac
Pob. Block 4,City of Tarlac,Tarlac
Pob. Block 5,City of Tarlac,Tarlac
Pob. Block 6,City of Tarlac,Tarlac
Pob. Block 7,City of Tarlac,Tarlac
Pob. Block 8,City of Tarlac,Tarlac
Pob. Block 9,City of Tarlac,Tarlac
Pob. Block 10,City of Tarlac,Tarlac
Pob. Block 11,City of Tarlac,Tarlac
Pob. Block 12,City of Tarlac,Tarlac
Pob. Block 13,City of Tarlac,Tarlac
Pob. Block 14,City of Tarlac,Tarlac
Pob. Block 15,City of Tarlac,Tarlac
Pob. Block 16,City of Tarlac,Tarlac
Pob. Block 17,City of Tarlac,Tarlac
Pob. Block 18,City of Tarlac,Tarlac
Pob. Block 19,City of Tarlac,Tarlac
Pob. Block 20,City of Tarlac,Tarlac
Pob. Block 21,City of Tarlac,Tarlac
Pob. Block 22,City of Tarlac,Tarlac
Pob. Block 23,City of Tarlac,Tarlac
Pob. Block 24,City of Tarlac,Tarlac
Pob. Block 25,City of Tarlac,Tarlac
Pob. Block 26,City of Tarlac,Tarlac
Pob. Block 27,City of Tarlac,Tarlac
Pob. Block 28,City of Tarlac,Tarlac
Pob. Block 29,City of Tarlac,Tarlac
Pob. Block 30,City of Tarlac,Tarlac
Pula,City of Tarlac,Tarlac
Ramirez,City of Tarlac,Tarlac
Rexville,City of Tarlac,Tarlac
Salapungan,City of Tarlac,Tarlac
San Carlos,City of Tarlac,Tarlac
San Francisco,City of Tarlac,Tarlac
San Isidro,City of Tarlac,Tarlac
San Jose,City of Tarlac,Tarlac
San Juan Bautista,City of Tarlac,Tarlac
San Juan de Mata,City of Tarlac,Tarlac
San Manuel,City of Tarlac,Tarlac
San Matias,City of Tarlac,Tarlac
San Miguel,City of Tarlac,Tarlac
San Nicolas,City of Tarlac,Tarlac
San Pablo,City of Tarlac,Tarlac
San Pedro,City of Tarlac,Tarlac
San Rafael,City of Tarlac,Tarlac
San Roque,City of Tarlac,Tarlac
San Sebastian,City of Tarlac,Tarlac
San Vicente,City of Tarlac,Tarlac
Santa Cruz,City of Tarlac,Tarlac
Santa Maria,City of Tarlac,Tarlac
Santa Rita,City of Tarlac,Tarlac
Santo Cristo,City of Tarlac,Tarlac
Santo Niño,City of Tarlac,Tarlac
Sapang Bato,City of Tarlac,Tarlac
Sapang Tagalog,City of Tarlac,Tarlac
Sepung Bulaon,City of Tarlac,Tarlac
Sepung Gubat,City of Tarlac,Tarlac
Sinait,City of Tarlac,Tarlac
Sisilang,City of Tarlac,Tarlac
Solo,City of Tarlac,Tarlac
Tancate,City of Tarlac,Tarlac
Tibag,City of Tarlac,Tarlac
Toledo,City of Tarlac,Tarlac
Ugad,City of Tarlac,Tarlac
Ungot,City of Tarlac,Tarlac
Villa Elena,City of Tarlac,Tarlac
Villa Esmeralda,City of Tarlac,Tarlac
Villa Lourdes,City of Tarlac,Tarlac
Villa Rosario,City of Tarlac,Tarlac
Villapaz,City of Tarlac,Tarlac
Bacungan,Victoria,Tarlac
Baluart,Victoria,Tarlac
Bangar,Victoria,Tarlac
Bantog,Victoria,Tarlac
Bayanbayanan,Victoria,Tarlac
Calibungan,Victoria,Tarlac
Canarem,Victoria,Tarlac
Cariño,Victoria,Tarlac
Casantolan,Victoria,Tarlac
Concepcion,Victoria,Tarlac
Culubasa,Victoria,Tarlac
Estacion,Victoria,Tarlac
Gubat,Victoria,Tarlac
Lalapac,Victoria,Tarlac
Mabini,Victoria,Tarlac
Malabago,Victoria,Tarlac
Malorena,Victoria,Tarlac
Malvar,Victoria,Tarlac
Mapandan,Victoria,Tarlac
Merrising,Victoria,Tarlac
Militar,Victoria,Tarlac
Mozzozzin,Victoria,Tarlac
Nagrebcan,Victoria,Tarlac
Old Pagaspas,Victoria,Tarlac
Pagaspas,Victoria,Tarlac
Poblacion,Victoria,Tarlac
Quirino,Victoria,Tarlac
Rizal,Victoria,Tarlac
San Antonio,Victoria,Tarlac
San Bartolome,Victoria,Tarlac
San Francisco,Victoria,Tarlac
San Gabriel,Victoria,Tarlac
San Isidro,Victoria,Tarlac
San Jose,Victoria,Tarlac
San Juan,Victoria,Tarlac
San Luis,Victoria,Tarlac
San Marcelino,Victoria,Tarlac
San Mateo,Victoria,Tarlac
San Miguel,Victoria,Tarlac
San Nicolas,Victoria,Tarlac
San Pablo,Victoria,Tarlac
San Pedro,Victoria,Tarlac
San Rafael,Victoria,Tarlac
San Roque,Victoria,Tarlac
San Sebastian,Victoria,Tarlac
San Vicente,Victoria,Tarlac
Santa Catalina,Victoria,Tarlac
Santa Cruz,Victoria,Tarlac
Santa Elena,Victoria,Tarlac
Santa Lucia,Victoria,Tarlac
Santa Maria,Victoria,Tarlac
Santa Monica,Victoria,Tarlac
Santa Rita,Victoria,Tarlac
Santo Cristo,Victoria,Tarlac
Santo Domingo,Victoria,Tarlac
Santo Niño,Victoria,Tarlac
Santo Rosario,Victoria,Tarlac
Sapa,Victoria,Tarlac
Sinait,Victoria,Tarlac
Sulib,Victoria,Tarlac
Tabug,Victoria,Tarlac
Taguing,Victoria,Tarlac
Talimundoc,Victoria,Tarlac
Tambac,Victoria,Tarlac
Tambang,Victoria,Tarlac
Toledo,Victoria,Tarlac
Tubuan,Victoria,Tarlac
Ubando,Victoria,Tarlac
Villa Aglipay,Victoria,Tarlac
Villa Concepcion,Victoria,Tarlac
Villa Marcos,Victoria,Tarlac
Villa Rosario,Victoria,Tarlac`;

            function parseLocationData(csv) {
                var data = {};
                var lines = csv.split(/\r?\n/).filter(function(line) { return line.trim().length > 0; });

                for (var i = 1; i < lines.length; i++) {
                    var parts = parseCsvLine(lines[i]);
                    var barangay = parts[0];
                    var municipality = parts[1];
                    var province = parts[2];

                    if (!province || !municipality || !barangay) {
                        continue;
                    }

                    if (!data[province]) {
                        data[province] = {};
                    }
                    if (!data[province][municipality]) {
                        data[province][municipality] = [];
                    }
                    if (data[province][municipality].indexOf(barangay) === -1) {
                        data[province][municipality].push(barangay);
                    }
                }

                for (var province in data) {
                    for (var municipality in data[province]) {
                        data[province][municipality].sort(function(a, b) { return a.localeCompare(b, 'en', { sensitivity: 'base' }); });
                    }
                }

                return data;
            }

            function parseCsvLine(line) {
                var values = [];
                var current = '';
                var inQuotes = false;

                for (var i = 0; i < line.length; i++) {
                    var char = line[i];
                    if (char === '"') {
                        inQuotes = !inQuotes;
                    } else if (char === ',' && !inQuotes) {
                        values.push(current);
                        current = '';
                    } else {
                        current += char;
                    }
                }

                values.push(current);
                return values;
            }

            var locationData = parseLocationData(locationCsv);

            (function () {
                var tableProvince = document.getElementById('tableProvince');
                var tableMunicipality = document.getElementById('tableMunicipality');
                var tableBarangay = document.getElementById('tableBarangay');

                if (!tableProvince || !tableMunicipality || !tableBarangay) {
                    return;
                }

                function populateSelect(selectElement, options, placeholder) {
                    selectElement.innerHTML = '';
                    var defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = placeholder;
                    selectElement.appendChild(defaultOption);

                    options.forEach(function (option) {
                        var optionItem = document.createElement('option');
                        optionItem.value = option;
                        optionItem.textContent = option;
                        selectElement.appendChild(optionItem);
                    });
                }

                function updateMunicipalities() {
                    if (!tableProvince.value) {
                        populateSelect(tableMunicipality, [], 'All Municipalities');
                        populateSelect(tableBarangay, [], 'All Barangays');
                        return;
                    }
                    var municipalities = Object.keys(locationData[tableProvince.value] || {});
                    populateSelect(tableMunicipality, municipalities, 'All Municipalities');
                    populateSelect(tableBarangay, [], 'All Barangays');
                }

                function updateBarangays() {
                    if (!tableProvince.value || !tableMunicipality.value) {
                        populateSelect(tableBarangay, [], 'All Barangays');
                        return;
                    }
                    var barangays = locationData[tableProvince.value]?.[tableMunicipality.value] || [];
                    populateSelect(tableBarangay, barangays, 'All Barangays');
                }

                tableProvince.addEventListener('change', function() {
                    updateMunicipalities();
                });

                tableMunicipality.addEventListener('change', function() {
                    updateBarangays();
                });

                if (tableProvince.value) {
                    updateMunicipalities();
                    if (tableMunicipality.value) {
                        tableMunicipality.value = '{{ request("municipality") }}';
                        updateBarangays();
                        if (tableBarangay.value) {
                            tableBarangay.value = '{{ request("barangay") }}';
                        }
                    }
                }
            })();
        </script>
    </div>

    <div class="no-print nl-record-toolbar" style="margin-bottom: 16px; padding: 20px; border-radius: 12px; background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
            <div class="nl-record-toolbar-title">
                <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #006c35 0%, #008a43 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg width="18" height="18" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3>Records</h3>
                    <p>{{ number_format($records->total()) }} matching {{ $records->total() === 1 ? 'record' : 'records' }}</p>
                </div>
            </div>
            <div class="nl-record-toolbar-actions">
                <button id="delete-multiple" class="btn" style="padding: 10px 16px; background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 13px; box-shadow: 0 2px 4px rgba(220, 38, 38, 0.2); transition: all 0.2s;">Delete Multiple</button>
                <button id="delete-selected" class="btn" disabled style="padding: 10px 16px; background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); color: white; border: none; border-radius: 8px; cursor: not-allowed; font-weight: 600; font-size: 13px; box-shadow: 0 2px 4px rgba(245, 158, 11, 0.2); transition: all 0.2s; opacity: 0.6;">Delete Selected</button>
                <button type="button" id="select-records-transmit" class="btn" style="padding: 10px 16px; background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 13px; box-shadow: 0 2px 4px rgba(14, 165, 233, 0.2); transition: all 0.2s;">Select for Transmit</button>
                <button type="button" id="transmit-selected-records" class="btn" disabled style="padding: 10px 16px; background: linear-gradient(135deg, #006c35 0%, #008a43 100%); color: white; border: none; border-radius: 8px; cursor: not-allowed; font-weight: 600; font-size: 13px; box-shadow: 0 2px 4px rgba(0, 108, 53, 0.2); transition: all 0.2s; opacity: 0.6;">Transmit Selected</button>
                <button type="button" id="reprint-transmittal" class="btn" style="padding: 10px 16px; background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 13px; box-shadow: 0 2px 4px rgba(124, 58, 237, 0.2); transition: all 0.2s;">Re-print Transmittal</button>
                <button type="button" id="clear-selections" class="btn" style="padding: 10px 16px; background: linear-gradient(135deg, #64748b 0%, #94a3b8 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 13px; box-shadow: 0 2px 4px rgba(100, 116, 139, 0.2); transition: all 0.2s;">Clear Selections</button>
                <span id="bulk-selected-count" style="padding: 8px 12px; background: #f1f5f9; color: #64748b; border-radius: 8px; font-size: 12px; font-weight: 600; border: 1px solid #e2e8f0; min-width: 80px; text-align: center;">0 selected</span>
            </div>
    </div>
    <form id="bulk-form" method="POST" action="{{ route('admin.bulk-delete') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="record_ids" id="selected-record-ids">


        <div id="table-container">
            <div id="table-wrapper" class="table-wrapper-outer" style="width: 100%; border-radius: 16px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); overflow-y: auto; max-height: 500px;">
                <x-table :records="$records" :showEncoder="true" :showFilters="false" :showAdminTransmittal="true" :showNoticeImage="true" :allPrograms="$allPrograms" :allLines="$allLines" :allSources="$allSources" :allModes="$allModes" :showCheckbox="true" />
            </div>
        </div>
        <script>
            (function () {
                const tableHost = document.getElementById('table-wrapper');
                if (!tableHost || tableHost.dataset.adminScrollFallbackInitialized === 'true') {
                    return;
                }

                tableHost.dataset.adminScrollFallbackInitialized = 'true';

                function syncAdminScrollbars() {
                    tableHost.querySelectorAll('.table-scroll-sync-top').forEach(function (topBar) {
                        const tableViewport = topBar.nextElementSibling;
                        const bottomBar = tableViewport?.nextElementSibling;
                        const table = tableViewport?.querySelector('.records-table');
                        const topSpacer = topBar.querySelector('.table-scroll-spacer');
                        const bottomSpacer = bottomBar?.querySelector('.table-scroll-spacer');

                        if (!tableViewport || !bottomBar || !table || !topSpacer || !bottomSpacer) {
                            return;
                        }

                        table.style.width = 'max-content';
                        table.style.minWidth = '100%';
                        tableViewport.style.overflowX = 'hidden';
                        tableViewport.style.overflowY = 'hidden';
                        tableViewport.style.scrollbarWidth = 'none';

                        const contentWidth = Math.max(table.scrollWidth, tableViewport.clientWidth);
                        topSpacer.style.width = `${contentWidth}px`;
                        bottomSpacer.style.width = `${contentWidth}px`;

                        if (tableViewport.dataset.adminScrollSyncInitialized === 'true') {
                            return;
                        }

                        function syncFrom(source) {
                            [topBar, tableViewport, bottomBar].forEach(function (target) {
                                if (target !== source && target.scrollLeft !== source.scrollLeft) {
                                    target.scrollLeft = source.scrollLeft;
                                }
                            });
                        }

                        [topBar, tableViewport, bottomBar].forEach(function (scroller) {
                            scroller.addEventListener('scroll', function () {
                                syncFrom(scroller);
                            }, { passive: true });
                        });

                        tableViewport.dataset.adminScrollSyncInitialized = 'true';
                    });
                }

                window.syncAdminRecordScrollbars = syncAdminScrollbars;
                syncAdminScrollbars();
                window.addEventListener('resize', syncAdminScrollbars);

                if (typeof ResizeObserver !== 'undefined') {
                    const resizeObserver = new ResizeObserver(syncAdminScrollbars);
                    resizeObserver.observe(tableHost);
                }

                const mutationObserver = new MutationObserver(syncAdminScrollbars);
                mutationObserver.observe(tableHost, { childList: true, subtree: true });
            })();
        </script>
        @if($records->isEmpty())
            <div class="nl-empty-records" style="padding: 16px; margin-bottom: 12px; border: 1px solid #e0e0e0; background: #fafafa; color: #555;">
                No records found for the current filters.
            </div>
        @endif
        <div class="no-print" style="margin: 10px 0; text-align: center;">
            <div id="pagination-container" style="display: flex; justify-content: center; align-items: center; gap: 12px;">
                @if ($records->onFirstPage())
                    <span style="padding: 8px 16px; border-radius: 8px; background: #f1f5f9; color: #94a3b8; font-size: 14px; font-weight: 500; border: 1px solid #e2e8f0;">Previous</span>
                @else
                    <a href="{{ $records->appends(request()->query())->previousPageUrl() }}" class="pagination-link" style="padding: 8px 16px; border-radius: 8px; background: linear-gradient(135deg, #006c35 0%, #008a43 100%); color: white; font-size: 14px; font-weight: 500; text-decoration: none; border: 1px solid #005a2d; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0, 108, 53, 0.1);">Previous</a>
                @endif

                <span style="margin: 0 16px; padding: 8px 16px; border-radius: 8px; background: #f8fafc; color: #475569; font-size: 14px; font-weight: 600; border: 1px solid #e2e8f0;">
                    Page {{ $records->currentPage() }} of {{ $records->lastPage() }}
                </span>

                @if ($records->hasMorePages())
                    <a href="{{ $records->appends(request()->query())->nextPageUrl() }}" class="pagination-link" style="padding: 8px 16px; border-radius: 8px; background: linear-gradient(135deg, #006c35 0%, #008a43 100%); color: white; font-size: 14px; font-weight: 500; text-decoration: none; border: 1px solid #005a2d; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0, 108, 53, 0.1);">Next</a>
                @else
                    <span style="padding: 8px 16px; border-radius: 8px; background: #f1f5f9; color: #94a3b8; font-size: 14px; font-weight: 500; border: 1px solid #e2e8f0;">Next</span>
                @endif
            </div>
        </div>
    </form>
    <dialog class="editRecordDialog rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(640px,calc(100vw-2rem))]" id="recordEditDialog">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Edit Record</h3>
        </div>
        <form class="editRecordform grid grid-cols-[auto_1fr] gap-x-4 gap-y-3 px-5 py-4 items-center" id="recordEditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="remove_notice_pdf" value="0">
            <label for="farmerName" class="text-xs font-bold text-gray-600 text-right">Farmer Name:</label>
            <input type="text" id="farmerName" name="farmerName" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full auto-caps">

            <label for="editProvince" class="text-xs font-bold text-gray-600 text-right">Province:</label>
            <select name="province" id="editProvince" required class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                <option value="">Select Province</option>
                <option value="Aurora">Aurora</option>
                <option value="Nueva Ecija">Nueva Ecija</option>
                <option value="Tarlac">Tarlac</option>
            </select>

            <label for="editMunicipality" class="text-xs font-bold text-gray-600 text-right">Municipality:</label>
            <select name="municipality" id="editMunicipality" required disabled class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-gray-50 uppercase">
                <option value="">Select Municipality</option>
            </select>

            <label for="editBarangay" class="text-xs font-bold text-gray-600 text-right">Barangay:</label>
            <select name="barangay" id="editBarangay" required disabled class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-gray-50 uppercase">
                <option value="">Select Barangay</option>
            </select>

            <input type="hidden" name="address" id="editRecordAddress">

            <label for="line" class="text-xs font-bold text-gray-600 text-right">Line:</label>
            <select name="line" id="line" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                <option value="">Select Line</option>
                <option value="rice">rice</option>
                <option value="corn">corn</option>
                <option value="high-value">High-Value Crops</option>
                <option value="clti">CLTI</option>
                <option value="livestock">Livestock</option>
                <option value="non-crop">Non-Crop</option>
                <option value="fisheries">Fisheries</option>
            </select>

            <label for="program" class="text-xs font-bold text-gray-600 text-right">Program:</label>
            <select name="program" id="program" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                <option value="">Select Program</option>
                <option value="RSBSA">RSBSA</option>
                <option value="AGRI-SENSO">AGRI-SENSO</option>
                <option value="ACEF">ACEF</option>
                <option value="ANYO">ANYO</option>
                <option value="OTHER-LI LC">OTHER-LI LC</option>
                <option value="OTHER-LBP ACP">OTHER-LBP ACP</option>
                <option value="REGULAR">REGULAR</option>
                <option value="SELF-FINANCED">SELF-FINANCED</option>
                <option value="CFITF">CFITF</option>
            </select>

            <label for="source" class="text-xs font-bold text-gray-600 text-right">Source:</label>
            <select name="source" id="source" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                <option value="">Select Source</option>
                <option value="OD">OD</option>
                <option value="Email">Email</option>
                <option value="Facebook">Facebook</option>
            </select>

            <label for="causeOfDamage" class="text-xs font-bold text-gray-600 text-right">Cause of Damage:</label>
            <input type="text" id="causeOfDamage" name="causeOfDamage" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full auto-caps">

            <label for="modeOfPayment" class="text-xs font-bold text-gray-600 text-right">Mode of payment:</label>
            <select name="modeOfPayment" id="modeOfPayment" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                <option value="">Select Mode of payment</option>
                <option value="check">Check</option>
                <option value="palawan">Palawan Pay</option>
                <option value="gcash">GCash</option>
                <option value="not_indicated">Not indicated</option>
            </select>
            <label for="date_occurrence" class="text-xs font-bold text-gray-600 text-right">Date occurrence:</label>
            <input type="text" id="date_occurrence" name="date_occurrence" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">

            <label for="date_received" class="text-xs font-bold text-gray-600 text-right">Date received:</label>
            <input type="date" id="date_received" name="date_received" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">

            <label for="remarks" class="text-xs font-bold text-gray-600 text-right">Remarks - Care of:</label>
            <input type="text" id="remarks" name="remarks" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full auto-caps">

            <label for="transmittal_number" class="text-xs font-bold text-gray-600 text-right">Control Number:</label>
            <input type="text" id="transmittal_number" name="transmittal_number" placeholder="e.g., 2026-0420-001..." class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">

            <label for="admin_transmittal_number" class="text-xs font-bold text-gray-600 text-right">Admin Transmittal #:</label>
            <input type="text" id="admin_transmittal_number" name="admin_transmittal_number" placeholder="e.g., 001, 002, 003..." class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <label for="accounts" class="text-xs font-bold text-gray-600 text-right">Account (sender):</label>
            <input type="text" id="accounts" name="accounts" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full auto-caps">
            <label for="facebook_page_url" class="text-xs font-bold text-gray-600 text-right">FB page link:</label>
            <input type="url" id="facebook_page_url" name="facebook_page_url" placeholder="https://www.facebook.com/..." class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <label for="editNoticeImages" class="text-xs font-bold text-gray-600 text-right">Notice / claim photos:</label>
            <div class="flex flex-col gap-2">
                <input type="file" id="editNoticeImages" name="notice_images[]" accept="image/jpeg,image/png,image/webp" multiple class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs text-gray-700">
                <button type="button" class="clear-notice-image-selection w-fit rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-bold text-gray-700 hover:bg-gray-50" hidden>Clear selected photos</button>
                <div id="editNoticeImageAttachments" class="flex flex-col gap-2"></div>
                <button type="button" id="viewEditNoticeImages" class="notice-image-view-btn w-fit" data-image-urls="[]" data-farmer-name="" hidden>View / Print all photos</button>
                <span id="editNoticeImageStatus" class="text-xs text-gray-500"></span>
                <span class="text-xs text-gray-500">JPG, PNG, or WebP. Maximum 30 MB per photo. Existing photos are kept unless removed.</span>
            </div>
            <label for="editNoticePdfs" class="text-xs font-bold text-gray-600 text-right">Supporting PDFs:</label>
            <div class="flex flex-col gap-2">
                <input type="file" id="editNoticePdfs" name="notice_pdfs[]" accept="application/pdf,.pdf" multiple class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs text-gray-700">
                <button type="button" class="clear-notice-pdf-selection w-fit rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-bold text-gray-700 hover:bg-gray-50" hidden>Clear selected PDFs</button>
                <div id="editNoticePdfAttachments" class="flex flex-col gap-2"></div>
                <span id="editNoticePdfStatus" class="text-xs text-gray-500"></span>
                <span class="text-xs text-gray-500">PDF only. Maximum 30 MB per file. Existing PDFs are kept unless removed.</span>
            </div>
            <div></div>
            <label for="clear_admin_transmittal_number" class="flex items-center gap-2 text-xs font-bold text-gray-600">
                <input type="checkbox" id="clear_admin_transmittal_number" name="clear_admin_transmittal_number" value="1" class="w-4 h-4 accent-pcic-700">
                Clear Admin Transmittal Number
            </label>

            <div></div>
            <div class="flex gap-2 pt-1">
                <button type="submit" class="h-9 px-4 rounded-lg bg-pcic-700 text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Update Record</button>
                <button type="button" class="closeEditRecordDialog h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Close</button>
            </div>
        </form>
    </dialog>
    <dialog class="deleteRecordDialog rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(400px,calc(100vw-2rem))]">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Delete Record</h3>
        </div>
        <form class="deleteRecordForm px-5 py-4 flex flex-col gap-3" method="POST">
            @csrf
            @method('DELETE')
            <p class="text-sm text-gray-600">Delete this record?</p>
            <p class="deleteRecordMessage text-sm font-semibold text-red-700"></p>
            <div class="flex gap-2 justify-end mt-2">
                <button type="submit" class="h-9 px-4 rounded-lg bg-red-600 text-white text-xs font-bold hover:bg-red-700 transition-colors cursor-pointer">Confirm Delete</button>
                <button type="button" class="cancelDeleteRecord h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Cancel</button>
            </div>
        </form>
    </dialog>


    <dialog class="bulkDeleteDialog rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(440px,calc(100vw-2rem))]">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Confirm Bulk Delete</h3>
        </div>
        <div class="px-5 py-4">
            <p class="text-sm text-gray-600 mb-2">The following records will be deleted:</p>
            <ul class="bulk-delete-list max-h-40 overflow-y-auto mb-3"></ul>
            <p class="text-sm font-semibold text-red-700 mb-3">Are you sure you want to proceed?</p>
            <div class="flex gap-2 justify-end">
                <button type="button" id="confirm-admin-bulk-delete" class="h-9 px-4 rounded-lg bg-red-600 text-white text-xs font-bold hover:bg-red-700 transition-colors cursor-pointer">Confirm Delete</button>
                <button type="button" class="cancelBulkDelete h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Cancel</button>
            </div>
        </div>
    </dialog>

    <dialog id="reprintTransmittalDialog" class="rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(400px,calc(100vw-2rem))]">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Re-print Transmittal</h3>
        </div>
        <form id="reprintTransmittalForm" class="px-5 py-4">
            <label for="reprintTransmittalNumber" class="block text-xs font-bold text-gray-600 mb-2">Transmittal Number</label>
            <input type="text" id="reprintTransmittalNumber" required class="h-10 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <p id="reprintTransmittalMessage" class="text-sm text-red-600 mt-2"></p>
            <div class="flex gap-2 justify-end mt-4">
                <button type="button" id="cancelReprintTransmittal" class="h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Cancel</button>
                <button type="submit" class="h-9 px-4 rounded-lg bg-pcic-700 text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Print</button>
            </div>
        </form>
    </dialog>


    <dialog class="editAdminDialog rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(420px,calc(100vw-2rem))]">
        <form class="editAdminForm" method="POST">
            @csrf
            @method('PUT')
            <div class="px-5 pt-5 pb-3 border-b border-gray-100">
                <h3 class="text-base font-black text-gray-900">Edit Admin Credentials</h3>
            </div>
            <div class="px-5 py-4 flex flex-col gap-3">
                <label for="adminUsername" class="text-xs font-bold text-gray-600">Username:</label>
                <input type="text" id="adminUsername" name="username" required class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
                <label for="adminPassword" class="text-xs font-bold text-gray-600">Password:</label>
                <input type="password" id="adminPassword" name="password" required placeholder="Enter new password" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
                <div class="flex gap-2 justify-end mt-2">
                    <button type="submit" class="h-9 px-4 rounded-lg bg-pcic-700 text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Update</button>
                    <button type="button" class="closeEditAdminDialog h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Cancel</button>
                </div>
            </div>
        </form>
    </dialog>


    <dialog class="approveOfficerDialog rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(400px,calc(100vw-2rem))]">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Confirm Officer Approval</h3>
        </div>
        <div class="px-5 py-4">
            <p class="text-sm text-gray-600 mb-4">Are you sure you want to approve <strong id="approveOfficerName" class="text-gray-900"></strong>?</p>
            <form id="approveOfficerForm" method="POST">
                @csrf
                <div class="flex gap-2 justify-end">
                    <button type="submit" class="h-9 px-4 rounded-lg bg-pcic-700 text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Confirm Approve</button>
                    <button type="button" class="closeApproveDialog h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Cancel</button>
                </div>
            </form>
        </div>
    </dialog>


    <dialog class="addAdminDialog rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(420px,calc(100vw-2rem))]">
        <form action="{{ route('admin.users.create') }}" method="POST">
            @csrf
            <div class="px-5 pt-5 pb-3 border-b border-gray-100">
                <h3 class="text-base font-black text-gray-900">Add New Admin User</h3>
            </div>
            <div class="px-5 py-4 flex flex-col gap-3">
                <label for="newAdminUsername" class="text-xs font-bold text-gray-600">Username:</label>
                <input type="text" id="newAdminUsername" name="username" required class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
                <label for="newAdminPassword" class="text-xs font-bold text-gray-600">Password:</label>
                <input type="password" id="newAdminPassword" name="password" required placeholder="Minimum 6 characters" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
                <div class="flex gap-2 justify-end mt-2">
                    <button type="submit" class="h-9 px-4 rounded-lg bg-pcic-700 text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Create Admin</button>
                    <button type="button" class="closeAddAdminDialog h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Cancel</button>
                </div>
            </div>
        </form>
    </dialog>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnDashboard = document.getElementById('btn-dashboard');
        const btnNlRecords = document.getElementById('btn-nl-records');
        const dashboardSection = document.getElementById('dashboard-section');
        const nlRecordsSection = document.getElementById('nl-records-section');
        const adminActiveTabKey = 'admin_active_tab';

        const adminMain = document.querySelector('.admin-main');

        function setTabInUrl(tabValue, replace = false) {
            const params = new URLSearchParams(window.location.search);
            params.set('tab', tabValue);
            const nextUrl = `${window.location.pathname}?${params.toString()}`;
            const updateHistory = replace ? 'replaceState' : 'pushState';
            window.history[updateHistory]({ tab: tabValue }, '', nextUrl);
        }

        function showTab(tabValue, updateUrl = true) {
            const showNlRecords = tabValue === 'nl-records';
            dashboardSection.style.display = showNlRecords ? 'none' : 'block';
            nlRecordsSection.style.display = showNlRecords ? 'block' : 'none';
            dashboardSection.setAttribute('aria-hidden', String(showNlRecords));
            nlRecordsSection.setAttribute('aria-hidden', String(!showNlRecords));
            btnDashboard.classList.toggle('active', !showNlRecords);
            btnNlRecords.classList.toggle('active', showNlRecords);
            btnDashboard.toggleAttribute('aria-current', !showNlRecords);
            btnNlRecords.toggleAttribute('aria-current', showNlRecords);
            localStorage.setItem(adminActiveTabKey, showNlRecords ? 'nl-records' : 'dashboard');

            if (showNlRecords) {
                requestAnimationFrame(function () {
                    window.syncTableScrollbars?.();
                    window.syncAdminRecordScrollbars?.();
                });
            }

            const selectedTab = showNlRecords ? 'nl-records' : 'dashboard';
            if (updateUrl && new URLSearchParams(window.location.search).get('tab') !== selectedTab) {
                setTabInUrl(selectedTab);
            }

            adminMain?.scrollTo({ top: 0, behavior: 'auto' });
        }

        window.adminShowTab = showTab;

        if (btnDashboard && btnNlRecords && dashboardSection && nlRecordsSection) {
            btnDashboard.addEventListener('click', function (event) {
                event.preventDefault();
                showTab('dashboard');
            });

            btnNlRecords.addEventListener('click', function (event) {
                event.preventDefault();
                showTab('nl-records');
            });

            const tabFromUrl = new URLSearchParams(window.location.search).get('tab');
            const savedTab = localStorage.getItem(adminActiveTabKey);
            const defaultTab = tabFromUrl || savedTab;
            showTab(defaultTab === 'nl-records' ? 'nl-records' : 'dashboard', false);
            setTabInUrl(defaultTab === 'nl-records' ? 'nl-records' : 'dashboard', true);
            window.addEventListener('popstate', function () {
                const tab = new URLSearchParams(window.location.search).get('tab');
                showTab(tab === 'nl-records' ? 'nl-records' : 'dashboard', false);
            });
        } else {
            console.error('Required elements not found:', {
                btnDashboard: !!btnDashboard,
                btnNlRecords: !!btnNlRecords,
                dashboardSection: !!dashboardSection,
                nlRecordsSection: !!nlRecordsSection
            });
        }


        const openAdminUsersModal = document.getElementById('openAdminUsersModal');
        const adminUsersModal = document.getElementById('adminUsersModal');
        const closeAdminUsersModal = document.querySelector('.closeAdminUsersModal');

        if (openAdminUsersModal && adminUsersModal) {
            openAdminUsersModal.addEventListener('click', function() {
                adminUsersModal.showModal();
            });
        }

        if (closeAdminUsersModal && adminUsersModal) {
            closeAdminUsersModal.addEventListener('click', function() {
                adminUsersModal.close();
            });
        }

        const openActiveUsersModal = document.getElementById('openActiveUsersModal');
        const activeUsersModal = document.getElementById('activeUsersModal');
        const closeActiveUsersModal = document.querySelector('.closeActiveUsersModal');

        if (openActiveUsersModal && activeUsersModal) {
            openActiveUsersModal.addEventListener('click', function() {
                fetch('{{ route('admin.active-users') }}')
                    .then(response => response.json())
                    .then(data => {
                        const content = document.getElementById('activeUsersContent');
                        if (data.error) {
                            content.innerHTML = '<p class="text-sm text-red-600 text-center py-4">Error loading active users.</p>';
                        } else if (data.activeUsers && data.activeUsers.length > 0) {
                            let html = '<table class="w-full text-sm">';
                            html += '<thead><tr class="border-b border-gray-200"><th class="text-left py-2 px-3 font-bold text-gray-700">Name</th><th class="text-left py-2 px-3 font-bold text-gray-700">Channel</th><th class="text-left py-2 px-3 font-bold text-gray-700">Status</th><th class="text-left py-2 px-3 font-bold text-gray-700">Last Activity</th></tr></thead>';
                            html += '<tbody>';
                            data.activeUsers.forEach(user => {
                                html += '<tr class="border-b border-gray-100">';
                                html += '<td class="py-2 px-3 text-gray-800">' + user.name + '</td>';
                                html += '<td class="py-2 px-3 text-gray-600">' + user.channel + '</td>';
                                html += '<td class="py-2 px-3"><span class="px-2 py-1 rounded-full text-xs font-bold ' + (user.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700') + '">' + user.status + '</span></td>';
                                html += '<td class="py-2 px-3 text-gray-600">' + (user.last_activity ? new Date(user.last_activity).toLocaleString() : 'N/A') + '</td>';
                                html += '</tr>';
                            });
                            html += '</tbody></table>';
                            content.innerHTML = html;
                        } else {
                            content.innerHTML = '<p class="text-sm text-gray-500 text-center py-4">No active users found.</p>';
                        }
                        activeUsersModal.showModal();
                    })
                    .catch(error => {
                        console.error('Error loading active users:', error);
                        const content = document.getElementById('activeUsersContent');
                        content.innerHTML = '<p class="text-sm text-red-600 text-center py-4">Error loading active users.</p>';
                        activeUsersModal.showModal();
                    });
            });
        }

        if (closeActiveUsersModal && activeUsersModal) {
            closeActiveUsersModal.addEventListener('click', function() {
                activeUsersModal.close();
            });
        }

        const openUserMaintenanceModal = document.getElementById('openUserMaintenanceModal');
        const userMaintenanceModal = document.getElementById('userMaintenanceModal');
        const closeUserMaintenanceModal = document.querySelector('.closeUserMaintenanceModal');
        const userMaintenanceSearch = document.getElementById('userMaintenanceSearch');

        userMaintenanceSearch?.addEventListener('input', filterUserMaintenanceList);

        if (openUserMaintenanceModal && userMaintenanceModal) {
            openUserMaintenanceModal.addEventListener('click', function() {
                console.log('Opening User Maintenance modal...');
                userMaintenanceSearch.value = '';
                userMaintenanceModal.showModal();
                loadUsers();
            });
        }

        if (closeUserMaintenanceModal && userMaintenanceModal) {
            closeUserMaintenanceModal.addEventListener('click', function() {
                userMaintenanceModal.close();
            });
        }

        const openReportsModal = document.getElementById('openReportsModal');
        const reportsModal = document.getElementById('reportsModal');
        const closeReportsModal = document.querySelector('.closeReportsModal');

        if (openReportsModal && reportsModal) {
            openReportsModal.addEventListener('click', function() {
                reportsModal.showModal();
            });
        }

        if (closeReportsModal && reportsModal) {
            closeReportsModal.addEventListener('click', function() {
                reportsModal.close();
            });
        }

        const openEncoderReportModal = document.querySelector('.openEncoderReportModal');
        const encoderReportModal = document.getElementById('encoderReportModal');
        const closeEncoderReportModal = document.querySelector('.closeEncoderReportModal');
        const encoderReportForm = document.getElementById('encoderReportForm');

        if (openEncoderReportModal && encoderReportModal) {
            openEncoderReportModal.addEventListener('click', function() {
                reportsModal.close();
                if (encoderReportForm) {
                    encoderReportForm.reset();
                }
                encoderReportModal.showModal();
            });
        }

        if (closeEncoderReportModal && encoderReportModal) {
            closeEncoderReportModal.addEventListener('click', function() {
                encoderReportModal.close();
            });
        }

        if (encoderReportForm && encoderReportModal) {
            encoderReportForm.addEventListener('submit', function() {
                encoderReportModal.close();
            });
        }

        const openTransmittalReportModal = document.querySelector('.openTransmittalReportModal');
        const transmittalReportModal = document.getElementById('transmittalReportModal');
        const closeTransmittalReportModal = document.querySelector('.closeTransmittalReportModal');
        const transmittalReportForm = document.getElementById('transmittalReportForm');

        if (openTransmittalReportModal && transmittalReportModal) {
            openTransmittalReportModal.addEventListener('click', function() {
                reportsModal.close();
                if (transmittalReportForm) {
                    transmittalReportForm.reset();
                }
                transmittalReportModal.showModal();
            });
        }

        if (closeTransmittalReportModal && transmittalReportModal) {
            closeTransmittalReportModal.addEventListener('click', function() {
                transmittalReportModal.close();
            });
        }

        if (transmittalReportForm && transmittalReportModal) {
            transmittalReportForm.addEventListener('submit', function() {
                transmittalReportModal.close();
            });
        }

        const addOfficerButton = document.querySelector('.addOfficerButton');
        if (addOfficerButton) {
            addOfficerButton.addEventListener('click', function() {
                showUserForm();
            });
        }

        function showUserForm(user = null) {
            const content = document.getElementById('userMaintenanceContent');
            const isEdit = user !== null;
            userMaintenanceModal.classList.add('is-editing');

            let html = `
                <form id="officerForm" class="user-maintenance-form space-y-4 rounded-xl border border-slate-200 bg-slate-50 p-5">
                    <input type="hidden" id="officerId" value="${user ? user.id : ''}">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Name</label>
                        <input type="text" id="officerName" name="name" value="${user ? user.name : ''}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pcic-500 focus:border-pcic-500 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Username</label>
                        <input type="text" id="officerUsername" name="username" value="${user ? user.username : ''}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pcic-500 focus:border-pcic-500 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Password ${isEdit ? '<span class="text-gray-500 font-normal">(leave blank to keep current)</span>' : ''}</label>
                        <input type="password" id="officerPassword" name="password" placeholder="${isEdit ? '••••••••' : 'Enter password'}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pcic-500 focus:border-pcic-500 text-sm" ${!isEdit ? 'required' : ''}>
                    </div>
                    <div class="flex justify-end space-x-2 pt-4 border-t border-gray-100">
                        <button type="button" class="cancel-user-form h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Cancel</button>
                        <button type="submit" class="h-9 px-4 rounded-lg bg-pcic-700 text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">${isEdit ? 'Update' : 'Create'} User</button>
                    </div>
                </form>
            `;

            content.innerHTML = html;

            document.getElementById('officerForm').addEventListener('submit', function(e) {
                e.preventDefault();
                saveUser();
            });
        }

        function saveUser() {
            const officerId = document.getElementById('officerId').value;
            const name = document.getElementById('officerName').value;
            const username = document.getElementById('officerUsername').value;
            const password = document.getElementById('officerPassword').value;

            console.log('Saving user:', {
                officerId,
                name,
                username,
                password: password || '(empty)'
            });

            const url = officerId ? `/api/officers/${officerId}` : '/api/officers';
            const method = officerId ? 'PUT' : 'POST';

            const requestData = {
                name: name,
                username: username,
            };

            if (password || !officerId) {
                requestData.password = password || 'default123';
            }

            console.log('Request data:', requestData);

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                console.log('Save response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Save response data:', data);
                if (data.success) {
                    showModalMessage(data.message, 'success');
                    loadUsers();
                } else {
                    showModalMessage('Error: ' + (data.message || 'Failed to save user'), 'error');
                }
            })
            .catch(error => {
                console.error('Error saving user:', error);
                showModalMessage('Error saving user', 'error');
            });
        }

        function editUser(id) {
            console.log('Editing user with ID:', id);

            fetch(`/api/officers/${id}`)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('User data received:', data);
                    showUserForm(data);
                })
                .catch(error => {
                    console.error('Error fetching user:', error);
                    showModalMessage('Error fetching user data: ' + error.message, 'error');
                });
        }

        function deleteUser(id) {
            console.log('Deleting user with ID:', id);

            showConfirmDialog('Are you sure you want to delete this user?', function() {
                fetch(`/api/officers/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Delete response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Delete response data:', data);
                    if (data.success) {
                        showModalMessage(data.message, 'success');
                        loadUsers();
                    } else {
                        showModalMessage('Error: ' + (data.message || 'Failed to delete user'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error deleting user:', error);
                    showModalMessage('Error deleting user: ' + error.message, 'error');
                });
            });
        }

        function attachUserButtonListeners() {
            console.log('Attaching user button listeners...');

            document.removeEventListener('click', handleUserButtonClick);

            document.addEventListener('click', handleUserButtonClick);
        }

        function handleUserButtonClick(event) {
            const editButton = event.target.closest('.edit-user-btn');
            const deleteButton = event.target.closest('.delete-user-btn');
            const cancelButton = event.target.closest('.cancel-user-form');

            if (editButton) {
                event.preventDefault();
                const userId = editButton.getAttribute('data-user-id');
                console.log('Edit button clicked for user ID:', userId);
                editUser(userId);
            } else if (deleteButton) {
                event.preventDefault();
                const userId = deleteButton.getAttribute('data-user-id');
                console.log('Delete button clicked for user ID:', userId);
                deleteUser(userId);
            } else if (cancelButton) {
                event.preventDefault();
                console.log('Cancel button clicked');
                loadUsers();
            }
        }

        function escapeUserHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, function(character) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                }[character];
            });
        }

        function filterUserMaintenanceList() {
            const query = userMaintenanceSearch.value.trim().toLocaleLowerCase();
            const rows = document.querySelectorAll('#userMaintenanceContent .user-maintenance-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const matches = row.dataset.search.includes(query);
                row.hidden = !matches;
                if (matches) {
                    visibleCount += 1;
                }
            });

            const noResults = document.getElementById('userMaintenanceNoResults');
            if (noResults) {
                noResults.hidden = visibleCount > 0;
                noResults.textContent = query ? 'No users match that name or username.' : 'No users found.';
            }

            const count = document.getElementById('userMaintenanceCount');
            if (count) {
                count.textContent = `${visibleCount} ${visibleCount === 1 ? 'user' : 'users'}`;
            }
        }

        function renderUserMaintenanceList(officers) {
            const content = document.getElementById('userMaintenanceContent');
            userMaintenanceModal.classList.remove('is-editing');

            if (!officers.length) {
                content.innerHTML = '<div class="user-maintenance-empty">No users found.</div>';
                return;
            }

            const rows = officers.map(officer => {
                const createdDate = officer.created_at
                    ? new Date(officer.created_at).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    })
                    : '—';
                const searchValue = `${officer.name ?? ''} ${officer.username ?? ''}`.toLocaleLowerCase();

                return `
                    <tr class="user-maintenance-row" data-search="${escapeUserHtml(searchValue)}">
                        <td>${escapeUserHtml(officer.id)}</td>
                        <td class="user-name">${escapeUserHtml(officer.name)}</td>
                        <td class="user-username">${escapeUserHtml(officer.username)}</td>
                        <td>${escapeUserHtml(createdDate)}</td>
                        <td>
                            <div class="user-maintenance-actions">
                                <button type="button" data-user-id="${escapeUserHtml(officer.id)}" class="user-maintenance-action user-maintenance-edit edit-user-btn">Edit</button>
                                <button type="button" data-user-id="${escapeUserHtml(officer.id)}" class="user-maintenance-action user-maintenance-delete delete-user-btn">Delete</button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');

            content.innerHTML = `
                <div class="flex items-center justify-between gap-3 mb-2">
                    <p class="text-xs text-gray-500">Officer accounts</p>
                    <p id="userMaintenanceCount" class="text-xs font-bold text-gray-600">${officers.length} ${officers.length === 1 ? 'user' : 'users'}</p>
                </div>
                <div class="user-maintenance-table-wrap">
                    <table class="user-maintenance-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>
                <div id="userMaintenanceNoResults" class="user-maintenance-empty" hidden>No users match that name or username.</div>
            `;

            filterUserMaintenanceList();
            attachUserButtonListeners();
        }

        function loadUsers() {
            console.log('Loading users...');
            userMaintenanceModal.classList.remove('is-editing');
            fetch('/api/officers')
                .then(response => {
                    console.log('Load users response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Users data received:', data);
                    const content = document.getElementById('userMaintenanceContent');
                    if (!data.success || !Array.isArray(data.officers)) {
                        throw new Error(data.message || data.error || 'The users list could not be loaded.');
                    }

                    renderUserMaintenanceList(data.officers);
                })
                .catch(error => {
                    console.error('Error loading users:', error);
                    const content = document.getElementById('userMaintenanceContent');
                    content.innerHTML = `<div class="user-maintenance-empty text-red-600">${escapeUserHtml(error.message)} Please try again.</div>`;
                });
        }

        const dashProvince = document.querySelector('select[name="dash_province"]');
        const dashMunicipality = document.querySelector('select[name="dash_municipality"]');
        const dashBarangay = document.querySelector('select[name="dash_barangay"]');

        const tableProvince = document.querySelector('select[name="province"]');
        const tableMunicipality = document.querySelector('select[name="municipality"]');
        const tableBarangay = document.querySelector('select[name="barangay"]');

        const locationCsv = '';

        const transmitActionBtn = document.getElementById('transmit-selected-records');
        const transmitAllBox = document.getElementById('select-all-transmit');
        const transmitCheckboxes = document.querySelectorAll('.record-checkbox-transmit');
        const bulkSelectedCount = document.getElementById('bulk-selected-count');
        const recordCheckboxes = document.querySelectorAll('.record-checkbox');
        const selectAllBox = document.getElementById('select-all');

        const selectedIdsOrder = [];
        const selectedSourcesOrder = [];

        function getSelectedIdsFromUrl() {
            const params = new URLSearchParams(window.location.search);
            const selectedIds = params.get('selected_transmit_ids');
            return selectedIds ? selectedIds.split(',').filter(id => id) : [];
        }

        function updateUrlWithSelectedIds(selectedIds) {
            const url = new URL(window.location);
            if (selectedIds.length > 0) {
                url.searchParams.set('selected_transmit_ids', selectedIds.join(','));
            } else {
                url.searchParams.delete('selected_transmit_ids');
            }
            window.history.replaceState({}, '', url);
            updateFilterFormHiddenInputs();
        }

        function updateFilterFormHiddenInputs() {
            const filterTransmitIdsInput = document.getElementById('filter-selected-transmit-ids');
            const filterDeleteIdsInput = document.getElementById('filter-selected-delete-ids');

            if (filterTransmitIdsInput) {
                const transmitIds = getSelectedIdsFromUrl();
                filterTransmitIdsInput.value = transmitIds.join(',');
            }

            if (filterDeleteIdsInput) {
                const deleteIds = getSelectedDeleteIdsFromUrl();
                filterDeleteIdsInput.value = deleteIds.join(',');
            }
        }

        function getSelectedDeleteIdsFromUrl() {
            const params = new URLSearchParams(window.location.search);
            const selectedIds = params.get('selected_delete_ids');
            return selectedIds ? selectedIds.split(',').filter(id => id) : [];
        }

        function updateUrlWithSelectedDeleteIds(selectedIds) {
            const url = new URL(window.location);
            if (selectedIds.length > 0) {
                url.searchParams.set('selected_delete_ids', selectedIds.join(','));
            } else {
                url.searchParams.delete('selected_delete_ids');
            }
            window.history.replaceState({}, '', url);
            updateFilterFormHiddenInputs();
        }

        const updateTransmitButtonState = () => {
            const selectedIds = getSelectedIdsFromUrl();
            const totalSelected = selectedIds.length;
            const currentTransmitBtn = document.getElementById('transmit-selected-records');
            const currentBulkCount = document.getElementById('bulk-selected-count');
            if (currentTransmitBtn) {
                currentTransmitBtn.disabled = totalSelected === 0;
                currentTransmitBtn.style.opacity = totalSelected === 0 ? '0.6' : '1';
                currentTransmitBtn.style.cursor = totalSelected === 0 ? 'not-allowed' : 'pointer';
            }
            if (currentBulkCount) {
                currentBulkCount.textContent = totalSelected > 0 ? `${totalSelected} selected` : '';
            }
        };

        const updateDeleteButtonState = () => {
            const selectedIds = getSelectedDeleteIdsFromUrl();
            const totalSelected = selectedIds.length;
            const currentDeleteBtn = document.getElementById('delete-selected');
            if (currentDeleteBtn) {
                currentDeleteBtn.disabled = totalSelected === 0;
                currentDeleteBtn.style.opacity = totalSelected === 0 ? '0.6' : '1';
                currentDeleteBtn.style.cursor = totalSelected === 0 ? 'not-allowed' : 'pointer';
            }
        };
        transmitCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const selectedIds = getSelectedIdsFromUrl();
                const checkboxValue = cb.value;
                const source = cb.dataset.source;

                if (this.checked) {
                    if (!selectedIds.includes(checkboxValue)) {
                        selectedIds.push(checkboxValue);
                        selectedIdsOrder.push(checkboxValue);
                        if (source && !selectedSourcesOrder.includes(source)) {
                            selectedSourcesOrder.push(source);
                        }
                    }
                } else {
                    const index = selectedIds.indexOf(checkboxValue);
                    if (index > -1) {
                        selectedIds.splice(index, 1);
                        const orderIndex = selectedIdsOrder.indexOf(checkboxValue);
                        if (orderIndex > -1) {
                            selectedIdsOrder.splice(orderIndex, 1);
                        }
                        if (source) {
                            const sourceStillSelected = selectedIdsOrder.some(id => {
                                const checkbox = document.querySelector(`.record-checkbox-transmit[value="${id}"]`);
                                return checkbox && checkbox.dataset.source === source;
                            });
                            if (!sourceStillSelected) {
                                const sourceIndex = selectedSourcesOrder.indexOf(source);
                                if (sourceIndex > -1) {
                                    selectedSourcesOrder.splice(sourceIndex, 1);
                                }
                            }
                        }
                    }
                }
                updateUrlWithSelectedIds(selectedIds);
                updateTransmitButtonState();
            });
        });

        recordCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const selectedIds = getSelectedDeleteIdsFromUrl();
                const checkboxValue = cb.value;
                if (this.checked) {
                    if (!selectedIds.includes(checkboxValue)) {
                        selectedIds.push(checkboxValue);
                    }
                } else {
                    const index = selectedIds.indexOf(checkboxValue);
                    if (index > -1) {
                        selectedIds.splice(index, 1);
                    }
                }
                updateUrlWithSelectedDeleteIds(selectedIds);
                updateDeleteButtonState();
            });
        });

        function populateSelect(selectElement, options, placeholder) {
            if (!selectElement) return;
            selectElement.innerHTML = '';
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = placeholder;
            selectElement.appendChild(defaultOption);
            options.forEach(option => {
                const optionItem = document.createElement('option');
                optionItem.value = option;
                optionItem.textContent = option;
                selectElement.appendChild(optionItem);
            });
        }

        function updateMunicipalities(provinceSelect, municipalitySelect, barangaySelect) {
            if (!provinceSelect || !municipalitySelect || !barangaySelect) return;
            if (!provinceSelect.value) {
                populateSelect(municipalitySelect, [], 'All Municipalities');
                populateSelect(barangaySelect, [], 'All Barangays');
                return;
            }
            const municipalities = Object.keys(locationData[provinceSelect.value] || {});
            populateSelect(municipalitySelect, municipalities, 'All Municipalities');
            populateSelect(barangaySelect, [], 'All Barangays');
        }

        function updateBarangays(provinceSelect, municipalitySelect, barangaySelect) {
            if (!provinceSelect || !municipalitySelect || !barangaySelect) return;
            if (!provinceSelect.value || !municipalitySelect.value) {
                populateSelect(barangaySelect, [], 'All Barangays');
                return;
            }
            const barangays = locationData[provinceSelect.value]?.[municipalitySelect.value] || [];
            populateSelect(barangaySelect, barangays, 'All Barangays');
        }

        if (dashProvince && dashMunicipality && dashBarangay) {
            dashProvince.addEventListener('change', function() {
                updateMunicipalities(dashProvince, dashMunicipality, dashBarangay);
            });
            dashMunicipality.addEventListener('change', function() {
                updateBarangays(dashProvince, dashMunicipality, dashBarangay);
            });

            if (dashProvince.value) {
                updateMunicipalities(dashProvince, dashMunicipality, dashBarangay);
                if (dashMunicipality.value) {
                    dashMunicipality.value = '{{ request("dash_municipality") }}';
                    updateBarangays(dashProvince, dashMunicipality, dashBarangay);
                    if (dashBarangay.value) {
                        dashBarangay.value = '{{ request("dash_barangay") }}';
                    }
                }
            }
        }

        if (tableProvince && tableMunicipality && tableBarangay) {
            tableProvince.addEventListener('change', function() {
                updateMunicipalities(tableProvince, tableMunicipality, tableBarangay);
            });
            tableMunicipality.addEventListener('change', function() {
                updateBarangays(tableProvince, tableMunicipality, tableBarangay);
            });

            if (tableProvince.value) {
                updateMunicipalities(tableProvince, tableMunicipality, tableBarangay);
                if (tableMunicipality.value) {
                    tableMunicipality.value = '{{ request("municipality") }}';
                    updateBarangays(tableProvince, tableMunicipality, tableBarangay);
                    if (tableBarangay.value) {
                        tableBarangay.value = '{{ request("barangay") }}';
                    }
                }
            }
        }

        const deleteMultipleBtn = document.getElementById('delete-multiple');
        const deleteSelectedBtn = document.getElementById('delete-selected');
        const transmitToggleBtn = document.getElementById('select-records-transmit');
        const bulkDeleteDialog = document.querySelector('.bulkDeleteDialog');
        const reprintTransmittalBtn = document.getElementById('reprint-transmittal');
        const reprintTransmittalDialog = document.getElementById('reprintTransmittalDialog');
        const reprintTransmittalForm = document.getElementById('reprintTransmittalForm');
        const reprintTransmittalNumber = document.getElementById('reprintTransmittalNumber');
        const cancelReprintTransmittal = document.getElementById('cancelReprintTransmittal');
        const reprintTransmittalMessage = document.getElementById('reprintTransmittalMessage');
        const checkboxElements = document.querySelectorAll('.col-checkbox');
        const unassignedToggle = document.getElementById('unassigned-toggle');
        const selectedRecordIdsInput = document.getElementById('selected-record-ids');

        function showLoadingIndicator() {
        }

        reprintTransmittalBtn?.addEventListener('click', function() {
            reprintTransmittalMessage.textContent = '';
            reprintTransmittalNumber.value = '';
            reprintTransmittalDialog?.showModal();
            reprintTransmittalNumber.focus();
        });

        cancelReprintTransmittal?.addEventListener('click', function() {
            reprintTransmittalDialog?.close();
        });

        reprintTransmittalForm?.addEventListener('submit', function(event) {
            event.preventDefault();
            const transmittalNumber = reprintTransmittalNumber.value.trim();
            if (!transmittalNumber) return;

            const url = new URL('{{ route('admin.print-preview') }}', window.location.origin);
            url.searchParams.set('reprint_transmittal', transmittalNumber);
            window.open(url.toString(), '_blank');
            reprintTransmittalDialog?.close();
        });

        deleteMultipleBtn?.addEventListener('click', function() {
            const currentCheckboxElements = document.querySelectorAll('.col-checkbox');
            const currentCheckboxes = document.querySelectorAll('.record-checkbox');
            let firstElement = currentCheckboxElements[0];
            let firstCheckbox = currentCheckboxes[0];
            let isHidden = (firstElement && firstElement.style.display === 'none') ||
                           (firstCheckbox && firstCheckbox.style.display === 'none');

            currentCheckboxElements.forEach(cl => {
                cl.style.display = isHidden ? 'table-cell' : 'none';
            });
            currentCheckboxes.forEach(cb => {
                cb.style.display = isHidden ? 'block' : 'none';
            });

            const selectAllBoxes = document.querySelectorAll('#select-all');
            selectAllBoxes.forEach(box => {
                box.style.display = isHidden ? 'block' : 'none';
            });

            if (isHidden) {
                this.textContent = 'Cancel Delete Multiple';
                this.style.backgroundColor = '#6c757d';
            } else {
                this.textContent = 'Delete Multiple';
                this.style.backgroundColor = '';
                clearSelectedDeleteIds();
            }
        });

        transmitToggleBtn?.addEventListener('click', function() {
            const currentCheckboxElements = document.querySelectorAll('.col-checkbox-transmit');
            const currentCheckboxes = document.querySelectorAll('.record-checkbox-transmit');
            const isHidden = !this.textContent.includes('Cancel');

            currentCheckboxElements.forEach(el => {
                el.style.display = isHidden ? 'table-cell' : 'none';
            });
            currentCheckboxes.forEach(cb => {
                cb.style.display = isHidden ? 'block' : 'none';
            });

            const selectAllTransmitBoxes = document.querySelectorAll('#select-all-transmit');
            selectAllTransmitBoxes.forEach(box => {
                box.style.display = isHidden ? 'block' : 'none';
            });

            if (isHidden) {
                this.textContent = 'Cancel Selection';
                this.style.backgroundColor = '#6c757d';

                if (unassignedToggle && !unassignedToggle.checked) {
                    unassignedToggle.checked = true;
                    const toggleBackground = document.getElementById('unassigned-toggle-bg');
                    const toggleDot = document.getElementById('unassigned-toggle-dot');
                    if (toggleBackground && toggleDot) {
                        toggleBackground.style.backgroundColor = '#006c35';
                        toggleDot.style.transform = 'translateX(24px)';
                    }
                    submitFilterForm();
                }
            } else {
                this.textContent = 'Select Records for Transmit';
                this.style.backgroundColor = '';

                clearSelectedTransmitIds();
                document.querySelectorAll('#select-all-transmit').forEach(box => {
                    box.checked = false;
                });
                if(transmitActionBtn) transmitActionBtn.disabled = true;
                if (bulkSelectedCount) bulkSelectedCount.textContent = '';
            }
        });

        transmitAllBox?.addEventListener('change', function() {
            const currentCheckboxes = document.querySelectorAll('.record-checkbox-transmit');
            let selectedIds = getSelectedIdsFromUrl();

            if (this.checked) {
                currentCheckboxes.forEach(cb => {
                    cb.checked = true;
                    const source = cb.dataset.source;
                    if (!selectedIds.includes(cb.value)) {
                        selectedIds.push(cb.value);
                        selectedIdsOrder.push(cb.value);
                        if (source && !selectedSourcesOrder.includes(source)) {
                            selectedSourcesOrder.push(source);
                        }
                    }
                });
            } else {
                currentCheckboxes.forEach(cb => {
                    cb.checked = false;
                    const index = selectedIds.indexOf(cb.value);
                    if (index > -1) {
                        selectedIds.splice(index, 1);
                        const orderIndex = selectedIdsOrder.indexOf(cb.value);
                        if (orderIndex > -1) {
                            selectedIdsOrder.splice(orderIndex, 1);
                        }
                    }
                });
                selectedSourcesOrder.length = 0;
            }
            updateUrlWithSelectedIds(selectedIds);
            updateTransmitButtonState();
        });

        function loadSelectedTransmitIds() {
            const selectedIds = getSelectedIdsFromUrl();
            const currentCheckboxes = document.querySelectorAll('.record-checkbox-transmit');
            currentCheckboxes.forEach(cb => {
                cb.checked = selectedIds.includes(cb.value) || selectedIds.includes(String(cb.value)) || selectedIds.includes(parseInt(cb.value));
            });
            updateTransmitButtonState();
        }

        function loadSelectedDeleteIds() {
            const selectedIds = getSelectedDeleteIdsFromUrl();
            const currentCheckboxes = document.querySelectorAll('.record-checkbox');
            currentCheckboxes.forEach(cb => {
                cb.checked = selectedIds.includes(cb.value) || selectedIds.includes(String(cb.value)) || selectedIds.includes(parseInt(cb.value));
            });
            updateDeleteButtonState();
        }

        function updateSelectedRecordIdsInput() {
            const selectedIds = getSelectedIdsFromUrl();
            if (selectedRecordIdsInput) {
                selectedRecordIdsInput.value = selectedIds.join(',');
            }
        }

        function clearSelectedTransmitIds() {
            updateUrlWithSelectedIds([]);
            const currentCheckboxes = document.querySelectorAll('.record-checkbox-transmit');
            currentCheckboxes.forEach(cb => cb.checked = false);
            if (transmitAllBox) transmitAllBox.checked = false;
            updateTransmitButtonState();
            updateSelectedRecordIdsInput();
        }

        function clearSelectedDeleteIds() {
            updateUrlWithSelectedDeleteIds([]);
            const currentCheckboxes = document.querySelectorAll('.record-checkbox');
            currentCheckboxes.forEach(cb => cb.checked = false);
            if (selectAllBox) selectAllBox.checked = false;
            updateDeleteButtonState();
        }

        loadSelectedTransmitIds();
        loadSelectedDeleteIds();
        updateFilterFormHiddenInputs();

        const clearFiltersBtn = document.getElementById('clear-filters-btn');
        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedTransmitIds = getSelectedIdsFromUrl();
                const selectedDeleteIds = getSelectedDeleteIdsFromUrl();
                let url = this.href;

                const unassignedToggle = document.getElementById('unassigned-toggle');
                if (unassignedToggle) {
                    unassignedToggle.checked = false;
                    const bg = document.getElementById('unassigned-toggle-bg');
                    const dot = document.getElementById('unassigned-toggle-dot');
                    if (bg && dot) {
                        bg.style.backgroundColor = '#cbd5e1';
                        dot.style.transform = 'translateX(0)';
                    }
                    const urlObj = new URL(url, window.location.origin);
                    urlObj.searchParams.delete('unassigned_only');
                    url = urlObj.toString();
                }

                if (selectedTransmitIds.length > 0) {
                    const urlObj = new URL(url, window.location.origin);
                    urlObj.searchParams.set('selected_transmit_ids', selectedTransmitIds.join(','));
                    url = urlObj.toString();
                }
                if (selectedDeleteIds.length > 0) {
                    const urlObj = new URL(url, window.location.origin);
                    urlObj.searchParams.set('selected_delete_ids', selectedDeleteIds.join(','));
                    url = urlObj.toString();
                }

                const filterForm = document.getElementById('filter-form');
                if (filterForm) {
                    const textInputs = filterForm.querySelectorAll('input[type="text"], input[type="date"]');
                    textInputs.forEach(input => input.value = '');

                    const selectInputs = filterForm.querySelectorAll('select');
                    selectInputs.forEach(select => {
                        select.selectedIndex = 0;
                    });

                    setTimeout(function() {
                        updateActiveFiltersDisplay();
                    }, 100);

                    const dateReceivedType = document.getElementById('tableDateReceivedType');
                    if (dateReceivedType) {
                        dateReceivedType.value = '';
                        const singleWrap = document.getElementById('tableDateReceivedSingleWrap');
                        const fromWrap = document.getElementById('tableDateReceivedFromWrap');
                        const toWrap = document.getElementById('tableDateReceivedToWrap');

                        if (singleWrap) singleWrap.style.display = 'none';
                        if (fromWrap) fromWrap.style.display = 'none';
                        if (toWrap) toWrap.style.display = 'none';

                        const singleInput = singleWrap?.querySelector('input');
                        const fromInput = fromWrap?.querySelector('input');
                        const toInput = toWrap?.querySelector('input');
                        if (singleInput) singleInput.disabled = true;
                        if (fromInput) fromInput.disabled = true;
                        if (toInput) toInput.disabled = true;
                    }

                    const provinceSelect = document.getElementById('tableProvince');
                    const municipalitySelect = document.getElementById('tableMunicipality');
                    const barangaySelect = document.getElementById('tableBarangay');

                    if (provinceSelect) provinceSelect.value = '';
                    if (municipalitySelect) {
                        municipalitySelect.value = '';
                        municipalitySelect.innerHTML = '<option value="">All Municipalities</option>';
                    }
                    if (barangaySelect) {
                        barangaySelect.value = '';
                        barangaySelect.innerHTML = '<option value="">All Barangays</option>';
                    }
                }

                showLoadingIndicator();

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    const newTableWrapper = doc.querySelector('#table-wrapper');
                    const currentTableWrapper = document.getElementById('table-wrapper');
                    if (newTableWrapper && currentTableWrapper) {
                        currentTableWrapper.innerHTML = newTableWrapper.innerHTML;
                    }

                    const newPagination = doc.querySelector('#pagination-container');
                    const currentPagination = document.getElementById('pagination-container');
                    if (newPagination && currentPagination) {
                        currentPagination.innerHTML = newPagination.innerHTML;
                    }

                    window.history.pushState({}, '', url);

                    reinitializeTableElements();
                    loadSelectedTransmitIds();
                    loadSelectedDeleteIds();

                    updateTransmitButtonState();
                    updateDeleteButtonState();

                    setTimeout(function() {
                        if (window.syncTableScrollbars) {
                            window.syncTableScrollbars();
                        }
                    }, 100);

                    const toggleBtn = document.getElementById('select-records-transmit');
                    const isCancelSelection = toggleBtn && toggleBtn.textContent.includes('Cancel');

                    if (isCancelSelection) {
                        const colCheckboxes = document.querySelectorAll('.col-checkbox-transmit');
                        const recordCheckboxes = document.querySelectorAll('.record-checkbox-transmit');
                        const selectAllBoxes = document.querySelectorAll('#select-all-transmit');

                        colCheckboxes.forEach(el => {
                            el.style.display = 'table-cell';
                        });
                        recordCheckboxes.forEach(cb => {
                            cb.style.display = 'block';
                        });
                        selectAllBoxes.forEach(box => {
                            box.style.display = 'block';
                        });
                    }

                    const deleteToggleBtn = document.getElementById('delete-multiple');
                    const isCancelDelete = deleteToggleBtn && deleteToggleBtn.textContent.includes('Cancel');

                    if (isCancelDelete) {
                        const colDeleteCheckboxes = document.querySelectorAll('.col-checkbox');
                        const deleteRecordCheckboxes = document.querySelectorAll('.record-checkbox');
                        const selectAllDeleteBoxes = document.querySelectorAll('#select-all');

                        colDeleteCheckboxes.forEach(el => {
                            el.style.display = 'table-cell';
                        });
                        deleteRecordCheckboxes.forEach(cb => {
                            cb.style.display = 'block';
                        });
                        selectAllDeleteBoxes.forEach(box => {
                            box.style.display = 'block';
                        });
                    }

                    document.querySelectorAll('.pagination-link').forEach(link => {
                        link.addEventListener('click', arguments.callee);
                    });
                })
                .catch(error => {
                    window.location.href = url;
                });
            });
        }

        const clearSelectionsBtn = document.getElementById('clear-selections');
        if (clearSelectionsBtn) {
            clearSelectionsBtn.addEventListener('click', function() {
                clearSelectedTransmitIds();
                clearSelectedDeleteIds();
                selectedIdsOrder.length = 0;
                selectedSourcesOrder.length = 0;
                updateFilterFormHiddenInputs();
            });
        }

        const filterForm = document.getElementById('filter-form');
        const applyFiltersBtn = document.getElementById('apply-filters-btn');

        function updateActiveFiltersDisplay() {
            const activeFiltersList = document.getElementById('active-filters-list');
            const noFiltersMessage = document.getElementById('no-filters-message');

            if (!activeFiltersList || !filterForm) return;

            const filters = [];

            const formData = new FormData(filterForm);

            if (formData.get('farmerName')) {
                filters.push(`<span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Farmer: ${formData.get('farmerName')}</span>`);
            }
            if (formData.get('encoderName')) {
                filters.push(`<span style="background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Encoder: ${formData.get('encoderName')}</span>`);
            }
            if (formData.get('program')) {
                filters.push(`<span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Program: ${formData.get('program')}</span>`);
            }
            if (formData.get('line')) {
                filters.push(`<span style="background: #fce7f3; color: #9f1239; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Line: ${formData.get('line')}</span>`);
            }
            if (formData.get('province')) {
                filters.push(`<span style="background: #e0e7ff; color: #3730a3; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Province: ${formData.get('province')}</span>`);
            }
            if (formData.get('municipality')) {
                filters.push(`<span style="background: #f3e8ff; color: #6b21a8; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Municipality: ${formData.get('municipality')}</span>`);
            }
            if (formData.get('barangay')) {
                filters.push(`<span style="background: #ecfdf5; color: #065f46; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Barangay: ${formData.get('barangay')}</span>`);
            }
            if (formData.get('source')) {
                filters.push(`<span style="background: #fef2f2; color: #991b1b; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Source: ${formData.get('source')}</span>`);
            }
            if (formData.get('modeOfPayment')) {
                filters.push(`<span style="background: #f0fdf4; color: #166534; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Payment: ${formData.get('modeOfPayment')}</span>`);
            }
            if (formData.get('accounts')) {
                filters.push(`<span style="background: #f8fafc; color: #475569; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Account: ${formData.get('accounts')}</span>`);
            }
            if (formData.get('transmittal_number')) {
                filters.push(`<span style="background: #f0f9ff; color: #075985; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Transmittal #: ${formData.get('transmittal_number')}</span>`);
            }
            if (formData.get('admin_transmittal_number')) {
                filters.push(`<span style="background: #fdf4ff; color: #7c3aed; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Admin Transmittal #: ${formData.get('admin_transmittal_number')}</span>`);
            }

            if (formData.get('date_received_type') === 'single' && formData.get('date_received_single')) {
                filters.push(`<span style="background: #fff7ed; color: #9a3412; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Date: ${formData.get('date_received_single')}</span>`);
            } else if (formData.get('date_received_type') === 'range') {
                const dateFrom = formData.get('date_received_from');
                const dateTo = formData.get('date_received_to');
                let dateFilter = 'Date Range: ';
                if (dateFrom) dateFilter += `From ${dateFrom}`;
                if (dateFrom && dateTo) dateFilter += ' ';
                if (dateTo) dateFilter += `To ${dateTo}`;
                if (dateFrom || dateTo) {
                    filters.push(`<span style="background: #fff7ed; color: #9a3412; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">${dateFilter}</span>`);
                }
            }

            const unassignedToggle = document.getElementById('unassigned-toggle');
            if (unassignedToggle && unassignedToggle.checked) {
                filters.push(`<span style="background: #fef2f2; color: #dc2626; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">Show Only Unassigned</span>`);
            }

            if (filters.length > 0) {
                if (noFiltersMessage) {
                    noFiltersMessage.style.display = 'none';
                }
                activeFiltersList.innerHTML = filters.join(' ');
            } else {
                if (noFiltersMessage) {
                    noFiltersMessage.style.display = 'inline';
                }
                activeFiltersList.innerHTML = '<span id="no-filters-message" style="font-size: 13px; color: #94a3b8; font-style: italic;">No filters applied</span>';
            }
        }

        function submitFilterForm() {
            if (!filterForm) return;

            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);

            const unassignedToggle = document.getElementById('unassigned-toggle');
            if (unassignedToggle) {
                if (unassignedToggle.checked) {
                    params.set('unassigned_only', '1');
                } else {
                    params.delete('unassigned_only');
                }
            }

            params.set('page', '1');

            const selectedTransmitIds = getSelectedIdsFromUrl();
            const selectedDeleteIds = getSelectedDeleteIdsFromUrl();
            if (selectedTransmitIds.length > 0) {
                params.set('selected_transmit_ids', selectedTransmitIds.join(','));
            }
            if (selectedDeleteIds.length > 0) {
                params.set('selected_delete_ids', selectedDeleteIds.join(','));
            }

            const url = `${filterForm.action}?${params.toString()}`;
            showLoadingIndicator();

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const newTableWrapper = doc.querySelector('#table-wrapper');
                const currentTableWrapper = document.getElementById('table-wrapper');
                if (newTableWrapper && currentTableWrapper) {
                    currentTableWrapper.innerHTML = newTableWrapper.innerHTML;

                    setTimeout(function() {
                        initializeRowClickHighlighting();
                    }, 100);
                }

                const newDash3Summary = doc.querySelector('.dash3-summary');
                const currentDash3Summary = document.querySelector('.dash3-summary');
                if (newDash3Summary && currentDash3Summary) {
                    currentDash3Summary.innerHTML = newDash3Summary.innerHTML;
                }

                const newDash3ChartsRow = doc.querySelector('.dash3-charts-row');
                const currentDash3ChartsRow = document.querySelector('.dash3-charts-row');
                if (newDash3ChartsRow && currentDash3ChartsRow) {
                    currentDash3ChartsRow.innerHTML = newDash3ChartsRow.innerHTML;
                }

                const newDash3Grid = doc.querySelector('#dash3-grid');
                const currentDash3Grid = document.getElementById('dash3-grid');
                if (newDash3Grid && currentDash3Grid) {
                    currentDash3Grid.innerHTML = newDash3Grid.innerHTML;
                }

                const newPagination = doc.querySelector('#pagination-container');
                const currentPagination = document.getElementById('pagination-container');
                if (newPagination && currentPagination) {
                    currentPagination.innerHTML = newPagination.innerHTML;
                }

                window.history.pushState({}, '', url);

                reinitializeTableElements();
                loadSelectedTransmitIds();
                loadSelectedDeleteIds();

                updateTransmitButtonState();
                updateDeleteButtonState();

                setTimeout(function() {
                    if (window.syncTableScrollbars) {
                        window.syncTableScrollbars();
                    }
                }, 100);

                const toggleBtn = document.getElementById('select-records-transmit');
                const isCancelSelection = toggleBtn && toggleBtn.textContent.includes('Cancel');

                if (isCancelSelection) {
                    const colCheckboxes = document.querySelectorAll('.col-checkbox-transmit');
                    const recordCheckboxes = document.querySelectorAll('.record-checkbox-transmit');
                    const selectAllBoxes = document.querySelectorAll('#select-all-transmit');

                    colCheckboxes.forEach(el => {
                        el.style.display = 'table-cell';
                    });
                    recordCheckboxes.forEach(cb => {
                        cb.style.display = 'block';
                    });
                    selectAllBoxes.forEach(box => {
                        box.style.display = 'block';
                    });
                }

                const deleteToggleBtn = document.getElementById('delete-multiple');
                const isCancelDelete = deleteToggleBtn && deleteToggleBtn.textContent.includes('Cancel');

                if (isCancelDelete) {
                    const colDeleteCheckboxes = document.querySelectorAll('.col-checkbox');
                    const deleteRecordCheckboxes = document.querySelectorAll('.record-checkbox');
                    const selectAllDeleteBoxes = document.querySelectorAll('#select-all');

                    colDeleteCheckboxes.forEach(el => {
                        el.style.display = 'table-cell';
                    });
                    deleteRecordCheckboxes.forEach(cb => {
                        cb.style.display = 'block';
                    });
                    selectAllDeleteBoxes.forEach(box => {
                        box.style.display = 'block';
                    });
                }

                document.querySelectorAll('.pagination-link').forEach(link => {
                    link.addEventListener('click', arguments.callee);
                });
            })
            .catch(error => {
                window.location.href = url;
            });
        }

        if (filterForm) {
            const filterInputs = filterForm.querySelectorAll('input, select');
            filterInputs.forEach(input => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        submitFilterForm();
                    }
                });
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const activeElement = document.activeElement;
                const isInFilterForm = filterForm && filterForm.contains(activeElement);
                const isFilterInput = activeElement && (
                    activeElement.id === 'filter-form' ||
                    activeElement.closest('#filter-form')
                );

                if (isInFilterForm || isFilterInput) {
                    e.preventDefault();
                    const clearFiltersShortcutBtn = document.getElementById('clear-filters-shortcut-btn');
                    if (clearFiltersShortcutBtn) {
                        clearFiltersShortcutBtn.click();
                    }
                }
            }
        });

        const clearFiltersShortcutBtn = document.getElementById('clear-filters-shortcut-btn');
        if (clearFiltersShortcutBtn) {
            clearFiltersShortcutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = "{{ route('admin', ['tab' => 'nl-records']) }}";
            });
        }

        if (filterForm) {
            const filterInputs = filterForm.querySelectorAll('input, select');
            filterInputs.forEach(input => {
                input.addEventListener('input', updateActiveFiltersDisplay);
                input.addEventListener('change', updateActiveFiltersDisplay);
            });

            const unassignedToggle = document.getElementById('unassigned-toggle');
            if (unassignedToggle) {
                unassignedToggle.addEventListener('change', updateActiveFiltersDisplay);
            }

            const perPageSelect = filterForm.querySelector('select[name="per_page"]');
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function() {
                    submitFilterForm();
                });
            }
        }

        function initializeRowClickHighlighting() {
            const tableRows = document.querySelectorAll('.records-table tbody tr.record-row');
            console.log('Initializing row highlighting for', tableRows.length, 'rows');

            const tableBody = document.querySelector('.records-table tbody');
            if (tableBody) {
                tableBody.removeEventListener('click', handleTableClick);

                tableBody.addEventListener('click', handleTableClick);
                console.log('Added event delegation listener to table body');
            }
        }

        function handleTableClick(e) {
            const row = e.target.closest('tr.record-row');
            if (!row) {
                console.log('Click not on a record row');
                return;
            }

            if (e.target.closest('button') || e.target.closest('input') || e.target.closest('a') || e.target.closest('.farmer-name-copy')) {
                console.log('Click on interactive element, skipping highlight');
                return;
            }

            console.log('Row clicked via delegation');

            const isHighlighted = row.style.backgroundColor === '#006c35';

            if (isHighlighted) {
                console.log('Unhighlighting row');

                row.style.backgroundColor = '';
                row.style.color = '';

                const cells = row.querySelectorAll('td');
                cells.forEach(cell => {
                    cell.style.color = '';
                    const accountField = cell.querySelector('.account-field');
                    if (accountField) {
                        accountField.style.color = '#D4A017';
                    }
                });
            } else {
                console.log('Highlighting row');

                const allRows = document.querySelectorAll('.records-table tbody tr.record-row');
                allRows.forEach(r => {
                    r.style.backgroundColor = '';
                    r.style.color = '';
                    const cells = r.querySelectorAll('td');
                    cells.forEach(cell => {
                        cell.style.color = '';
                        const accountField = cell.querySelector('.account-field');
                        if (accountField) {
                            accountField.style.color = '#D4A017';
                        }
                    });
                });

                row.style.backgroundColor = '#006c35';
                row.style.color = 'white';

                const cells = row.querySelectorAll('td');
                cells.forEach(cell => {
                    cell.style.color = 'white';

                    const accountField = cell.querySelector('.account-field');
                    if (accountField) {
                        accountField.style.color = 'white';
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateActiveFiltersDisplay();
            initializeRowClickHighlighting();
        });

        if (applyFiltersBtn) {
            applyFiltersBtn.addEventListener('click', function(e) {
                e.preventDefault();
                submitFilterForm();
            });
        }

        const paginationLinks = document.querySelectorAll('.pagination-link');

        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                let url = this.href;

                const unassignedToggle = document.getElementById('unassigned-toggle');
                if (unassignedToggle) {
                    const urlObj = new URL(url, window.location.origin);
                    if (unassignedToggle.checked) {
                        urlObj.searchParams.set('unassigned_only', '1');
                    } else {
                        urlObj.searchParams.delete('unassigned_only');
                    }
                    url = urlObj.toString();
                }

                const selectedIds = getSelectedIdsFromUrl();
                if (selectedIds.length > 0) {
                    const urlObj = new URL(url, window.location.origin);
                    urlObj.searchParams.set('selected_transmit_ids', selectedIds.join(','));
                    url = urlObj.toString();
                }
                const selectedDeleteIds = getSelectedDeleteIdsFromUrl();
                if (selectedDeleteIds.length > 0) {
                    const urlObj = new URL(url, window.location.origin);
                    urlObj.searchParams.set('selected_delete_ids', selectedDeleteIds.join(','));
                    url = urlObj.toString();
                }
                showLoadingIndicator();

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    const newTableWrapper = doc.querySelector('#table-wrapper');
                    const currentTableWrapper = document.getElementById('table-wrapper');
                    if (newTableWrapper && currentTableWrapper) {
                        currentTableWrapper.innerHTML = newTableWrapper.innerHTML;
                    }

                    const newPagination = doc.querySelector('#pagination-container');
                    const currentPagination = document.getElementById('pagination-container');
                    if (newPagination && currentPagination) {
                        currentPagination.innerHTML = newPagination.innerHTML;
                    }

                    window.history.pushState({}, '', url);

                    reinitializeTableElements();
                    loadSelectedTransmitIds();
                    loadSelectedDeleteIds();

                    updateTransmitButtonState();
                    updateDeleteButtonState();

                    setTimeout(function() {
                        if (window.syncTableScrollbars) {
                            window.syncTableScrollbars();
                        }
                    }, 100);

                    const toggleBtn = document.getElementById('select-records-transmit');
                    const isCancelSelection = toggleBtn && toggleBtn.textContent.includes('Cancel');

                    if (isCancelSelection) {
                        const colCheckboxes = document.querySelectorAll('.col-checkbox-transmit');
                        const recordCheckboxes = document.querySelectorAll('.record-checkbox-transmit');
                        const selectAllBoxes = document.querySelectorAll('#select-all-transmit');

                        colCheckboxes.forEach(el => {
                            el.style.display = 'table-cell';
                        });
                        recordCheckboxes.forEach(cb => {
                            cb.style.display = 'block';
                        });
                        selectAllBoxes.forEach(box => {
                            box.style.display = 'block';
                        });
                    }

                    const deleteToggleBtn = document.getElementById('delete-multiple');
                    const isCancelDelete = deleteToggleBtn && deleteToggleBtn.textContent.includes('Cancel');

                    if (isCancelDelete) {
                        const colDeleteCheckboxes = document.querySelectorAll('.col-checkbox');
                        const deleteRecordCheckboxes = document.querySelectorAll('.record-checkbox');
                        const selectAllDeleteBoxes = document.querySelectorAll('#select-all');

                        colDeleteCheckboxes.forEach(el => {
                            el.style.display = 'table-cell';
                        });
                        deleteRecordCheckboxes.forEach(cb => {
                            cb.style.display = 'block';
                        });
                        selectAllDeleteBoxes.forEach(box => {
                            box.style.display = 'block';
                        });
                    }

                    document.querySelectorAll('.pagination-link').forEach(link => {
                        link.addEventListener('click', arguments.callee);
                    });
                })
                .catch(error => {
                    window.location.href = url;
                });
            });
        });

        function reinitializeTableElements() {
            const newTransmitCheckboxes = document.querySelectorAll('.record-checkbox-transmit');
            const newTransmitAllBox = document.getElementById('select-all-transmit');
            const newDeleteCheckboxes = document.querySelectorAll('.record-checkbox');
            const newSelectAllBox = document.getElementById('select-all');

            newTransmitCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const selectedIds = getSelectedIdsFromUrl();
                    const checkboxValue = cb.value;
                    const source = cb.dataset.source;

                    if (this.checked) {
                        if (!selectedIds.includes(checkboxValue)) {
                            selectedIds.push(checkboxValue);
                            selectedIdsOrder.push(checkboxValue);
                            if (source && !selectedSourcesOrder.includes(source)) {
                                selectedSourcesOrder.push(source);
                            }
                        }
                    } else {
                        const index = selectedIds.indexOf(checkboxValue);
                        if (index > -1) {
                            selectedIds.splice(index, 1);
                            const orderIndex = selectedIdsOrder.indexOf(checkboxValue);
                            if (orderIndex > -1) {
                                selectedIdsOrder.splice(orderIndex, 1);
                            }
                            if (source) {
                                const sourceStillSelected = selectedIdsOrder.some(id => {
                                    const checkbox = document.querySelector(`.record-checkbox-transmit[value="${id}"]`);
                                    return checkbox && checkbox.dataset.source === source;
                                });
                                if (!sourceStillSelected) {
                                    const sourceIndex = selectedSourcesOrder.indexOf(source);
                                    if (sourceIndex > -1) {
                                        selectedSourcesOrder.splice(sourceIndex, 1);
                                    }
                                }
                            }
                        }
                    }
                    updateUrlWithSelectedIds(selectedIds);
                    updateTransmitButtonState();
                });
            });

            newTransmitAllBox?.addEventListener('change', function() {
                let selectedIds = getSelectedIdsFromUrl();

                if (this.checked) {
                    newTransmitCheckboxes.forEach(cb => {
                        cb.checked = true;
                        const source = cb.dataset.source;
                        if (!selectedIds.includes(cb.value)) {
                            selectedIds.push(cb.value);
                            selectedIdsOrder.push(cb.value);
                            if (source && !selectedSourcesOrder.includes(source)) {
                                selectedSourcesOrder.push(source);
                            }
                        }
                    });
                } else {
                    newTransmitCheckboxes.forEach(cb => {
                        cb.checked = false;
                        const index = selectedIds.indexOf(cb.value);
                        if (index > -1) {
                            selectedIds.splice(index, 1);
                            const orderIndex = selectedIdsOrder.indexOf(cb.value);
                            if (orderIndex > -1) {
                                selectedIdsOrder.splice(orderIndex, 1);
                            }
                        }
                    });
                    selectedSourcesOrder.length = 0;
                }
                updateUrlWithSelectedIds(selectedIds);
                updateTransmitButtonState();
            });

            newDeleteCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const selectedIds = getSelectedDeleteIdsFromUrl();
                    const checkboxValue = cb.value;
                    if (this.checked) {
                        if (!selectedIds.includes(checkboxValue)) {
                            selectedIds.push(checkboxValue);
                        }
                    } else {
                        const index = selectedIds.indexOf(checkboxValue);
                        if (index > -1) {
                            selectedIds.splice(index, 1);
                        }
                    }
                    updateUrlWithSelectedDeleteIds(selectedIds);
                    updateDeleteButtonState();
                });
            });

            newSelectAllBox?.addEventListener('change', function() {
                let selectedIds = getSelectedDeleteIdsFromUrl();

                if (this.checked) {
                    newDeleteCheckboxes.forEach(cb => {
                        cb.checked = true;
                        if (!selectedIds.includes(cb.value)) {
                            selectedIds.push(cb.value);
                        }
                    });
                } else {
                    newDeleteCheckboxes.forEach(cb => {
                        cb.checked = false;
                        const index = selectedIds.indexOf(cb.value);
                        if (index > -1) {
                            selectedIds.splice(index, 1);
                        }
                    });
                }
                updateUrlWithSelectedDeleteIds(selectedIds);
                updateDeleteButtonState();
            });

            updateFilterFormHiddenInputs();

            const newPaginationLinks = document.querySelectorAll('.pagination-link');
            newPaginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    let url = this.href;

                    const unassignedToggle = document.getElementById('unassigned-toggle');
                    if (unassignedToggle) {
                        const urlObj = new URL(url, window.location.origin);
                        if (unassignedToggle.checked) {
                            urlObj.searchParams.set('unassigned_only', '1');
                        } else {
                            urlObj.searchParams.delete('unassigned_only');
                        }
                        url = urlObj.toString();
                    }

                    const selectedIds = getSelectedIdsFromUrl();
                    if (selectedIds.length > 0) {
                        const urlObj = new URL(url, window.location.origin);
                        urlObj.searchParams.set('selected_transmit_ids', selectedIds.join(','));
                        url = urlObj.toString();
                    }
                    const selectedDeleteIds = getSelectedDeleteIdsFromUrl();
                    if (selectedDeleteIds.length > 0) {
                        const urlObj = new URL(url, window.location.origin);
                        urlObj.searchParams.set('selected_delete_ids', selectedDeleteIds.join(','));
                        url = urlObj.toString();
                    }
                    showLoadingIndicator();

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        const newTableWrapper = doc.querySelector('#table-wrapper');
                        const currentTableWrapper = document.getElementById('table-wrapper');
                        if (newTableWrapper && currentTableWrapper) {
                            currentTableWrapper.innerHTML = newTableWrapper.innerHTML;
                        }

                        const newPagination = doc.querySelector('#pagination-container');
                        const currentPagination = document.getElementById('pagination-container');
                        if (newPagination && currentPagination) {
                            currentPagination.innerHTML = newPagination.innerHTML;
                        }

                        window.history.pushState({}, '', url);

                        reinitializeTableElements();
                        loadSelectedTransmitIds();
                        loadSelectedDeleteIds();

                        updateTransmitButtonState();
                        updateDeleteButtonState();

                        setTimeout(function() {
                            if (window.syncTableScrollbars) {
                                window.syncTableScrollbars();
                            }
                        }, 100);

                        const toggleBtn = document.getElementById('select-records-transmit');
                        const isCancelSelection = toggleBtn && toggleBtn.textContent.includes('Cancel');

                        if (isCancelSelection) {
                            const colCheckboxes = document.querySelectorAll('.col-checkbox-transmit');
                            const recordCheckboxes = document.querySelectorAll('.record-checkbox-transmit');
                            const selectAllBoxes = document.querySelectorAll('#select-all-transmit');

                            colCheckboxes.forEach(el => {
                                el.style.display = 'table-cell';
                            });
                            recordCheckboxes.forEach(cb => {
                                cb.style.display = 'block';
                            });
                            selectAllBoxes.forEach(box => {
                                box.style.display = 'block';
                            });
                        }

                        const deleteToggleBtn = document.getElementById('delete-multiple');
                        const isCancelDelete = deleteToggleBtn && deleteToggleBtn.textContent.includes('Cancel');

                        if (isCancelDelete) {
                            const colDeleteCheckboxes = document.querySelectorAll('.col-checkbox');
                            const deleteRecordCheckboxes = document.querySelectorAll('.record-checkbox');
                            const selectAllDeleteBoxes = document.querySelectorAll('#select-all');

                            colDeleteCheckboxes.forEach(el => {
                                el.style.display = 'table-cell';
                            });
                            deleteRecordCheckboxes.forEach(cb => {
                                cb.style.display = 'block';
                            });
                            selectAllDeleteBoxes.forEach(box => {
                                box.style.display = 'block';
                            });
                        }

                        document.querySelectorAll('.pagination-link').forEach(link => {
                            link.addEventListener('click', arguments.callee);
                        });
                    })
                    .catch(error => {
                        window.location.href = url;
                    });
                });
            });
        }

        transmitActionBtn?.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            const selectedIds = getSelectedIdsFromUrl();

            if (selectedIds.length > 0) {
                updateUrlWithSelectedIds([]);

                const printPreviewUrl = "{{ route('admin.print-preview') }}?ids=" + encodeURIComponent(selectedIds.join(',')) + "&order=" + encodeURIComponent(selectedIdsOrder.join(',')) + "&sources=" + encodeURIComponent(selectedSourcesOrder.join(','));
                window.open(printPreviewUrl, '_blank');
                this.style.backgroundColor = '#6c757d';
            } else {
                this.textContent = 'Delete Multiple';
                this.style.backgroundColor = '';

                recordCheckboxes.forEach(cb => cb.checked = false);
                if(selectAllBox) selectAllBox.checked = false;
                if(deleteSelectedBtn) deleteSelectedBtn.disabled = true;
            }
        });

        selectAllBox?.addEventListener('change', function() {
            let selectedIds = getSelectedDeleteIdsFromUrl();
            const currentCheckboxes = document.querySelectorAll('.record-checkbox');

            if (this.checked) {
                currentCheckboxes.forEach(cb => {
                    cb.checked = true;
                    if (!selectedIds.includes(cb.value)) {
                        selectedIds.push(cb.value);
                    }
                });
            } else {
                currentCheckboxes.forEach(cb => {
                    cb.checked = false;
                    const index = selectedIds.indexOf(cb.value);
                    if (index > -1) {
                        selectedIds.splice(index, 1);
                    }
                });
            }
            updateUrlWithSelectedDeleteIds(selectedIds);
            updateDeleteButtonState();
        });

        deleteSelectedBtn?.addEventListener('click', function() {
            if (!this.disabled) {
                const selectedIds = getSelectedDeleteIdsFromUrl();
                if (selectedIds.length > 0) {
                    const listElement = document.querySelector('.bulk-delete-list');
                    listElement.innerHTML = '';
                    const li = document.createElement('li');
                    li.textContent = `${selectedIds.length} record(s) will be deleted`;
                    li.className = 'text-sm text-gray-700 py-1 font-semibold';
                    listElement.appendChild(li);
                    bulkDeleteDialog?.showModal();
                }
            }
        });

        document.getElementById('confirm-admin-bulk-delete')?.addEventListener('click', () => {
            const selectedIds = getSelectedDeleteIdsFromUrl();
            if (selectedRecordIdsInput) {
                selectedRecordIdsInput.value = selectedIds.join(',');
            }
            updateUrlWithSelectedDeleteIds([]);
            document.getElementById('bulk-form')?.submit();
        });

        document.querySelector('.cancelBulkDelete')?.addEventListener('click', () => {
            bulkDeleteDialog?.close();
        });

        document.querySelectorAll('form[action="{{ route('admin') }}"], #bulk-form').forEach(formEl => {
            if (formEl.id !== 'filter-form') {
                formEl.addEventListener('submit', showLoadingIndicator);
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.target && ['INPUT', 'TEXTAREA', 'SELECT'].includes(event.target.tagName)) {
                return;
            }
            if (event.key.toLowerCase() === 'd') {
                window.adminShowTab?.('dashboard');
            } else if (event.key.toLowerCase() === 'n') {
                window.adminShowTab?.('nl-records');
            } else if (event.key === '/') {
                event.preventDefault();
                window.adminShowTab?.('nl-records');
                document.querySelector('input[name="farmerName"]')?.focus();
            }
        });

        const editRecordDialog = document.getElementById('recordEditDialog');
        const closeEditRecordModal = document.querySelector('.closeEditRecordDialog');
        const editRecordForm = document.getElementById('recordEditForm');

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
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(function(response) {
                    console.log('Response status:', response.status);
                    console.log('Response ok:', response.ok);

                    if (response.status === 404) {
                        return response.json().then(function(data) {
                            throw new Error(data.message || 'Record not found. Please refresh the page and try again.');
                        });
                    }

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

                    if (error.message && error.message.includes('Record not found')) {
                        showModalMessage(error.message, 'error');

                        setTimeout(function() {
                            const filterForm = document.getElementById('filter-form');
                            if (filterForm) {
                                const event = new Event('submit');
                                filterForm.dispatchEvent(event);
                            } else {
                                window.location.reload();
                            }
                        }, 2000);
                    } else {
                        showModalMessage('Error updating record. Please try again.', 'error');
                    }
                })
                .finally(function() {
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.textContent = 'Update Record';
                    }
                });
            });
        }

    });

        document.addEventListener('click', function (e) {
            const btn = e.target?.closest?.('.dashProvinceSlicer');
            if (!btn) return;
            const select = document.getElementById('dashProvince');
            if (!select) return;
            select.value = btn.getAttribute('data-value') ?? '';
            const form = select.closest('form');
            form?.submit();
        });

</script>



    </div>

        </div>
    </dialog>


    <dialog class="user-maintenance-dialog largeModal rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0" id="userMaintenanceModal">
        <div class="user-maintenance-header">
            <div>
                <h3 class="user-maintenance-heading">User Maintenance</h3>
                <p class="user-maintenance-subheading">User management</p>
            </div>
            <button type="button" class="addOfficerButton user-maintenance-add h-9 px-4 rounded-lg text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Add New User</button>
        </div>
        <div class="user-maintenance-body">
            <label class="user-maintenance-search-wrap block" for="userMaintenanceSearch">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path stroke-linecap="round" d="m20 20-4-4"></path>
                </svg>
                <input type="search" id="userMaintenanceSearch" class="user-maintenance-search" placeholder="Search by name or username" autocomplete="off">
            </label>
            <div id="userMaintenanceContent">
                <div class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-pcic-700"></div>
                    <p class="text-sm text-gray-500 mt-2">Loading users...</p>
                </div>
            </div>
        </div>
        <div class="user-maintenance-footer">
            <button type="button" class="closeUserMaintenanceModal h-9 px-4 rounded-lg border border-gray-300 bg-white text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer">Close</button>
        </div>
    </dialog>

        </main>
    </div>

@endsection
