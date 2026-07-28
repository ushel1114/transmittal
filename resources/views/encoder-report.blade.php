@extends('layout.layout')

@section('title', 'Encoder Report')

@section('page-styles')
    <style>
        .encoder-report-wrap {
            max-width: 1200px;
            margin: 18px auto 24px auto;
            padding: 0 14px;
        }

        .encoder-report-topbar {
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

        .encoder-report-topbar .heading h1 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
        }

        .encoder-report-topbar .heading p {
            margin: 2px 0 0 0;
            font-size: 13px;
            color: rgba(15, 23, 42, 0.6);
        }

        .encoder-report-topbar .actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .encoder-report-card {
            background: rgba(255,255,255,0.92);
            border: 1px solid rgba(15, 23, 42, 0.12);
            border-radius: 16px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .encoder-report-card .meta {
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

        .encoder-report-card .meta strong {
            color: #0f172a;
            font-weight: 900;
        }

        .encoder-report-card .table-wrap {
            padding: 0 10px 10px 10px;
        }

        .encoder-report-table {
            margin: 12px auto 10px auto;
            width: 100%;
            max-width: none;
            border-collapse: separate;
            border-spacing: 0;
            border: 2px solid rgba(25, 118, 210, 0.25);
            border-radius: 8px;
            overflow: hidden;
        }

        .encoder-report-table th {
            padding: 8px 10px;
            font-size: 11px;
            font-weight: 700;
            color: #0f172a;
            background: rgba(25, 118, 210, 0.12);
            border-bottom: 1px solid rgba(25, 118, 210, 0.2);
            text-align: left;
        }

        .encoder-report-table td {
            padding: 6px 10px;
            font-size: 11px;
            color: #334155;
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }

        .encoder-report-table tbody tr:last-child td {
            border-bottom: none;
        }

        .encoder-report-table tbody tr:hover {
            background: rgba(25, 118, 210, 0.04);
        }

        .source-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .source-od {
            background: rgba(34, 197, 94, 0.15);
            color: #166534;
        }

        .source-email {
            background: rgba(59, 130, 246, 0.15);
            color: #1e40af;
        }

        .source-facebook {
            background: rgba(147, 51, 234, 0.15);
            color: #7c3aed;
        }

        .no-records {
            text-align: center;
            padding: 40px 20px;
            color: rgba(15, 23, 42, 0.5);
            font-size: 14px;
        }

        .summary-card {
            background: rgba(255,255,255,0.92);
            border: 1px solid rgba(15, 23, 42, 0.12);
            border-radius: 16px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.08);
            padding: 16px 20px;
            margin-bottom: 14px;
        }

        .summary-card h2 {
            margin: 0 0 12px 0;
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
        }

        .summary-info {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .summary-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .summary-item label {
            font-size: 11px;
            font-weight: 600;
            color: rgba(15, 23, 42, 0.6);
            text-transform: uppercase;
        }

        .summary-item span {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
        }

        .total-count {
            font-size: 24px;
            font-weight: 900;
            color: #1976d2;
        }

        .daily-breakdown-card {
            background: rgba(255,255,255,0.92);
            border: 1px solid rgba(15, 23, 42, 0.12);
            border-radius: 16px;
            box-shadow: 0 10px 24px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 14px;
        }

        .daily-breakdown-card .meta {
            padding: 12px 14px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            background: linear-gradient(180deg, rgba(34, 197, 94, 0.08), rgba(255, 255, 255, 0));
            font-weight: 700;
            color: rgba(15, 23, 42, 0.86);
            font-size: 12px;
        }

        .daily-breakdown-table {
            margin: 12px auto 10px auto;
            width: 100%;
            max-width: none;
            border-collapse: separate;
            border-spacing: 0;
            border: 2px solid rgba(34, 197, 94, 0.25);
            border-radius: 8px;
            overflow: hidden;
        }

        .daily-breakdown-table th {
            padding: 8px 10px;
            font-size: 11px;
            font-weight: 700;
            color: #0f172a;
            background: rgba(34, 197, 94, 0.12);
            border-bottom: 1px solid rgba(34, 197, 94, 0.2);
            text-align: left;
        }

        .daily-breakdown-table td {
            padding: 6px 10px;
            font-size: 11px;
            color: #334155;
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }

        .daily-breakdown-table tbody tr:last-child td {
            border-bottom: none;
        }

        .daily-breakdown-table tbody tr:hover {
            background: rgba(34, 197, 94, 0.04);
        }

        .daily-count {
            font-weight: 700;
            color: #166534;
        }
    </style>
@endsection

@section('content')
    <div class="encoder-report-wrap">
        <div class="encoder-report-topbar">
            <div class="heading">
                <h1>Encoder Report</h1>
                <p>Records encoded by {{ $officer->name }}</p>
            </div>
            <div class="actions">
                <a href="{{ route('admin') }}" class="h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Back to Admin</a>
                <button onclick="window.print()" class="h-9 px-4 rounded-lg bg-pcic-700 text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Print Report</button>
            </div>
        </div>

        <div class="summary-card">
            <h2>Report Summary</h2>
            <div class="summary-info">
                <div class="summary-item">
                    <label>Encoder Name</label>
                    <span>{{ $officer->name }}</span>
                </div>
                <div class="summary-item">
                    <label>From Date</label>
                    <span>{{ date('F j, Y', strtotime($fromDate)) }}</span>
                </div>
                <div class="summary-item">
                    <label>To Date</label>
                    <span>{{ date('F j, Y', strtotime($toDate)) }}</span>
                </div>
                <div class="summary-item">
                    <label>Total Records</label>
                    <span class="total-count">{{ $totalRecords }}</span>
                </div>
            </div>
        </div>

        <div class="daily-breakdown-card">
            <div class="meta">
                <span><strong>Daily Breakdown</strong> - Records per day</span>
                <span><strong>Total Days:</strong> {{ $recordsByDate->count() }}</span>
            </div>
            <div class="table-wrap">
                @if($recordsByDate->isEmpty())
                    <div class="no-records">
                        No records found for the selected date range.
                    </div>
                @else
                    <table class="daily-breakdown-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Total Records</th>
                                <th>OD</th>
                                <th>Email</th>
                                <th>Facebook</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recordsByDate->sortByDesc(function($item, $key) {
                                return $key;
                            }) as $date => $dayRecords)
                                <tr>
                                    <td>{{ date('F j, Y', strtotime($date)) }}</td>
                                    <td>{{ date('l', strtotime($date)) }}</td>
                                    <td class="daily-count">{{ $dayRecords->count() }}</td>
                                    <td>{{ $dayRecords->where('source', 'OD')->count() }}</td>
                                    <td>{{ $dayRecords->where('source', 'Email')->count() }}</td>
                                    <td>{{ $dayRecords->where('source', 'Facebook')->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
