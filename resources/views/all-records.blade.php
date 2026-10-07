@extends('layout.layout')

@section('title', 'All NL Records')
@section('body-class', 'public-records-page')

@section('page-styles')
<style id="public-page-styles">
.public-workspace-shell {
    display: grid;
    min-height: 100vh;
    grid-template-columns: 232px minmax(0, 1fr);
    background: #e8eef2;
}

.public-workspace-sidebar {
    position: sticky;
    top: 0;
    display: flex;
    height: 100vh;
    box-sizing: border-box;
    flex-direction: column;
    gap: 24px;
    padding: 18px 14px;
    background: linear-gradient(160deg, #064e3b, #082f49);
    color: #fff;
}

.public-workspace-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    color: inherit;
    text-decoration: none;
}

.public-workspace-brand img {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    object-fit: cover;
}

.public-workspace-brand strong,
.public-workspace-brand small {
    display: block;
}

.public-workspace-brand strong { font-size: 12px; }
.public-workspace-brand small { margin-top: 3px; color: #bbf7d0; font-size: 10px; }

.public-workspace-links {
    display: grid;
    gap: 7px;
}

.public-workspace-links a,
.public-workspace-back {
    display: block;
    padding: 11px 12px;
    border: 1px solid rgba(226, 232, 240, .16);
    border-radius: 8px;
    color: #e2e8f0;
    font-size: 12px;
    font-weight: 750;
    text-decoration: none;
}

.public-workspace-links a:hover,
.public-workspace-links a[aria-current="page"] {
    border-color: #86efac;
    background: rgba(134, 239, 172, .14);
    color: #fff;
}

.public-workspace-back { margin-top: auto; }
.public-workspace-content { min-width: 0; }
.public-content-shortcut { color:#166534; font-size:11px; font-weight:800; text-decoration:none; }

@media (max-width: 760px) {
    .public-workspace-shell { grid-template-columns:1fr; }
    .public-workspace-sidebar { position:static; height:auto; gap:12px; padding:12px; }
    .public-workspace-links { grid-template-columns:repeat(2,minmax(0,1fr)); }
    .public-workspace-back { margin-top:0; }
}

/* Main content area */
.records-main {
    padding: 12px 12px 16px 12px;
    min-height: calc(100vh - 72px);
    overflow-y: auto;
    overscroll-behavior: contain;
}

/* System-matched filter section */
.table-filters {
    border-radius: 16px !important;
    border: 1px solid rgba(148, 163, 184, 0.24) !important;
    background: rgba(15, 23, 42, 0.94) !important;
    box-shadow: 0 10px 24px rgba(2,6,23,0.28) !important;
    margin-bottom: 8px !important;
    padding: 8px !important;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 8px;
    align-items: start;
}

.form-field {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.form-field label {
    font-size: 12px;
    font-weight: 600;
    color: #e2e8f0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-field input,
.form-field select {
    padding: 6px 8px;
    border: 1px solid rgba(148, 163, 184, 0.24);
    border-radius: 6px;
    font-size: 12px;
    background: #020617;
    color: #f8fafc;
    transition: all 0.2s;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
}

.form-field input:focus,
.form-field select:focus {
    outline: none;
    border-color: #006c35;
    box-shadow: 0 0 0 3px rgba(0, 108, 53, 0.1);
}

.filter-actions {
    display: flex;
    gap: 6px;
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid rgba(148, 163, 184, 0.2);
    justify-content: flex-end;
}

.btn {
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-primary {
    background: linear-gradient(135deg, #006c35 0%, #008a43 100%);
    color: white;
    box-shadow: 0 2px 4px rgba(0, 108, 53, 0.2);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #005428 0%, #006c35 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 108, 53, 0.3);
}

.btn-muted {
    background: rgba(30, 41, 59, 0.95);
    color: #e2e8f0;
    border: 1px solid rgba(148, 163, 184, 0.24);
}

.btn-muted:hover {
    background: rgba(51, 65, 85, 0.95);
    color: #f8fafc;
}

/* System-matched table container */
.table-wrapper {
    width: 100%;
    border-radius: 16px;
    border: 1px solid rgba(148, 163, 184, 0.24);
    box-shadow: 0 1px 3px rgba(2, 6, 23, 0.2);
    max-height: calc(100vh - 380px);
    overflow-y: auto;
    overflow-x: auto;
    background: rgba(15, 23, 42, 0.94);
}

/* System-matched table styling */
table {
    width: 100%;
    max-width: 1200px;
    border-collapse: separate;
    border-spacing: 0;
    border: 1px solid rgba(148, 163, 184, 0.2);
    box-shadow: 0 12px 28px rgba(2, 6, 23, 0.18);
    border-radius: 14px;
    overflow: hidden;
    margin: 0;
    background: rgba(15, 23, 42, 0.94);
}

/* Farmer name copy hover effect */
.farmer-name-copy:hover {
    color: #D4A017 !important;
}

table thead tr:first-child {
    background: linear-gradient(135deg, rgba(0, 108, 53, 0.96) 0%, rgba(99, 140, 8, 0.90) 100%);
}


table th {
    padding: 8px 10px;
    text-align: left;
    font-weight: 900;
    font-size: 12px;
    color: white;
    white-space: nowrap;
}

table tbody tr {
    border-bottom: 1px solid rgba(15, 23, 42, 0.06);
    transition: background-color 0.2s ease;
}

table tbody tr:nth-child(odd) {
    background-color: rgba(15, 23, 42, 0.95);
}

table tbody tr:nth-child(even) {
    background-color: rgba(17, 24, 39, 0.82);
}

table tbody tr:hover {
    background-color: rgba(59, 130, 246, 0.16);
}

table td {
    padding: 8px 10px;
    font-size: 12px;
    color: #e2e8f0;
}

/* Prevent all columns from wrapping */
table td,
table th {
    white-space: nowrap;
}

table td:last-child {
    color: var(--primary);
}

/* System-matched view button */
table input[type="checkbox"] {
    cursor: pointer;
    width: 18px;
    height: 18px;
    accent-color: #006c35;
}

.view-btn {
    background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%);
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 4px rgba(14, 165, 233, 0.2);
}

.view-btn:hover {
    background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(14, 165, 233, 0.3);
}

/* System-matched pagination */
.pagination-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin-top: 12px;
    padding: 8px 12px;
    background: rgba(15, 23, 42, 0.94);
    border-radius: 12px;
    border: 1px solid rgba(148, 163, 184, 0.24);
    box-shadow: 0 10px 24px rgba(2,6,23,0.24);
}

.pagination-link {
    padding: 6px 12px;
    border-radius: 6px;
    background: linear-gradient(135deg, #006c35 0%, #008a43 100%);
    color: white;
    text-decoration: none;
    font-weight: 500;
    font-size: 12px;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0, 108, 53, 0.1);
}

.pagination-link:hover {
    background: linear-gradient(135deg, #005a2d 0%, #006c35 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 108, 53, 0.2);
}

.pagination-info {
    padding: 6px 12px;
    border-radius: 6px;
    background: rgba(17, 24, 39, 0.9);
    color: #cbd5e1;
    font-weight: 600;
    font-size: 12px;
    border: 1px solid rgba(148, 163, 184, 0.2);
}

/* System-matched modal */
.largeModal {
    border-radius: 16px !important;
    box-shadow: 0 25px 50px -12px rgba(2, 6, 23, 0.45) !important;
    background: #020617 !important;
    color: #f8fafc !important;
    backdrop-filter: blur(8px) !important;
}

.modal-header {
    padding: 20px 24px 16px;
    border-bottom: 1px solid #e2e8f0;
    background: linear-gradient(135deg, rgba(0, 108, 53, 0.96) 0%, rgba(99, 140, 8, 0.90) 100%);
    color: white;
    border-radius: 16px 16px 0 0;
}

.modal-title {
    font-size: 18px;
    font-weight: 900;
    margin: 0;
    color: white;
}

.modal-body {
    padding: 20px 24px;
    max-height: 60vh;
    overflow-y: auto;
    color: #e2e8f0;
}

.modal-footer {
    padding: 16px 24px;
    border-top: 1px solid rgba(148, 163, 184, 0.2);
    background: rgba(15, 23, 42, 0.95);
    border-radius: 0 0 16px 16px;
    text-align: right;
}

/* Light-mode overrides (when body does NOT have .dark-mode) */
body:not(.dark-mode) .table-filters {
    background: #ffffff !important;
    border: 1px solid rgba(2,6,23,0.06) !important;
    box-shadow: 0 2px 6px rgba(2,6,23,0.04) !important;
}

body:not(.dark-mode) .form-field input,
body:not(.dark-mode) .form-field select {
    background: #ffffff;
    color: #0f172a;
    border: 1px solid #cbd5e1;
    box-shadow: none;
}

body:not(.dark-mode) .form-field input::placeholder { color: #94a3b8; }

body:not(.dark-mode) .table-wrapper,
body:not(.dark-mode) table {
    background: #ffffff;
    border: 1px solid #e6eef6;
    box-shadow: 0 6px 16px rgba(2,6,23,0.04);
}

body:not(.dark-mode) table thead tr:first-child {
    background: linear-gradient(135deg, #e6ffef 0%, #dff3ea 100%);
}

body:not(.dark-mode) table th { color: #0f172a; }
body:not(.dark-mode) table td { color: #0f172a; }

body:not(.dark-mode) .pagination-container {
    background: #ffffff;
    border: 1px solid #e6eef6;
    box-shadow: 0 2px 6px rgba(2,6,23,0.04);
}

body:not(.dark-mode) .largeModal { background: #ffffff !important; color: #0f172a !important; }

/* Light-mode modal accents and text */
body:not(.dark-mode) .modal-header {
    background: linear-gradient(135deg, #e6ffef 0%, #dff3ea 100%);
    color: #0f172a;
    border-bottom: 1px solid rgba(2,6,23,0.06);
}

body:not(.dark-mode) .modal-title { color: #0f172a; }

body:not(.dark-mode) .modal-body {
    background: #ffffff;
    color: #0f172a;
}

body:not(.dark-mode) .modal-footer {
    background: #ffffff;
    border-top: 1px solid rgba(2,6,23,0.06);
}

body:not(.dark-mode) .close-btn {
    background: #f1f5f9;
    color: #0f172a;
    box-shadow: none;
    border: 1px solid #e6eef6;
}

/* Ensure record-detail text is dark in light mode */
body:not(.dark-mode) .record-detail {
    border-bottom: 1px solid #e6eef6;
}

body:not(.dark-mode) .record-detail .detail-label,
body:not(.dark-mode) .record-detail .detail-value {
    color: #0f172a;
}


.record-detail {
    display: grid;
    grid-template-columns: 180px 1fr;
    gap: 16px;
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
    align-items: start;
}

.record-detail:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 700;
    color: #cbd5e1;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-value {
    color: #e2e8f0;
    font-size: 14px;
    font-weight: 500;
    word-break: break-word;
}

.close-btn {
    background: linear-gradient(135deg, #334155 0%, #475569 100%);
    color: #f8fafc;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 4px rgba(15, 23, 42, 0.25);
}

.close-btn:hover {
    background: linear-gradient(135deg, #475569 0%, #64748b 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(15, 23, 42, 0.3);
}

/* Responsive design */
@media (max-width: 768px) {
    .filter-grid {
        grid-template-columns: 1fr;
    }
    
    .record-detail {
        grid-template-columns: 1fr;
        gap: 8px;
    }
    
    table {
        font-size: 12px;
    }
    
    table th,
    table td {
        padding: 10px 8px;
    }
}

body.public-records-page .records-main {
    display: flex;
    min-height: 0;
    flex: 1;
    flex-direction: column;
    padding: 20px;
    background: #f1f5f2;
    overflow: hidden;
}

body.public-records-page,
body.public-records-page #app,
body.public-records-page .public-workspace-shell {
    height: 100vh;
    overflow: hidden;
}

body.public-records-page .public-workspace-shell {
    min-height: 0;
}

body.public-records-page .public-workspace-content {
    display: flex;
    height: 100vh;
    min-height: 0;
    flex-direction: column;
    overflow: hidden;
}

body.public-records-page .table-filters {
    flex: 0 0 auto;
    margin-bottom: 16px !important;
    padding: 20px !important;
    border: 1px solid #b8c8c7 !important;
    border-radius: 15px !important;
    background: #fff !important;
    box-shadow: 0 5px 16px rgb(15 23 42 / 5%) !important;
}

body.public-records-page .nl-filter-heading {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 14px !important;
    padding-bottom: 13px;
    border-bottom: 1px solid #e2e8f0;
}

body.public-records-page .nl-filter-heading h3 {
    margin: 0;
    color: #0f172a;
    font-size: 16px;
    font-weight: 900;
}

body.public-records-page .nl-filter-heading p {
    margin: 3px 0 0;
    color: #64748b;
    font-size: 12px;
}

body.public-records-page .filter-grid {
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 190px), 1fr));
    gap: 14px;
}

body.public-records-page .form-field label {
    color: #475569;
    font-size: 11px;
    font-weight: 800;
}

body.public-records-page .form-field input,
body.public-records-page .form-field select {
    width: 100%;
    min-width: 0;
    min-height: 42px;
    padding: 9px 12px;
    border: 1px solid #b8c8d4;
    border-radius: 9px;
    background: #fff;
    color: #0f172a;
    font-size: 13px;
    box-shadow: none;
}

body.public-records-page .form-field input:focus,
body.public-records-page .form-field select:focus {
    border-color: #15803d;
    box-shadow: 0 0 0 3px rgb(21 128 61 / 13%);
}

body.public-records-page .filter-actions {
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 16px;
    padding-top: 14px;
    border-color: #e2e8f0;
}

body.public-records-page .filter-actions .btn {
    min-height: 40px;
    padding: 9px 16px;
    border: 1px solid transparent;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 800;
    box-shadow: none;
}

body.public-records-page .filter-actions .btn-primary {
    border-color: #14532d;
    background: #166534;
}

body.public-records-page .filter-actions .btn-muted {
    border-color: #fca5a5;
    background: #fff1f2;
    color: #991b1b;
}

body.public-records-page .table-wrapper {
    min-height: 0;
    flex: 1 1 auto;
    max-height: none;
    overflow: auto;
    border: 1px solid #b8c8d4;
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 5px 16px rgb(15 23 42 / 5%);
}

body.public-records-page .table-wrapper table {
    width: max-content;
    min-width: 100%;
    max-width: none;
    margin: 0;
    border: 0;
    border-radius: 0;
    background: #fff;
    box-shadow: none;
}

body.public-records-page .table-wrapper table thead th {
    position: sticky;
    top: 0;
    z-index: 2;
    height: 44px;
    padding: 11px 13px;
    border-right: 1px solid rgb(255 255 255 / 16%);
    border-bottom: 2px solid #14532d;
    background: #166534;
    color: #fff;
    font-size: 11px;
    font-weight: 850;
    letter-spacing: .045em;
    line-height: 1.25;
    text-align: left;
    vertical-align: middle;
}

body.public-records-page .table-wrapper table thead th:last-child {
    border-right: 0;
}

body.public-records-page .table-wrapper table tbody td {
    height: 44px;
    padding: 9px 13px;
    border-right: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
    color: #334155;
    font-size: 12px;
    line-height: 1.4;
    vertical-align: middle;
}

body.public-records-page .table-wrapper table tbody td:last-child {
    border-right: 0;
}

body.public-records-page .table-wrapper table tbody tr:last-child td {
    border-bottom: 0;
}

body.public-records-page .table-wrapper table tbody tr:nth-child(odd) {
    background: #fff !important;
}

body.public-records-page .table-wrapper table tbody tr:nth-child(even) {
    background: #f8fafc !important;
}

body.public-records-page .table-wrapper table tbody tr:hover {
    background: #ecfdf5;
}

body.public-records-page .pagination-container {
    justify-content: space-between;
    gap: 10px;
    padding: 14px 4px 2px;
    border: 0;
    background: transparent;
    box-shadow: none;
}

body.public-records-page .pagination-info,
body.public-records-page .pagination-link {
    border-radius: 9px;
    font-size: 12px;
    font-weight: 800;
}

body.dark-mode.public-records-page .records-main {
    background: #0b1220;
}

body.dark-mode.public-records-page .table-filters,
body.dark-mode.public-records-page .table-wrapper {
    border-color: rgba(148, 163, 184, .36) !important;
    background: #0f172a !important;
}

body.dark-mode.public-records-page .nl-filter-heading h3,
body.dark-mode.public-records-page .table-wrapper table tbody td {
    color: #e2e8f0;
}

body.dark-mode.public-records-page .nl-filter-heading p,
body.dark-mode.public-records-page .form-field label {
    color: #cbd5e1;
}

body.dark-mode.public-records-page .form-field input,
body.dark-mode.public-records-page .form-field select {
    border-color: rgba(148, 163, 184, .4);
    background: #111827;
    color: #f8fafc;
}

body.dark-mode.public-records-page .filter-actions .btn-muted {
    border-color: #7f1d1d;
    background: #450a0a;
    color: #fecaca;
}

body.dark-mode.public-records-page .table-wrapper table tbody td {
    border-color: rgba(148, 163, 184, .22);
}

body.dark-mode.public-records-page .table-wrapper table tbody tr:nth-child(odd) {
    background: #0f172a !important;
}

body.dark-mode.public-records-page .table-wrapper table tbody tr:nth-child(even) {
    background: #111827 !important;
}

body.dark-mode.public-records-page .table-wrapper table tbody tr:hover {
    background: #123524;
}

@media (max-width: 760px) {
    body.public-records-page .public-workspace-shell {
        grid-template-rows: auto minmax(0, 1fr);
    }

    body.public-records-page .public-workspace-sidebar {
        height: auto;
    }

    body.public-records-page .public-workspace-content {
        height: auto;
    }

    body.public-records-page .records-main {
        padding: 12px;
    }

    body.public-records-page .table-filters {
        padding: 14px !important;
    }

    body.public-records-page .pagination-container {
        justify-content: center;
        flex-wrap: wrap;
    }
}
</style>
@endsection

@section('content')
<div class="public-workspace-shell">
    @include('partials.public-workspace-nav')
    <div class="public-workspace-content">
<!-- Navigation Bar -->
{{-- <nav class="records-nav no-print">
    <div class="nav-content">
        <div class="nav-left">
            <div class="nav-brand">
                <div class="nav-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="nav-text">
                    <h1>All NL Records</h1>
                    <p>View and search all Notice of Loss records</p>
                </div>
            </div>
        </div>
        <div class="nav-right">
            <div class="nav-actions">
                <a href="{{ route('welcome') }}" class="back-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    <span>Back to Home</span>
                </a>
            </div>
        </div>
    </div>
    </nav> --}}

<!-- Main Content -->
<main class="records-main">
    <!-- Filters Section -->
    <div class="no-print table-filters">
        <div class="nl-filter-heading">
            <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #006c35 0%, #008a43 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <svg width="18" height="18" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
            </div>
            <div>
                <h3>Find and filter records</h3>
                <p>Narrow the list to find Notice of Loss records.</p>
            </div>
        </div>

        <form id="filterForm" method="GET" action="{{ route('all-records') }}">
            <div class="filter-grid">
                <div class="form-field">
                    <label>Search Farmer</label>
                    <input type="text" name="farmerName" value="{{ request('farmerName') }}" placeholder="Enter farmer name">
                </div>
                
                <div class="form-field">
                    <label>Search Encoder</label>
                    <input type="text" name="encoderName" value="{{ request('encoderName') }}" placeholder="Enter encoder name">
                </div>
                
                <div class="form-field">
                    <label>Source</label>
                    <select name="source">
                        <option value="">All Sources</option>
                        @foreach($allSources as $source)
                            <option value="{{ $source }}" {{ request('source') == $source ? 'selected' : '' }}>{{ $source }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-field">
                    <label>Municipality</label>
                    <input type="text" name="municipality" value="{{ request('municipality') }}" placeholder="Enter municipality">
                </div>
                
                <div class="form-field">
                    <label>Date Received</label>
                    <input type="date" name="date_received" value="{{ request('date_received') }}">
                </div>
                
                <div class="form-field">
                    <label>Date Encoded</label>
                    <input type="date" name="created_at" value="{{ request('created_at') }}">
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary" form="filterForm">Apply Filters</button>
                <a href="{{ route('all-records') }}" class="btn btn-muted">Clear All</a>
            </div>
        </form>
    </div>

    <!-- Records Table -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>Farmer</th>
                    <th>TRANSMITTAL #</th>
                    <th>Encoder</th>
                    <th>Source</th>
                    <th>Municipality</th>
                    <th>Date Received</th>
                    <th>Date of Occurrence</th>
                    <th>Cause of Loss</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                    @php
                        $canViewNoticeImage = (bool) session('admin_logged_in', false)
                            || (
                                $record->source === 'Email'
                                && (bool) session('email_logged_in', false)
                                && (string) session('email_user_id') === (string) $record->encoder_id
                            )
                            || (
                                $record->source === 'Facebook'
                                && (bool) session('facebook_logged_in', false)
                                && (string) session('facebook_user_id') === (string) $record->encoder_id
                            )
                            || (
                                $record->source === 'OD'
                                && filled(session('officer_name'))
                                && (string) session('officer_id') === (string) $record->encoder_id
                            );
                    @endphp
                    <tr>
                        <td>
                            <button
                                type="button"
                                class="view-btn"
                                data-record='@json([
                                    "id" => $record->id,
                                    "farmerName" => $record->farmerName,
                                    "encoderName" => $record->encoderName,
                                    "source" => $record->source,
                                    "municipality" => $record->municipality,
                                    "barangay" => $record->barangay,
                                    "date_received" => $record->date_received ? \Illuminate\Support\Carbon::parse($record->date_received)->format("M d, Y") : null,
                                    "created_at" => $record->created_at?->format("M d, Y h:i A"),
                                    "admin_transmittal_number" => $record->admin_transmittal_number,
                                    "remarks" => $record->remarks,
                                    "causeOfDamage" => $record->causeOfDamage,
                                    "line" => $record->line,
                                    "modeOfPayment" => $record->modeOfPayment,
                                    "accounts" => $record->accounts,
                                    "facebook_page_url" => $record->facebook_page_url,
                                ])'
                                onclick="viewRecord(this)"
                            >View</button>
                            @if ($record->attachments->where('type', 'image')->isNotEmpty() && $canViewNoticeImage)
                                <button
                                    type="button"
                                    class="notice-image-view-btn"
                                    data-image-urls="{{ $record->attachments->where('type', 'image')->map(fn ($attachment) => route('records.attachments.show', [$record, $attachment]))->values()->toJson() }}"
                                    data-farmer-name="{{ $record->farmerName }}"
                                >View / Print photos</button>
                            @endif
                        </td>
                        <td><span class="farmer-name-copy cursor-pointer" style="user-select: none; transition: color 0.2s;" data-farmer-name="{{ e($record->farmerName) }}" title="Click to copy farmer name">{{ $record->farmerName }}</span></td>
                        <td>{{ $record->admin_transmittal_number ?? 'N/A' }}</td>
                        <td>{{ $record->encoderName }}</td>
                        <td>{{ $record->source }}</td>
                        <td>{{ $record->municipality }}</td>
                        <td>{{ $record->date_received ? \Carbon\Carbon::parse($record->date_received)->format('M d, Y') : 'N/A' }}</td>
                        <td>{{ $record->date_occurrence ? (function($date) { try { return \Carbon\Carbon::parse($date)->format('M d, Y'); } catch (\Exception $e) { return $date; } })($record->date_occurrence) : 'N/A' }}</td>
                        <td>{{ $record->causeOfDamage ?? 'N/A' }}</td>
                        <td>{{ $record->remarks ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 40px; color: #64748b; font-weight: 500;">
                            No records found matching your filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('components.notice-image-print-dialog')

    <!-- Pagination -->
    @if($records->hasPages())
        <div class="pagination-container">
            @if ($records->onFirstPage())
                <span class="pagination-info">Previous</span>
            @else
                <a href="{{ $records->appends(request()->query())->previousPageUrl() }}" class="pagination-link">Previous</a>
            @endif
            
            <span class="pagination-info">
                Page {{ $records->currentPage() }} of {{ $records->lastPage() }}
            </span>
            
            @if ($records->hasMorePages())
                <a href="{{ $records->appends(request()->query())->nextPageUrl() }}" class="pagination-link">Next</a>
            @else
                <span class="pagination-info">Next</span>
            @endif
        </div>
    @endif
</main>
    </div>
</div>

<!-- View Record Modal -->
<dialog class="largeModal rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(640px,calc(100vw-2rem))]" id="viewModal">
    <div class="modal-header">
        <h3 class="modal-title">Record Details</h3>
    </div>
    <div class="modal-body" id="modalBody">
        <!-- Record details will be loaded here -->
    </div>
    <div class="modal-footer">
        <button class="close-btn" onclick="closeModal()">Close</button>
    </div>
</dialog>

<script data-public-view-script>
// Ensure filter form works properly
window.initializeAllRecordsPage = function() {
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            // Let the form submit normally
            return true;
        });
    }

    // Handle farmer name copy to clipboard
    if (!window.allRecordsGlobalHandlersBound) {
        document.addEventListener('click', function(e) {
            const farmerNameButton = e.target.closest('.farmer-name-copy');
            if (!farmerNameButton) {
                return;
            }

            e.stopPropagation();
            const farmerName = farmerNameButton.getAttribute('data-farmer-name');
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
        });
        window.allRecordsGlobalHandlersBound = true;
    }

    // Fallback method for copying text (works in HTTP contexts)
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
};
window.initializeAllRecordsPage();

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
    const modal = document.getElementById('viewModal');
    modal.close();
}

// Close modal when clicking outside
document.getElementById('viewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection
