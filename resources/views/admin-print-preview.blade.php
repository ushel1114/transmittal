@extends('layout.layout')

@section('title', 'Print Preview')
@section('body-class', 'print-preview-page')

@section('print-page-rules')
    @page {
        size: 13in 8.5in;
        margin: 0.12in;
    }
@endsection

@section('page-styles')
    <style>
        /* Print Preview: PCIC-themed screen + print styles */
        .print-preview-wrap {
            max-width: 1200px;
            margin: 18px auto 24px auto;
            padding: 0 14px;
        }

        .print-preview-topbar {
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(15, 23, 42, 0.1);
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .admin-topbar.print-preview-topbar.no-print {
            border-radius: 16px;
            padding: 16px 20px;
        }

        .admin-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .print-preview-topbar .heading h1 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
        }

        .print-preview-topbar .heading p {
            margin: 2px 0 0 0;
            font-size: 13px;
            color: rgba(15, 23, 42, 0.6);
        }

        .print-preview-topbar .actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .print-preview-card {
            background: rgba(255,255,255,0.92);
            border: 1px solid rgba(15, 23, 42, 0.12);
            border-radius: 16px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .print-preview-card .meta {
            padding: 12px 14px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            background: linear-gradient(180deg, rgba(25, 118, 210, 0.08), rgba(255, 255, 255, 0));
            font-weight: 700;
            color: rgba(15, 23, 42, 0.86);
            font-size: 12px;
        }

        .print-preview-card .meta strong {
            color: #0f172a;
            font-weight: 900;
        }

        .print-preview-card .table-wrap {
            padding: 0 10px 10px 10px;
        }

        .print-preview-table {
            margin: 12px auto 10px auto;
            width: 100%;
            max-width: none;
            border-collapse: separate;
            border-spacing: 0;
            border: 2px solid rgba(25, 118, 210, 0.25);
            border-radius: 8px;
            overflow: hidden;
        }

        .print-preview-table th {
            padding: 8px 10px;
            background: #1976D2;
            border-bottom: 2px solid #1565C0;
            font-weight: 700;
            color: #fff;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .print-preview-table td {
            padding: 6px 8px;
            border-bottom: 1px solid rgba(15, 23, 42, 0.1);
            vertical-align: top;
            font-size: 14px;
            line-height: 1.3;
        }

        /* Alternating row colors for screen */
        .print-preview-table tbody tr:nth-child(even) {
            background-color: rgba(227, 242, 253, 0.6);
        }

        .print-preview-table tbody tr:nth-child(odd) {
            background-color: rgba(255, 255, 255, 0.9);
        }

        .print-preview-table tbody tr:hover {
            background-color: rgba(25, 118, 210, 0.06);
        }

        .print-preview-table .address-cell {
            white-space: normal;
        }

        .received-by {
            padding: 10px 14px 14px 14px;
            font-size: 12px;
            font-weight: 800;
            color: rgba(15, 23, 42, 0.85);
        }

        .page-section {
            margin-bottom: 14px;
        }

        /* Keep "Assign" visible while scrolling (screen only) */
        .assign-form {
            position: fixed;
            right: 14px;
            bottom: 14px;
            z-index: 9999;
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid rgba(15, 23, 42, 0.14);
            padding: 10px 12px;
            border-radius: 14px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.15);
            display: flex;
            gap: 10px;
            align-items: center;
        }

        @media print {
            /* Hide screen-only elements */
            .assign-form,
            .no-print {
                display: none !important;
            }

            /* Reset body for print */
            body {
                background: #fff !important;
                color: #000 !important;
                font-family: Cambria, "Times New Roman", Times, serif !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Adjust wrapper for print */
            .print-preview-wrap {
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Card styling for print - optimized for 8.5x13 */
            .print-preview-card {
                box-shadow: none !important;
                border: 1px solid #000 !important;
                border-radius: 0 !important;
                background: #fff !important;
                page-break-inside: avoid;
                margin: 0 !important;
                overflow: visible !important;
                height: auto !important;
                max-height: none !important;
            }

            .print-preview-card .meta {
                background: #1976D2 !important;
                border-bottom: 2px solid #1565C0 !important;
                color: #fff !important;
                padding: 2px 6px !important;
                font-weight: 700 !important;
                font-size: 10px !important;
                display: flex !important;
                gap: 6px !important;
                flex-wrap: wrap !important;
                justify-content: space-between !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                margin-bottom: 0 !important;
                line-height: 1.0 !important;
            }

            .print-preview-card .meta strong {
                color: #fff !important;
                font-weight: 900 !important;
            }

            .page-section {
                page-break-after: always;
                margin-bottom: 0 !important;
                padding-bottom: 0 !important;
            }

            .page-section:last-child {
                page-break-after: auto;
            }

            /* Table wrapper */
            .print-preview-card .table-wrap {
                padding: 1px 2px 2px 2px !important;
                margin: 0 !important;
            }

            /* Received by section */
            .received-by {
                padding: 3px 6px 4px 6px !important;
                font-size: 9px !important;
                font-weight: 800 !important;
                color: #000 !important;
                margin: 0 !important;
            }

            /* Page breaks - keep headings and table together */
            .page-section {
                page-break-after: always !important;
                margin-bottom: 0 !important;
                padding: 0 !important;
            }

            .page-section:last-child {
                page-break-after: auto !important;
            }

            /* Keep card content together - headings and table */
            .print-preview-card {
                page-break-inside: avoid !important;
                margin: 0 !important;
                padding: 0 !important;
                display: block !important;
            }

            /* Ensure meta section stays with table */
            .print-preview-card .meta {
                page-break-after: avoid !important;
                page-break-inside: avoid !important;
            }

            /* Ensure table stays with meta */
            .print-preview-card .table-wrap {
                page-break-before: avoid !important;
                page-break-inside: avoid !important;
            }

            .print-preview-table thead {
                display: table-header-group !important;
            }

            .print-preview-table tbody {
                display: table-row-group !important;
            }

            .print-preview-table tr {
                display: table-row !important;
            }

            .print-preview-table {
                display: table !important;
                width: 100% !important;
                border-collapse: collapse !important;
                border: 1px solid #000 !important;
                margin: 0 !important;
                page-break-inside: avoid !important;
                table-layout: auto !important;
            }

            .print-preview-table tr {
                page-break-inside: avoid !important;
            }

            /* Dynamic table layout - respect inline styles for column widths */
            .print-preview-table {
                table-layout: fixed !important;
                width: 100% !important;
                border-collapse: collapse !important;
            }

            /* Don't override inline width styles */
            .print-preview-table th[style],
            .print-preview-table td[style] {
                /* Width controlled by inline styles */
            }

            .print-preview-table th {
                padding: 2px 3px !important;
                border: 1px solid #000 !important;
                background-color: #1976D2 !important;
                font-weight: 700 !important;
                text-align: left !important;
                font-size: 10px !important;
                display: table-cell !important;
                height: 12px !important;
                margin: 0 !important;
                color: #fff !important;
                vertical-align: middle !important;
                text-transform: uppercase !important;
                letter-spacing: 0.1px !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                line-height: 1.0 !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }

            .print-preview-table th:nth-child(1) {
                text-align: center !important;
            }

            .print-preview-table td {
                padding: 1px 3px !important;
                border: 1px solid #000 !important;
                font-size: 10px !important;
                display: table-cell !important;
                height: 10px !important;
                margin: 0 !important;
                color: #000 !important;
                vertical-align: middle !important;
                word-wrap: break-word !important;
                line-height: 1.0 !important;
            }

            .print-preview-table .address-cell {
                white-space: normal !important;
            }

            /* Alternating row colors - match screen */
            .print-preview-table tbody tr:nth-child(even) {
                background-color: rgba(227, 242, 253, 0.6) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .print-preview-table tbody tr:nth-child(odd) {
                background-color: #fff !important;
            }

            /* Ensure headers repeat on each printed page */
            thead {
                display: table-header-group !important;
            }

            /* Hide any remaining elements */
            dialog,
            .odHeader,
            .addRecordButton {
                display: none !important;
            }
        }

        body.print-preview-page #themeToggle {
            display: none !important;
        }

        .print-preview-wrap {
            width: min(1248px, calc(100vw - 40px));
            max-width: none;
            margin: 22px auto 36px;
            padding: 0;
        }

        .print-preview-topbar {
            margin: 0 auto 20px;
            padding: 16px 20px !important;
            border: 1px solid #dbe4ec;
            border-radius: 16px !important;
            background: #fff;
            box-shadow: 0 8px 24px rgb(15 23 42 / 7%);
        }

        .print-preview-topbar .heading h1 {
            color: #0f172a;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .print-preview-topbar .heading p {
            color: #64748b;
            font-size: 13px;
        }

        .print-preview-topbar .actions .btn {
            min-height: 40px;
            padding: 0 16px;
            border-radius: 10px;
            font-weight: 750;
        }

        .page-section {
            box-sizing: border-box;
            width: 100%;
            min-height: min(816px, calc((100vw - 40px) * 0.65385));
            margin: 0 auto 24px;
            padding: 16px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            background: #fff;
            box-shadow: 0 16px 42px rgb(15 23 42 / 13%);
        }

        .print-preview-card {
            display: flex;
            min-height: min(782px, calc((100vw - 40px) * 0.65385 - 34px));
            flex-direction: column;
            border: 0;
            border-radius: 0;
            background: #fff;
            box-shadow: none;
        }

        .print-preview-card .meta {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 8px;
            padding: 12px 14px;
            border: 1px solid #dbe4ec;
            border-left: 4px solid #166534;
            border-radius: 10px;
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
        }

        .print-preview-card .meta > div:nth-child(2) {
            text-align: center;
        }

        .print-preview-card .meta > div:last-child {
            text-align: right;
        }

        .print-preview-card .meta strong {
            color: #166534;
            font-weight: 850;
        }

        .print-preview-card .table-wrap {
            flex: 1;
            padding: 0;
        }

        .print-preview-table {
            width: 100%;
            margin: 0;
            border: 1px solid #cbd5e1;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .print-preview-table th {
            padding: 9px 8px;
            border: 1px solid #14532d;
            background: #166534;
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.04em;
            line-height: 1.2;
        }

        .print-preview-table td {
            padding: 7px 8px;
            border: 1px solid #dbe4ec;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.3;
            overflow-wrap: anywhere;
        }

        .print-preview-table tbody tr:nth-child(even) {
            background: #f1f5f9;
        }

        .received-by {
            display: inline-block;
            width: 49%;
            min-height: 68px;
            box-sizing: border-box;
            margin-top: 12px;
            padding: 10px 12px;
            border: 1px solid #94a3b8;
            color: #334155;
            font-size: 11px;
            vertical-align: top;
        }

        .received-by strong {
            display: block;
            margin-bottom: 6px;
            color: #166534;
            font-weight: 800;
        }

        @media (max-width: 700px) {
            .print-preview-wrap {
                width: calc(100vw - 24px);
                margin-top: 12px;
            }

            .print-preview-topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .page-section {
                min-height: 0;
                padding: 10px;
            }

            .print-preview-card {
                min-height: 0;
            }

            .print-preview-card .meta {
                grid-template-columns: 1fr;
            }

            .print-preview-card .meta > div,
            .print-preview-card .meta > div:nth-child(2),
            .print-preview-card .meta > div:last-child {
                text-align: left;
            }
        }

        @media print {
            html,
            body {
                width: 100% !important;
                min-width: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
            }

            body * {
                visibility: hidden !important;
            }

            .print-preview-wrap,
            .print-preview-wrap * {
                visibility: visible !important;
            }

            .print-preview-wrap {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .page-section {
                width: 100% !important;
                min-height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                border: 0 !important;
                border-radius: 0 !important;
                background: #fff !important;
                box-shadow: none !important;
                break-after: page;
                page-break-after: always;
            }

            .page-section:last-child {
                break-after: auto;
                page-break-after: auto !important;
            }

            .print-preview-card {
                display: block !important;
                min-height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
                border: 0 !important;
                background: #fff !important;
                box-shadow: none !important;
                break-inside: avoid;
                page-break-inside: avoid !important;
            }

            .print-preview-card .meta {
                grid-template-columns: 1fr 1fr 1fr !important;
                gap: 6px !important;
                margin: 0 !important;
                padding: 6px 8px !important;
                border: 1px solid #64748b !important;
                border-left: 3px solid #166534 !important;
                border-radius: 0 !important;
                background: #f1f5f9 !important;
                color: #0f172a !important;
                font-size: 8pt !important;
                line-height: 1.15 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .print-preview-card .meta strong {
                color: #14532d !important;
            }

            .print-preview-card .table-wrap {
                padding: 0 !important;
                margin: 0 !important;
                break-inside: avoid;
                page-break-inside: avoid !important;
            }

            .print-preview-table {
                display: table !important;
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                border: 1px solid #334155 !important;
                border-collapse: collapse !important;
                border-spacing: 0 !important;
                table-layout: fixed !important;
                break-inside: avoid;
                page-break-inside: avoid !important;
            }

            .print-preview-table thead {
                display: table-header-group !important;
            }

            .print-preview-table tbody {
                display: table-row-group !important;
            }

            .print-preview-table tr {
                display: table-row !important;
                break-inside: avoid !important;
                page-break-inside: avoid !important;
            }

            .print-preview-table th {
                display: table-cell !important;
                height: auto !important;
                padding: 3px 4px !important;
                border: 1px solid #334155 !important;
                background: #166534 !important;
                color: #fff !important;
                font-size: 8pt !important;
                font-weight: 800 !important;
                line-height: 1.05 !important;
                white-space: normal !important;
                overflow: visible !important;
                text-overflow: clip !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .print-preview-table td {
                display: table-cell !important;
                height: auto !important;
                padding: 1.8px 4px !important;
                border: 1px solid #64748b !important;
                color: #000 !important;
                font-size: 8pt !important;
                line-height: 1.05 !important;
                vertical-align: middle !important;
                overflow-wrap: anywhere !important;
            }

            .print-preview-table .address-cell {
                white-space: normal !important;
            }

            .print-preview-table tbody tr:nth-child(even) {
                background: #f1f5f9 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .received-by {
                width: 49% !important;
                height: 0.55in !important;
                min-height: 0.55in !important;
                margin-top: 5px !important;
                padding: 5px 8px !important;
                border: 1px solid #64748b !important;
                color: #000 !important;
                font-size: 8pt !important;
                vertical-align: top !important;
            }

            .received-by strong {
                display: block !important;
                margin-bottom: 0 !important;
                color: #000 !important;
                font-size: 8pt !important;
                font-weight: 800 !important;
            }

            .assign-form,
            .no-print,
            #themeToggle,
            dialog,
            #modalContainer {
                display: none !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="print-preview-wrap">
        <div class="admin-topbar print-preview-topbar no-print">
            <div class="heading">
                <h1>Transmittal Print Preview</h1>
                <p>13 × 8.5 in landscape • 40 records per page</p>
            </div>
            <div class="actions">
                <button type="button" class="btn btn-outline btn-sm" onclick="window.print()">Print</button>
                <a href="{{ route('admin') }}" class="btn btn-sm">Back to Admin</a>
            </div>
        </div>

        @if($records->isEmpty())
            <div class="app-alert app-alert--warning">No records found for this preview.</div>
        @else
            @php
                // Dynamic column width calculation based on content
                $maxTextLengths = [
                    'no' => 2,
                    'farmerName' => strlen('Farmer Name'),
                    'address' => strlen('Address'),
                    'program' => strlen('Program'),
                    'line' => strlen('Line'),
                    'causeOfDamage' => strlen('Cause of Damage'),
                    'remarks' => strlen('Remarks')
                ];
                
                // Calculate maximum text length for each column
                foreach ($records as $index => $record) {
                    $maxTextLengths['no'] = max($maxTextLengths['no'], strlen((string)($index + 1)));
                    $maxTextLengths['farmerName'] = max($maxTextLengths['farmerName'], strlen($record->farmerName));
                    $maxTextLengths['address'] = max($maxTextLengths['address'], strlen($record->barangay . ', ' . $record->municipality));
                    $maxTextLengths['program'] = max($maxTextLengths['program'], strlen($record->program));
                    $maxTextLengths['line'] = max($maxTextLengths['line'], strlen($record->line));
                    $maxTextLengths['causeOfDamage'] = max($maxTextLengths['causeOfDamage'], strlen($record->causeOfDamage));
                    $maxTextLengths['remarks'] = max($maxTextLengths['remarks'], strlen($record->remarks ?: ''));
                }
                
                // Calculate character-based widths (rough approximation)
                $charWidths = [
                    'no' => $maxTextLengths['no'] * 0.6, // Narrow numbers
                    'farmerName' => $maxTextLengths['farmerName'] * 0.5, // Names
                    'address' => $maxTextLengths['address'] * 0.45, // Addresses
                    'program' => $maxTextLengths['program'] * 0.55, // Programs
                    'line' => $maxTextLengths['line'] * 0.6, // Lines
                    'causeOfDamage' => $maxTextLengths['causeOfDamage'] * 0.4, // Causes
                    'remarks' => $maxTextLengths['remarks'] * 0.5 // Remarks
                ];
                
                // Set minimum widths for readability
                $minWidths = [
                    'no' => 4,
                    'farmerName' => 15,
                    'address' => 20,
                    'program' => 8,
                    'line' => 6,
                    'causeOfDamage' => 10,
                    'remarks' => 8
                ];
                
                // Apply minimum widths
                foreach ($charWidths as $col => $width) {
                    $charWidths[$col] = max($width, $minWidths[$col]);
                }
                
                // Calculate total and normalize to 100%
                $totalWidth = array_sum($charWidths);
                $columnWidths = [];
                foreach ($charWidths as $col => $width) {
                    $columnWidths[$col] = round(($width / $totalWidth) * 100, 1);
                }
                
                // Adjust to ensure exactly 100%
                $currentTotal = array_sum($columnWidths);
                $diff = 100 - $currentTotal;
                if ($diff != 0) {
                    $columnWidths['farmerName'] += $diff; // Adjust largest column
                }
                
                // Calculate dynamic font size based on content density
                $avgTextLength = array_sum($maxTextLengths) / count($maxTextLengths);
                $baseFontSize = 10;
                $fontSize = max(8, min(12, $baseFontSize - ($avgTextLength * 0.05)));
                
                $chunks = $records->chunk($perPage);
            @endphp

            @foreach($chunks as $pageIndex => $pageRecords)
                <section class="page-section">
                    <div class="print-preview-card">
                        <div class="meta">
                            <div><strong>Date Encoded:</strong> {{ $encodedDate }}</div>
                            <div><strong>Transmittal #:</strong> {{ $pageTransmittalNumbers[$pageIndex + 1] ?? '____________________' }}</div>
                            <div><strong>Records:</strong> {{ $pageRecords->count() }} of {{ $totalRecords }} (Page {{ $pageIndex + 1 }} of {{ $totalPages }})</div>
                        </div>

                        <div class="table-wrap">
                            <table class="print-preview-table">
                                <thead>
                                    <tr>
                                        <th style="width: {{ $columnWidths['no'] }}%; font-size: {{ $fontSize }}px; height: {{ $fontSize + 2 }}px;">No.</th>
                                        <th style="width: {{ $columnWidths['farmerName'] }}%; font-size: {{ $fontSize }}px; height: {{ $fontSize + 2 }}px;">Farmer Name</th>
                                        <th style="width: {{ $columnWidths['address'] }}%; font-size: {{ $fontSize }}px; height: {{ $fontSize + 2 }}px;">Address</th>
                                        <th style="width: {{ $columnWidths['program'] }}%; font-size: {{ $fontSize }}px; height: {{ $fontSize + 2 }}px;">Program</th>
                                        <th style="width: {{ $columnWidths['line'] }}%; font-size: {{ $fontSize }}px; height: {{ $fontSize + 2 }}px;">Line</th>
                                        <th style="width: {{ $columnWidths['causeOfDamage'] }}%; font-size: {{ $fontSize }}px; height: {{ $fontSize + 2 }}px;">Cause of Damage</th>
                                        <th style="width: {{ $columnWidths['remarks'] }}%; font-size: {{ $fontSize }}px; height: {{ $fontSize + 2 }}px;">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pageRecords as $index => $record)
                                        <tr>
                                            <td style="font-size: {{ $fontSize }}px; height: {{ $fontSize }}px;">{{ $index + 1 }}</td>
                                            <td style="font-size: {{ $fontSize }}px; height: {{ $fontSize }}px;">{{ $record->farmerName }}</td>
                                            <td class="address-cell" style="font-size: {{ $fontSize }}px; height: {{ $fontSize }}px;">
                                                {{ trim(implode(', ', array_filter([$record->barangay, $record->municipality]))) ?: '—' }}
                                            </td>
                                            <td style="font-size: {{ $fontSize }}px; height: {{ $fontSize }}px;">{{ $record->program }}</td>
                                            <td style="font-size: {{ $fontSize }}px; height: {{ $fontSize }}px;">{{ $record->line }}</td>
                                            <td style="font-size: {{ $fontSize }}px; height: {{ $fontSize }}px;">{{ $record->causeOfDamage }}</td>
                                            <td style="font-size: {{ $fontSize }}px; height: {{ $fontSize }}px;">{{ $record->remarks ?: '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="received-by"><strong>Received By</strong></div>
                        <div class="received-by"><strong>Encoded By</strong></div>
                    </div>
                </section>
            @endforeach
        @endif
    </div>

    @if(!$isReprint)
    <form class="assign-form no-print" method="POST" action="{{ route('admin.assign-transmittals') }}" onsubmit="handleAssignTransmittal(event)">
        @csrf
        @foreach($query as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <button type="submit" class="btn btn-success">Assign Transmittal Number</button>
        <a href="{{ route('admin.export-preview-csv') }}?{{ http_build_query($query) }}" class="btn btn-primary" target="_blank">Export to CSV</a>
    </form>
    @endif
    
    <script>
        function handleAssignTransmittal(event) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                const assignModal = document.getElementById('assignTransmittalModal');
                const messageElement = document.getElementById('assignTransmittalMessage');
                
                if (data.success) {
                    // Show success message in modal
                    if (assignModal && messageElement) {
                        messageElement.textContent = 'Transmittal numbers assigned successfully!';
                        messageElement.className = 'text-sm text-green-600 mb-4';
                        assignModal.showModal();
                        
                        // Handle modal buttons
                        const continueBtn = document.getElementById('assignTransmittalContinue');
                        const cancelBtn = document.getElementById('assignTransmittalCancel');
                        cancelBtn.style.display = 'none';
                        continueBtn.textContent = 'Continue';
                        
                        // Remove existing event listeners
                        const newContinueBtn = continueBtn.cloneNode(true);
                        const newCancelBtn = cancelBtn.cloneNode(true);
                        continueBtn.parentNode.replaceChild(newContinueBtn, continueBtn);
                        cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
                        
                        // Add event listeners
                        newContinueBtn.addEventListener('click', function() {
                            assignModal.close();
                            // Refresh the page to update the transmittal numbers in headers
                            window.location.reload();
                        });
                        
                        newCancelBtn.addEventListener('click', function() {
                            assignModal.close();
                        });
                    }
                } else {
                    // Show error message in modal
                    if (assignModal && messageElement) {
                        const alreadyAssigned = data.message === 'Transmittal number already assigned!';
                        messageElement.textContent = data.message || 'Failed to assign transmittal numbers';
                        messageElement.className = 'text-sm text-red-600 mb-4';
                        assignModal.showModal();
                        
                        // Handle modal buttons
                        const continueBtn = document.getElementById('assignTransmittalContinue');
                        const cancelBtn = document.getElementById('assignTransmittalCancel');

                        cancelBtn.style.display = alreadyAssigned ? 'none' : '';
                        continueBtn.textContent = alreadyAssigned ? 'OK' : 'Assign';
                        
                        // Remove existing event listeners
                        const newContinueBtn = continueBtn.cloneNode(true);
                        const newCancelBtn = cancelBtn.cloneNode(true);
                        continueBtn.parentNode.replaceChild(newContinueBtn, continueBtn);
                        cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
                        
                        // Add event listeners
                        newContinueBtn.addEventListener('click', function() {
                            assignModal.close();
                        });
                        
                        newCancelBtn.addEventListener('click', function() {
                            assignModal.close();
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const assignModal = document.getElementById('assignTransmittalModal');
                const messageElement = document.getElementById('assignTransmittalMessage');
                
                if (assignModal && messageElement) {
                    messageElement.textContent = 'An error occurred while assigning transmittal numbers';
                    messageElement.className = 'text-sm text-red-600 mb-4';
                    assignModal.showModal();
                    
                    // Handle modal buttons
                    const continueBtn = document.getElementById('assignTransmittalContinue');
                    const cancelBtn = document.getElementById('assignTransmittalCancel');
                    
                    // Remove existing event listeners
                    const newContinueBtn = continueBtn.cloneNode(true);
                    const newCancelBtn = cancelBtn.cloneNode(true);
                    continueBtn.parentNode.replaceChild(newContinueBtn, continueBtn);
                    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
                    
                    // Add event listeners
                    newContinueBtn.addEventListener('click', function() {
                        assignModal.close();
                    });
                    
                    newCancelBtn.addEventListener('click', function() {
                        assignModal.close();
                    });
                }
            });
        }
    </script>
@endsection
