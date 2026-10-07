@extends('layout.layout')

@section('title', 'NL Records Monitoring')

@section('page-styles')
<style>
body {
        min-height: 100vh;
        margin: 0;
        padding: 0;
        background-color: #0f172a;
        background-image: linear-gradient(rgba(0, 0, 0, 0.28), rgba(0, 0, 0, 0.28)), url('/images/background.png');
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        filter: blur(0);
    }

    .landing-shell {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 272px minmax(0, 1fr);
        gap: 12px;
        min-height: 100vh;
        padding: 12px;
        box-sizing: border-box;
    }

    .landing-sidebar {
        display: flex;
        min-width: 0;
        flex-direction: column;
        gap: 12px;
    }

    .landing-brand,
    .landing-module-group,
    .landing-shortcut {
        border: 1px solid rgba(203, 213, 225, .9);
        border-radius: 14px;
        background: #f8fafc;
        box-shadow: 0 12px 32px rgba(2, 20, 33, .17);
    }

    .landing-brand {
        padding: 17px;
        color: #fff;
        background: linear-gradient(145deg, #064e3b, #082f49);
    }

    .landing-brand img {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
    }

    .landing-brand-label {
        margin: 0 0 4px;
        color: #bbf7d0;
        font-size: 10px;
        font-weight: 850;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .landing-brand h1 {
        margin: 0;
        color: #fff;
        font-size: 21px;
        font-weight: 900;
        line-height: 1.13;
    }

    .landing-brand p {
        margin: 6px 0 0;
        color: #d1fae5;
        font-size: 11px;
        font-weight: 650;
    }

    .landing-module-group {
        padding: 12px;
    }

    .landing-module-title {
        margin: 1px 4px 9px;
        color: #64748b;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .landing-module-group .channelLogin,
    .landing-module-group .landing-module-link,
    .landing-module-group .adminLoginButton {
        min-height: 52px;
        margin: 0 0 7px;
        padding: 8px 10px;
        border-color: #d5dee7;
        border-radius: 9px;
        background: #fff;
        box-shadow: none;
    }

    .landing-module-group > :last-child {
        margin-bottom: 0 !important;
    }

    .landing-module-group .landing-module-link {
        display: flex;
        width: 100%;
        align-items: center;
        gap: 11px;
        color: #0f172a;
        text-decoration: none;
        transition: border-color .16s ease, background .16s ease, transform .16s ease;
    }

    .landing-module-group .channelLogin:hover,
    .landing-module-group .landing-module-link:hover,
    .landing-module-group .adminLoginButton:hover {
        transform: translateY(-1px);
        border-color: #6aa886;
        background: #f0fdf4;
    }

    .landing-module-group .font-bold {
        color: #0f172a;
        font-size: 12px;
    }

    .landing-module-group .text-xs {
        color: #64748b;
        font-size: 10px;
    }

    .landing-main {
        min-width: 0;
        padding: 4px 0 0;
    }

    .landing-records-panel {
        display: flex;
        min-width: 0;
        min-height: calc(100vh - 32px);
        flex-direction: column;
        overflow: hidden;
        border: 1px solid rgba(203, 213, 225, .95);
        border-radius: 14px;
        background: #f8fafc;
        box-shadow: 0 16px 40px rgba(2, 20, 33, .2);
    }

    .landing-panel[hidden] { display: none !important; }

    .landing-records-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 17px 19px 13px;
    }

    .landing-eyebrow {
        color: #15803d;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .landing-records-header h1 {
        margin: 3px 0 2px;
        color: #0f172a;
        font-size: 21px;
        font-weight: 900;
        letter-spacing: -.02em;
    }

    .landing-records-header p {
        margin: 0;
        color: #64748b;
        font-size: 11px;
    }

    .landing-records-actions,
    .landing-filter-actions,
    .landing-records-footer nav {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .landing-open-full,
    .landing-expand,
    .landing-filter-actions button,
    .landing-filter-actions a,
    .landing-records-footer a,
    .landing-page-disabled,
    .landing-page-current {
        display: inline-flex;
        min-height: 33px;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        padding: 0 11px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        background: #fff;
        color: #334155;
        font-size: 10px;
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
    }

    .landing-open-full,
    .landing-filter-actions button {
        border-color: #166534;
        background: #166534;
        color: #fff;
    }

    .landing-record-filters {
        display: grid;
        grid-template-columns: repeat(6, minmax(105px, 1fr)) auto;
        align-items: end;
        gap: 8px;
        padding: 0 19px 13px;
    }

    .landing-record-filters label {
        display: grid;
        gap: 4px;
        color: #475569;
        font-size: 9px;
        font-weight: 850;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .landing-record-filters input,
    .landing-record-filters select {
        width: 100%;
        height: 33px;
        box-sizing: border-box;
        padding: 0 8px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background: #fff;
        color: #0f172a;
        font-size: 11px;
        text-transform: none;
    }

    .landing-filter-actions {
        align-self: end;
    }

    .landing-records-summary,
    .landing-records-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 8px 18px;
        border-top: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 10px;
    }

    .landing-records-summary strong {
        color: #0f172a;
        font-size: 12px;
    }

    .landing-table-scroll {
        flex: 1;
        min-height: 0;
        overflow: auto;
        border-top: 1px solid #dbe4ec;
    }

    .landing-records-table {
        width: 100%;
        min-width: 940px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        background: #fff;
        table-layout: auto;
    }

    .landing-records-table th {
        position: sticky;
        top: 0;
        z-index: 1;
        padding: 10px 9px;
        border-right: 1px solid rgba(255, 255, 255, .16);
        border-bottom: 1px solid #14532d;
        background: #65a83f;
        color: #fff;
        font-size: 9px;
        font-weight: 900;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .landing-records-table td {
        max-width: 210px;
        padding: 8px 9px;
        border-right: 1px solid #d7e1dd;
        border-bottom: 1px solid #d7e1dd;
        color: #1e293b;
        font-size: 10px;
        line-height: 1.35;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .landing-records-table tbody tr:nth-child(odd) { background: #f0f8f0; }
    .landing-records-table tbody tr:nth-child(even) { background: #d9edd7; }
    .landing-records-table tbody tr:hover { background: #c2e4c3; }

    .landing-source {
        display: inline-block;
        padding: 3px 6px;
        border-radius: 999px;
        background: #e2e8f0;
        color: #334155;
        font-size: 9px;
        font-weight: 800;
    }

    .landing-row-link {
        color: #166534;
        font-size: 10px;
        font-weight: 900;
        text-decoration: underline;
    }

    .landing-records-table .landing-empty {
        height: 180px;
        color: #64748b;
        text-align: center;
    }

    .landing-records-footer {
        border-top: 1px solid #cbd5e1;
        background: #f8fafc;
    }

    .landing-page-disabled {
        color: #94a3b8;
        cursor: not-allowed;
    }

    .landing-dashboard-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        padding: 18px;
    }

    .landing-dashboard-summary article,
    .landing-dashboard-card {
        padding: 17px;
        border: 1px solid #dbe4ec;
        border-radius: 10px;
        background: #fff;
    }

    .landing-dashboard-summary article {
        display: grid;
        gap: 6px;
        border-top: 3px solid #16834b;
    }

    .landing-dashboard-summary article:nth-child(2) { border-top-color: #d69b2d; }
    .landing-dashboard-summary article:nth-child(3) { border-top-color: #2f7da0; }
    .landing-dashboard-summary span,
    .landing-dashboard-summary small { color: #64748b; font-size: 10px; font-weight: 800; }
    .landing-dashboard-summary strong { color: #0f172a; font-size: 28px; font-weight: 900; }
    .landing-dashboard-summary small { font-weight: 600; }

    .landing-dashboard-charts {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        padding: 0 18px 18px;
    }

    .landing-dashboard-card h2 {
        margin: 0 0 16px;
        color: #0f172a;
        font-size: 14px;
        font-weight: 900;
    }

    .landing-dashboard-bar {
        display: grid;
        grid-template-columns: minmax(80px, 1fr) 2fr 48px;
        align-items: center;
        gap: 10px;
        margin: 13px 0;
        color: #334155;
        font-size: 11px;
    }

    .landing-dashboard-bar > span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .landing-dashboard-bar > div {
        height: 9px;
        overflow: hidden;
        border-radius: 99px;
        background: #e2e8f0;
    }

    .landing-dashboard-bar i {
        display: block;
        height: 100%;
        border-radius: inherit;
    }

    .landing-dashboard-bar strong { color: #64748b; text-align: right; }
    .landing-dashboard-empty { color: #64748b; font-size: 12px; }
    .landing-dashboard-footer { display:flex; justify-content:space-between; gap:12px; padding:13px 18px; border-top:1px solid #e2e8f0; color:#64748b; font-size:11px; }
    .landing-dashboard-footer a { color:#166534; font-weight:850; text-decoration:none; }

    .landing-panel.is-expanded {
        position: fixed;
        z-index: 100;
        inset: 12px;
        min-height: 0;
        box-shadow: 0 20px 70px rgba(2, 20, 33, .42);
    }

    body.landing-records-expanded { overflow: hidden; }
    @media (max-width: 1100px) {
        .landing-shell { grid-template-columns: 230px minmax(0, 1fr); }
        .landing-record-filters { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .landing-filter-actions { grid-column: 1 / -1; justify-content: flex-end; }
    }

    @media (max-width: 760px) {
        .landing-shell { grid-template-columns: 1fr; padding: 8px; }
        .landing-sidebar { display: grid; grid-template-columns: 1fr 1fr; align-items: start; }
        .landing-brand { grid-column: 1 / -1; }
        .landing-module-group { padding: 9px; }
        .landing-module-group .channelLogin,
        .landing-module-group .landing-module-link,
        .landing-module-group .adminLoginButton { min-height: 44px; }
        .landing-main { min-height: 72vh; }
        .landing-records-panel { min-height: 72vh; }
        .landing-records-header { align-items: flex-start; flex-direction: column; }
        .landing-record-filters { grid-template-columns: repeat(2, minmax(0, 1fr)); padding: 0 12px 12px; }
        .landing-records-header { padding: 14px 12px 10px; }
        .landing-records-panel.is-expanded { inset: 6px; }
        .landing-dashboard-summary { grid-template-columns:1fr; padding:12px; }
        .landing-dashboard-charts { grid-template-columns:1fr; padding:0 12px 12px; }
        .landing-dashboard-footer { align-items:flex-start; flex-direction:column; }
    }

    @media (max-width: 430px) {
        .landing-sidebar { grid-template-columns: 1fr; }
        .landing-brand { grid-column: auto; }
        .landing-records-actions { width: 100%; }
        .landing-records-actions > * { flex: 1; }
    }

    body {
        background-color: #e8eef2;
        background-image: linear-gradient(rgba(8, 47, 73, .18), rgba(8, 47, 73, .18)), url('/images/background.png');
    }

    .landing-page {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
        background: rgb(226 232 240 / 42%);
    }

    .landing-header {
        display: flex;
        min-height: 78px;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-sizing: border-box;
        padding: 12px clamp(16px, 3vw, 36px);
        border-bottom: 1px solid rgb(255 255 255 / 18%);
        background: linear-gradient(110deg, #064e3b, #082f49);
        color: #fff;
        box-shadow: 0 8px 22px rgb(2 20 33 / 20%);
    }

    .landing-header-brand {
        display: flex;
        min-width: 0;
        align-items: center;
        gap: 13px;
    }

    .landing-header-brand img {
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        border: 2px solid rgb(255 255 255 / 70%);
        border-radius: 50%;
        object-fit: cover;
    }

    .landing-header-brand p {
        margin: 0 0 2px;
        color: #bbf7d0;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .landing-header-brand h1 {
        margin: 0;
        color: #fff;
        font-size: clamp(19px, 2.4vw, 27px);
        font-weight: 900;
        line-height: 1.1;
    }

    .landing-header-caption {
        margin: 0;
        color: #d1fae5;
        font-size: 12px;
        font-weight: 700;
        text-align: right;
    }

    .landing-workspace {
        display: grid;
        width: 100%;
        min-height: 0;
        flex: 1;
        grid-template-columns: minmax(220px, 270px) minmax(0, 1fr);
        gap: 14px;
        box-sizing: border-box;
        padding: 14px;
    }

    .landing-sidebar {
        display: flex;
        min-width: 0;
        flex-direction: column;
        gap: 12px;
    }

    .landing-module-group,
    .landing-admin-group {
        padding: 13px;
        border: 1px solid rgb(203 213 225 / 95%);
        border-radius: 13px;
        background: #f8fafc;
        box-shadow: 0 12px 28px rgb(2 20 33 / 16%);
    }

    .landing-admin-group {
        margin-top: 7px;
        border-top: 3px solid #d69b2d;
    }

    .landing-module-title {
        margin: 1px 3px 10px;
        color: #64748b;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .landing-module-group .landing-module-link,
    .landing-admin-group .landing-module-link {
        display: flex;
        width: 100%;
        min-height: 52px;
        align-items: center;
        gap: 11px;
        box-sizing: border-box;
        margin: 0 0 7px;
        padding: 8px 10px;
        border: 1px solid #d5dee7;
        border-radius: 9px;
        background: #fff;
        color: #0f172a;
        font: inherit;
        font-size: 12px;
        font-weight: 800;
        text-align: left;
        text-decoration: none;
        box-shadow: none;
        cursor: pointer;
        transition: border-color .16s ease, background .16s ease, transform .16s ease;
    }

    .landing-module-group .landing-module-link:hover,
    .landing-admin-group .landing-module-link:hover {
        transform: translateY(-1px);
        border-color: #6aa886;
        background: #f0fdf4;
    }

    .landing-module-link > img {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        padding: 6px;
        box-sizing: border-box;
        border-radius: 8px;
        background: #dcfce7;
        object-fit: contain;
    }

    .landing-admin-group .landing-module-link > img {
        background: #f1f5f9;
    }

    .landing-module-arrow {
        margin-left: auto;
        color: #94a3b8;
        font-size: 22px;
        font-weight: 500;
        line-height: 1;
    }

    .landing-records-panel {
        width: 100%;
        min-height: calc(100vh - 106px);
        height: calc(100vh - 106px);
    }

    .landing-table-scroll {
        width: 100%;
        min-width: 0;
    }

    .landing-record-filters {
        grid-template-columns: minmax(130px, 1.3fr) repeat(3, minmax(110px, 1fr)) auto;
    }

    .landing-records-table {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        table-layout: fixed;
    }

    .landing-dashboard-summary {
        gap: 9px;
        padding: 10px 14px;
    }

    .landing-dashboard-summary > p {
        grid-column: 1 / -1;
        margin: 0;
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
        text-align: center;
    }

    .landing-dashboard-summary article {
        min-width: 0;
        gap: 3px;
        padding: 10px 12px;
    }

    .landing-dashboard-summary strong {
        font-size: 20px;
    }

    .landing-dashboard-summary small {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .landing-records-footer nav {
        flex-wrap: wrap;
    }

    @media (max-width: 1100px) {
        .landing-workspace {
            grid-template-columns: 220px minmax(0, 1fr);
        }

        .landing-record-filters {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .landing-header-caption {
            display: none;
        }

        .landing-workspace {
            grid-template-columns: 1fr;
            padding: 9px;
        }

        .landing-sidebar {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: start;
        }

        .landing-admin-group {
            margin-top: 0;
        }

        .landing-records-panel {
            height: min(78vh, 800px);
            min-height: 540px;
        }

        .landing-records-table {
            min-width: 760px;
            table-layout: auto;
        }

        .landing-records-header {
            align-items: flex-start;
            flex-direction: column;
            padding: 13px 14px 10px;
        }

        .landing-records-actions {
            width: 100%;
        }

        .landing-open-full {
            width: 100%;
        }

        .landing-record-filters {
            padding: 0 14px 12px;
        }

        .landing-dashboard-summary {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 520px) {
        .landing-header {
            min-height: 70px;
            padding: 10px 13px;
        }

        .landing-header-brand img {
            width: 42px;
            height: 42px;
            flex-basis: 42px;
        }

        .landing-sidebar {
            grid-template-columns: 1fr;
        }

        .landing-records-panel {
            height: 74vh;
            min-height: 520px;
        }

        .landing-records-summary,
        .landing-records-footer {
            align-items: flex-start;
            flex-direction: column;
        }

        .landing-records-footer nav {
            width: 100%;
            justify-content: space-between;
        }

        .landing-dashboard-summary {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

    @include('partials.landing-workspace')
    @if(false)
    <div class="min-h-screen relative overflow-hidden">
        <div class="absolute inset-0 z-0 bg-cover bg-center bg-no-repeat" style="background-image: linear-gradient(rgba(0, 0, 0, 0.28), rgba(0, 0, 0, 0.28)), url('{{ asset('images/background.png') }}');"></div>
        <div class="relative z-10 min-h-screen flex items-center justify-center p-4 sm:p-6">
            <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-5 gap-5">


            <div class="lg:col-span-2 bg-pcic-950 text-white rounded-2xl p-7 flex flex-col gap-5 shadow-2xl relative overflow-hidden">
                <div class="absolute -top-20 -left-20 w-72 h-72 bg-pcic-800/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-16 -right-16 w-56 h-56 bg-harvest-500/20 rounded-full blur-3xl"></div>

                <div class="relative flex items-center gap-4">
                    <img src="{{ asset('images/PCIC_RO3A_LOGO.jpg') }}" alt="PCIC" width="64" height="64" class="rounded-full">
                    <div>
                        <div class="text-[11px] font-bold tracking-widest uppercase text-pcic-300">PCIC</div>
                        <div class="text-2xl font-black text-white mt-1 leading-tight">NL Records Monitoring</div>
                        <div class="text-sm text-pcic-300 font-semibold mt-0.5">Regional Office III-A</div>
                    </div>
                </div>

                <div class="relative bg-white/10 rounded-xl p-4 border border-white/10 backdrop-blur-sm">
                    <p class="text-sm font-medium text-pcic-100 leading-relaxed">Select a module to start encoding, reviewing, and managing Notice of Loss (NL) records.</p>
                </div>

                <div class="relative mt-auto flex items-center justify-between text-xs text-pcic-400/80">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-harvest-400 inline-block"></span>
                        Records Management System
                    </span>
                    <span class="font-bold">© {{ date('Y') }} Chvz_Td</span>
                </div>
            </div>


            <div class="lg:col-span-3 flex flex-col gap-4">

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100/80 p-5">
                    <div class="text-[11px] font-black tracking-widest uppercase text-gray-400 mb-3">Modules</div>

                    <button type="button" class="channelLogin flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-white hover:border-pcic-300 hover:shadow-md transition-all duration-150 group mb-2.5 w-full text-left cursor-pointer" data-channel="OD">
                        <div class="w-10 h-10 rounded-lg bg-pcic-100 text-pcic-700 flex items-center justify-center border border-pcic-200 shrink-0"><img src="{{ asset('images/officer-of-the-day.svg') }}" alt="" width="22" height="22"></div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-gray-900 text-sm">Officer of the Day</div>
                            <div class="text-xs text-gray-500 font-medium">Encode and manage records under OD workflow.</div>
                        </div>
                        <div class="text-gray-300 text-lg group-hover:text-pcic-600 group-hover:translate-x-0.5 transition-all">›</div>
                    </button>

                    <button type="button" class="channelLogin flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-white hover:border-pcic-300 hover:shadow-md transition-all duration-150 group mb-2.5 w-full text-left cursor-pointer" data-channel="Email">
                        <div class="w-10 h-10 rounded-lg bg-harvest-50 text-harvest-600 flex items-center justify-center border border-harvest-100 shrink-0"><img src="{{ asset('images/email.svg') }}" alt="" width="22" height="22"></div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-gray-900 text-sm">Email</div>
                            <div class="text-xs text-gray-500 font-medium">Encode from email submission.</div>
                        </div>
                        <div class="text-gray-300 text-lg group-hover:text-pcic-600 group-hover:translate-x-0.5 transition-all">›</div>
                    </button>

                    <button type="button" class="channelLogin flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-white hover:border-pcic-300 hover:shadow-md transition-all duration-150 group mb-2.5 w-full text-left cursor-pointer" data-channel="Facebook">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-50 shrink-0"><img src="{{ asset('images/facebook.svg') }}" alt="" width="22" height="22"></div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-gray-900 text-sm">Facebook</div>
                            <div class="text-xs text-gray-500 font-medium">Encode from Facebook submissions.</div>
                        </div>
                        <div class="text-gray-300 text-lg group-hover:text-pcic-600 group-hover:translate-x-0.5 transition-all">›</div>
                    </button>

                    <a href="{{ route('all-records') }}" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-white hover:border-pcic-300 hover:shadow-md transition-all duration-150 group mb-2.5 w-full">
                        <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-50 shrink-0">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-gray-900 text-sm">All Records</div>
                            <div class="text-xs text-gray-500 font-medium">View all NL records with advanced filtering (public access).</div>
                        </div>
                        <div class="text-gray-300 text-lg group-hover:text-pcic-600 group-hover:translate-x-0.5 transition-all">›</div>
                    </a>

                    <a href="{{ route('public-dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-white hover:border-pcic-300 hover:shadow-md transition-all duration-150 group mb-2.5 w-full">
                        <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-100 shrink-0">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l4-5 3 3 5-7"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-gray-900 text-sm">Public Dashboard</div>
                            <div class="text-xs text-gray-500 font-medium">View Summarya.</div>
                        </div>
                        <div class="text-gray-300 text-lg group-hover:text-pcic-600 group-hover:translate-x-0.5 transition-all">›</div>
                    </a>

                                    </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100/80 p-5">
                    <div class="text-[11px] font-black tracking-widest uppercase text-gray-400 mb-3">Administration</div>
                    <button type="button" class="adminLoginButton w-full flex items-center gap-3 p-3 rounded-xl border border-gray-100 bg-white hover:border-pcic-300 hover:shadow-md transition-all duration-150 group text-left cursor-pointer">
                        <div class="w-10 h-10 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center border border-gray-200 shrink-0"><img src="{{ asset('images/admin.svg') }}" alt="" width="22" height="22"></div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-gray-900 text-sm">Admin Dashboard</div>
                            <div class="text-xs text-gray-500 font-medium">Approvals, monitoring, transmittals, print preview.</div>
                        </div>
                        <div class="text-gray-300 text-lg group-hover:text-pcic-600 group-hover:translate-x-0.5 transition-all">›</div>
                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif

    <dialog class="loginDialog rounded-2xl shadow-2xl bg-white backdrop:bg-black/40">
        <div class="p-6 w-[min(420px,calc(100vw-2rem))]">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-lg bg-pcic-700 text-white flex items-center justify-center text-xs font-black" id="loginIcon">LG</div>
                <h3 class="text-lg font-black text-gray-900" id="loginTitle">Login</h3>
            </div>
            <form id="loginForm" action="{{ route('auth.login.submit') }}" method="post" class="flex flex-col gap-3">
                @csrf
                <input type="hidden" name="channel" id="loginChannel">
                <div>
                    <label for="loginUsername" class="block text-xs font-bold text-gray-700 mb-1" id="usernameLabel">Username</label>
                    <input type="text" id="loginUsername" name="username" placeholder="Enter your username" aria-label="Username" autocomplete="username"
                        class="h-11 px-4 rounded-xl border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
                </div>
                <div>
                    <label for="loginPassword" class="block text-xs font-bold text-gray-700 mb-1">Password</label>
                    <input type="password" id="loginPassword" name="password" placeholder="Enter your password" aria-label="Password" autocomplete="current-password"
                        class="h-11 px-4 rounded-xl border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
                </div>
                <div class="flex gap-3 mt-2">
                    <button type="button" class="closeModal flex-1 h-10 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Close</button>
                    <button type="submit" class="flex-1 h-10 rounded-xl bg-pcic-700 text-white text-sm font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Login</button>
                </div>
            </form>
        </div>
    </dialog>

    <dialog class="adminLoginDialog rounded-2xl shadow-2xl bg-white backdrop:bg-black/40" style="z-index: 10001;">
        <div class="p-6 w-[min(420px,calc(100vw-2rem))]">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-lg bg-pcic-700 text-white flex items-center justify-center text-xs font-black">AD</div>
                <h3 class="text-lg font-black text-gray-900">Administrator Login</h3>
            </div>
            <form action="{{ route('auth.login.submit') }}" method="post" class="flex flex-col gap-3" id="adminLoginForm">
                @csrf
                <input type="hidden" name="channel" value="admin">
                <input type="text" id="adminUsername" name="username" placeholder="Username" aria-label="Username" autocomplete="username"
                    class="h-11 px-4 rounded-xl border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full" required>
                <input type="password" id="adminPassword" name="password" placeholder="Password" aria-label="Password" autocomplete="current-password"
                    class="h-11 px-4 rounded-xl border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full" required>
                <div class="flex gap-3 mt-2">
                    <button type="button" class="closeAdminModal flex-1 h-10 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Close</button>
                    <button type="submit" class="flex-1 h-10 rounded-xl bg-pcic-700 text-white text-sm font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Login</button>
                </div>
            </form>
        </div>
    </dialog>
@endsection

@push('scripts')
@vite('resources/js/pages/landing.js')
@endpush
