@extends('layout.layout')

@section('title', 'Public Dashboard')

@section('page-styles')
<style>
    :root { --dashboard-ink: #17211b; --dashboard-muted: #64716a; --dashboard-green: #176b45; --dashboard-gold: #d69b2d; --dashboard-paper: #f5f7f3; }
    body { margin: 0; background: var(--dashboard-paper); color: var(--dashboard-ink); }
    .public-dashboard { min-height: 100vh; background: radial-gradient(circle at top right, rgba(214, 155, 45, .18), transparent 34rem), linear-gradient(135deg, #f5f7f3 0%, #e9f0e7 100%); }
    .dashboard-header { background: #153b2b; color: #fff; padding: 28px clamp(20px, 5vw, 72px) 34px; }
    .dashboard-header-inner, .dashboard-content { max-width: 1280px; margin: 0 auto; }
    .dashboard-header-inner { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; }
    .dashboard-kicker { margin: 0 0 8px; color: #e7bc61; font-size: 11px; font-weight: 800; letter-spacing: .16em; text-transform: uppercase; }
    .dashboard-title { margin: 0; color: #fff; font-size: clamp(25px, 4vw, 42px); line-height: 1; font-weight: 900; }
    .dashboard-description { max-width: 520px; margin: 12px 0 0; color: #c8d9ce; font-size: 14px; }
    .dashboard-back { display: inline-flex; align-items: center; gap: 7px; color: #fff; border: 1px solid rgba(255,255,255,.3); padding: 9px 13px; border-radius: 7px; text-decoration: none; font-size: 12px; font-weight: 800; white-space: nowrap; }
    .dashboard-content { padding: 22px clamp(20px, 5vw, 72px) 48px; }
    .dashboard-filter, .dashboard-card { background: rgba(255,255,255,.87); border: 1px solid rgba(23,59,43,.12); border-radius: 10px; box-shadow: 0 8px 24px rgba(23,59,43,.07); }
    .dashboard-filter { display: flex; flex-wrap: wrap; align-items: end; gap: 12px; padding: 15px; margin-bottom: 18px; }
    .dashboard-field { display: flex; flex: 1 1 160px; flex-direction: column; gap: 5px; }
    .dashboard-field label { color: var(--dashboard-muted); font-size: 10px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
    .dashboard-field select, .dashboard-field input { height: 36px; border: 1px solid #d6dfd7; border-radius: 6px; padding: 0 9px; color: var(--dashboard-ink); background: #fff; font-size: 13px; }
    .dashboard-button { height: 36px; border: 0; border-radius: 6px; padding: 0 16px; color: #fff; background: var(--dashboard-green); font-size: 12px; font-weight: 800; cursor: pointer; }
    .dashboard-button.secondary { color: var(--dashboard-green); background: #e4eee7; text-decoration: none; display: inline-flex; align-items: center; }
    .dashboard-button.print { color: var(--dashboard-ink); background: #f0e7cf; }
    .dashboard-button.explorer { color: #fff; background: #285f88; }
    .dashboard-summary { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 18px; }
    .summary-card { padding: 18px; border-left: 4px solid var(--dashboard-green); }
    .summary-card:nth-child(2) { border-left-color: var(--dashboard-gold); }
    .summary-card:nth-child(3) { border-left-color: #3887a5; }
    .summary-label { color: var(--dashboard-muted); font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; }
    .summary-value { margin-top: 7px; color: var(--dashboard-ink); font-size: 30px; font-weight: 900; }
    .dashboard-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
    .dashboard-card { padding: 20px; }
    .dashboard-card h2 { margin: 0; font-size: 16px; }
    .dashboard-card p { margin: 4px 0 18px; color: var(--dashboard-muted); font-size: 12px; }
    .bar-row { display: grid; grid-template-columns: minmax(90px, 1fr) 2fr 48px; align-items: center; gap: 10px; margin: 12px 0; font-size: 12px; }
    .bar-label { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .bar-track { height: 9px; overflow: hidden; border-radius: 99px; background: #e4ebe5; }
    .bar-fill { height: 100%; border-radius: inherit; background: linear-gradient(90deg, var(--dashboard-green), #56a678); }
    .bar-value { color: var(--dashboard-muted); text-align: right; font-weight: 800; }
    .legend { display: flex; flex-wrap: wrap; gap: 12px 18px; margin-top: 18px; }
    .legend-item { display: flex; align-items: center; gap: 6px; color: var(--dashboard-muted); font-size: 12px; }
    .legend-dot { width: 9px; height: 9px; border-radius: 50%; }
    .empty { color: var(--dashboard-muted); font-size: 13px; }
    .province-trigger { width: 100%; border: 0; padding: 0; color: inherit; background: transparent; text-align: left; cursor: pointer; }
    .province-trigger:hover .bar-label { color: var(--dashboard-green); text-decoration: underline; }
    .dashboard-modal { width: min(620px, calc(100vw - 32px)); max-height: min(680px, calc(100vh - 32px)); padding: 0; border: 0; border-radius: 10px; box-shadow: 0 24px 70px rgba(23,59,43,.28); }
    .dashboard-modal::backdrop { background: rgba(10, 35, 23, .56); }
    .modal-header { display:flex; align-items:center; justify-content:space-between; padding: 18px 20px; color: #fff; background: #153b2b; }
    .modal-header h2 { margin: 0; font-size: 17px; }
    .modal-close { border: 0; color: #fff; background: transparent; font-size: 22px; cursor: pointer; }
    .modal-body { padding: 18px 20px 22px; overflow: auto; }
    .location-button { display:flex; width:100%; align-items:center; justify-content:space-between; border:1px solid #dce6de; border-radius:7px; padding:11px 12px; margin: 8px 0; color: var(--dashboard-ink); background:#fff; text-align:left; cursor:pointer; }
    .location-button:hover { border-color: var(--dashboard-green); background:#f2f8f3; }
    .location-count { color: var(--dashboard-green); font-weight: 900; }
    .explorer-panel { display: none; margin: 0 0 18px; overflow: hidden; background: rgba(255,255,255,.92); border: 1px solid rgba(23,59,43,.14); border-radius: 10px; box-shadow: 0 8px 24px rgba(23,59,43,.08); }
    .explorer-panel.is-open { display: block; }
    .explorer-header { display:flex; align-items:center; justify-content:space-between; gap:12px; padding:16px 18px; color:#fff; background:#234b68; }
    .explorer-header h2 { margin:0; font-size:17px; }
    .explorer-header p { margin:4px 0 0; color:#d5e4ef; font-size:12px; }
    .explorer-close { border:1px solid rgba(255,255,255,.4); border-radius:6px; padding:7px 10px; color:#fff; background:transparent; cursor:pointer; font-size:11px; font-weight:800; }
    .explorer-body { display:grid; grid-template-columns:minmax(230px, .85fr) minmax(0, 1.5fr); min-height:430px; }
    .folder-tree { padding:14px; overflow:auto; border-right:1px solid #dce6de; background:#f7faf7; }
    .folder-node { margin:3px 0; }
    .folder-button { display:flex; width:100%; align-items:center; gap:8px; border:0; border-radius:6px; padding:9px 8px; color:var(--dashboard-ink); background:transparent; text-align:left; cursor:pointer; font-size:12px; }
    .folder-button:hover, .folder-button.active { background:#dfeee3; color:var(--dashboard-green); }
    .folder-arrow { width:12px; color:var(--dashboard-muted); }
    .folder-bullet { width:15px; color:var(--dashboard-green); font-size:16px; line-height:1; }
    .folder-count { margin-left:auto; color:var(--dashboard-muted); font-size:11px; font-weight:800; }
    .folder-children { display:none; margin-left:18px; padding-left:7px; border-left:1px solid #cddbd0; }
    .folder-node.expanded > .folder-children { display:block; }
    .explorer-summary { padding:22px; overflow:auto; }
    .explorer-summary h3 { margin:0; font-size:20px; }
    .explorer-summary .summary-total { margin:5px 0 20px; color:var(--dashboard-green); font-size:26px; font-weight:900; }
    .explorer-summary-grid { display:grid; grid-template-columns:repeat(3, minmax(0,1fr)); gap:12px; }
    .explorer-summary-card { padding:13px; border:1px solid #dce6de; border-radius:7px; background:#fbfdfb; }
    .explorer-summary-card h4 { margin:0 0 8px; color:var(--dashboard-muted); font-size:10px; letter-spacing:.08em; text-transform:uppercase; }
    .explorer-summary-card div { display:flex; justify-content:space-between; gap:10px; margin:5px 0; font-size:12px; }
    .explorer-summary-card strong { color:var(--dashboard-green); }
    .explorer-loading { padding:30px; color:var(--dashboard-muted); font-size:13px; }
    @media (max-width: 700px) { .explorer-body { grid-template-columns:1fr; } .folder-tree { max-height:300px; border-right:0; border-bottom:1px solid #dce6de; } .explorer-summary-grid { grid-template-columns:1fr; } }
    @media (max-width: 700px) { .dashboard-header-inner { align-items: flex-start; flex-direction: column; } .dashboard-summary, .dashboard-grid { grid-template-columns: 1fr; } .dashboard-filter { align-items: stretch; flex-direction: column; } .dashboard-button { width: 100%; justify-content: center; } }
</style>
@endsection

@section('content')
<div class="public-dashboard">
    <header class="dashboard-header">
        <div class="dashboard-header-inner">
            <div>
                <p class="dashboard-kicker">PCIC Regional Office III-A</p>
                <h1 class="dashboard-title">NL Records Dashboard</h1>
                <p class="dashboard-description">summary report</p>
            </div>
            <a href="{{ route('welcome') }}" class="dashboard-back">Back to modules</a>
        </div>
    </header>

    <main class="dashboard-content">
        <form method="GET" action="{{ route('public-dashboard') }}" class="dashboard-filter">
            <div class="dashboard-field"><label for="program">Program</label><select id="program" name="program"><option value="">All programs</option>@foreach($allPrograms as $program)<option value="{{ $program }}" @selected(request('program') === $program)>{{ $program }}</option>@endforeach</select></div>
            <div class="dashboard-field"><label for="line">Insurance line</label><select id="line" name="line"><option value="">All lines</option>@foreach($allLines as $line)<option value="{{ $line }}" @selected(request('line') === $line)>{{ $line }}</option>@endforeach</select></div>
            <div class="dashboard-field"><label for="from">From</label><input id="from" type="date" name="from" value="{{ request('from') }}"></div>
            <div class="dashboard-field"><label for="to">To</label><input id="to" type="date" name="to" value="{{ request('to') }}"></div>
            <button class="dashboard-button" type="submit">Apply filters</button><a class="dashboard-button secondary" href="{{ route('public-dashboard') }}">Clear</a>
            <a class="dashboard-button secondary" href="{{ route('public-dashboard.export.csv', request()->query()) }}">Export Excel</a>
            <button class="dashboard-button explorer" type="button" id="openExplorer">Detailed view</button>
            <button class="dashboard-button print" type="button" onclick="window.print()">Print report</button>
        </form>

        <section class="explorer-panel" id="explorerPanel" aria-label="Detailed location view">
            <div class="explorer-header"><div><h2>Detailed location view</h2><p>Open folders to move from province to municipality to barangay.</p></div><button class="explorer-close" type="button" id="closeExplorer">Close</button></div>
            <div class="explorer-body"><div class="folder-tree" id="folderTree"><div class="explorer-loading">Loading folders...</div></div><div class="explorer-summary" id="explorerSummary"><div class="explorer-loading">Select a folder to view its summary.</div></div></div>
        </section>

        <section class="dashboard-summary" aria-label="Summary">
            <div class="dashboard-card summary-card"><div class="summary-label">Records in view</div><div class="summary-value">{{ number_format($totalRecords) }}</div></div>
            <div class="dashboard-card summary-card"><div class="summary-label">Added in 7 days</div><div class="summary-value">{{ number_format($recentRecords) }}</div></div>
            <div class="dashboard-card summary-card"><div class="summary-label">Reporting areas</div><div class="summary-value">{{ number_format($recordsByProvince->count()) }}</div></div>
        </section>

        <section class="dashboard-grid">
            @php $chartMax = max($recordsByLine->max() ?? 1, $recordsByProgram->max() ?? 1, $recordsByProvince->max() ?? 1, 1); @endphp
            @foreach([['title' => 'Records by insurance line', 'subtitle' => 'Distribution by crop and coverage line.', 'data' => $recordsByLine], ['title' => 'Records by program', 'subtitle' => 'Programs represented in the current view.', 'data' => $recordsByProgram], ['title' => 'Records by province', 'subtitle' => 'Click a province to view municipalities, then barangays.', 'data' => $recordsByProvince]] as $chart)
                <article class="dashboard-card"><h2>{{ $chart['title'] }}</h2><p>{{ $chart['subtitle'] }}</p>@forelse($chart['data'] as $label => $count)@if($chart['title'] === 'Records by province')<button type="button" class="bar-row province-trigger" data-province="{{ $label }}"><span class="bar-label" title="{{ $label }}">{{ $label ?: 'Unspecified' }}</span><span class="bar-track"><span class="bar-fill" style="display:block;width:{{ round(($count / $chartMax) * 100) }}%"></span></span><span class="bar-value">{{ number_format($count) }}</span></button>@else<div class="bar-row"><span class="bar-label" title="{{ $label }}">{{ $label ?: 'Unspecified' }}</span><span class="bar-track"><span class="bar-fill" style="display:block;width:{{ round(($count / $chartMax) * 100) }}%"></span></span><span class="bar-value">{{ number_format($count) }}</span></div>@endif @empty<span class="empty">No records match the selected filters.</span>@endforelse</article>
            @endforeach
            <article class="dashboard-card"><h2>Records by source</h2><p>Where the records entered the monitoring system.</p>@php $sourceColors = ['OD' => '#176b45', 'Email' => '#d69b2d', 'Facebook' => '#3887a5']; @endphp @forelse($recordsBySource as $source => $count)<div class="bar-row"><span class="bar-label">{{ $source ?: 'Unspecified' }}</span><span class="bar-track"><span class="bar-fill" style="background:{{ $sourceColors[$source] ?? '#7b8b80' }};display:block;width:{{ round(($count / max($recordsBySource->max() ?? 1, 1)) * 100) }}%"></span></span><span class="bar-value">{{ number_format($count) }}</span></div>@empty<span class="empty">No records match the selected filters.</span>@endforelse</article>
        </section>
    </main>

    <dialog id="locationModal" class="dashboard-modal">
        <div class="modal-header"><h2 id="locationModalTitle">Locations</h2><button type="button" class="modal-close" id="closeLocationModal" aria-label="Close">&times;</button></div>
        <div class="modal-body" id="locationModalBody"><span class="empty">Select a province to begin.</span></div>
    </dialog>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('locationModal');
    const title = document.getElementById('locationModalTitle');
    const body = document.getElementById('locationModalBody');
    const endpoint = {!! json_encode(route('public-dashboard.locations')) !!};
    const filters = new URLSearchParams({!! json_encode($dashboardFilters) !!});
    const explorerPanel = document.getElementById('explorerPanel');
    const folderTree = document.getElementById('folderTree');
    const explorerSummary = document.getElementById('explorerSummary');
    const explorerEndpoint = {!! json_encode(route('public-dashboard.explorer')) !!};

    function summaryMarkup(name, summary) {
        const groups = [['Lines', summary.lines], ['Programs', summary.programs], ['Sources', summary.sources]];
        return '<h3>' + name + '</h3><div class="summary-total">' + Number(summary.total).toLocaleString() + ' NLs</div><div class="explorer-summary-grid">' + groups.map(group => '<div class="explorer-summary-card"><h4>' + group[0] + '</h4>' + Object.entries(group[1]).map(item => '<div><span>' + item[0] + '</span><strong>' + Number(item[1]).toLocaleString() + '</strong></div>').join('') + '</div>').join('') + '</div>';
    }

    function makeFolder(name, node, level) {
        const wrapper = document.createElement('div');
        wrapper.className = 'folder-node';
        const button = document.createElement('button');
        button.type = 'button'; button.className = 'folder-button';
        const children = level < 2 ? document.createElement('div') : null;
        if (children) children.className = 'folder-children';
        const items = level === 0 ? node.municipalities : level === 1 ? node.barangays : null;
        button.innerHTML = '<span class="folder-arrow">' + (items ? '&#9654;' : '') + '</span><span class="folder-bullet">&bull;</span><span>' + name + '</span><span class="folder-count">' + Number(node.summary.total).toLocaleString() + '</span>';
        button.addEventListener('click', function () {
            document.querySelectorAll('.folder-button.active').forEach(item => item.classList.remove('active'));
            button.classList.add('active'); explorerSummary.innerHTML = summaryMarkup(name, node.summary);
            if (children) wrapper.classList.toggle('expanded');
        });
        wrapper.appendChild(button);
        if (children) { Object.entries(items).forEach(item => children.appendChild(makeFolder(item[0], item[1], level + 1))); wrapper.appendChild(children); }
        return wrapper;
    }

    function loadExplorer() {
        folderTree.innerHTML = '<div class="explorer-loading">Loading folders...</div>';
        fetch(explorerEndpoint + '?' + filters.toString()).then(response => response.json()).then(data => {
            folderTree.innerHTML = '';
            if (!Object.keys(data.tree).length) { folderTree.innerHTML = '<div class="explorer-loading">No locations match the selected filters.</div>'; return; }
            Object.entries(data.tree).forEach(item => folderTree.appendChild(makeFolder(item[0], item[1], 0)));
            const first = folderTree.querySelector('.folder-button'); if (first) first.click();
        }).catch(() => { folderTree.innerHTML = '<div class="explorer-loading">Unable to load detailed locations.</div>'; });
    }

    document.getElementById('openExplorer').addEventListener('click', function () { explorerPanel.classList.add('is-open'); loadExplorer(); explorerPanel.scrollIntoView({ behavior: 'smooth', block: 'start' }); });
    document.getElementById('closeExplorer').addEventListener('click', () => explorerPanel.classList.remove('is-open'));

    function loadLocations(province, municipality = null) {
        const params = new URLSearchParams(filters);
        params.set('province', province);
        if (municipality) params.set('municipality', municipality);
        title.textContent = municipality ? municipality + ' barangays' : province + ' municipalities';
        body.innerHTML = '<span class="empty">Loading locations...</span>';
        modal.showModal();
        fetch(endpoint + '?' + params.toString())
            .then(response => response.json())
            .then(data => {
                body.innerHTML = '';
                if (!data.locations.length) {
                    body.innerHTML = '<span class="empty">No locations found for the selected filters.</span>';
                    return;
                }
                data.locations.forEach(location => {
                    const item = document.createElement(municipality ? 'div' : 'button');
                    item.className = municipality ? 'location-button' : 'location-button';
                    item.innerHTML = '<span>' + location.name + '</span><span class="location-count">' + Number(location.count).toLocaleString() + ' NLs</span>';
                    if (!municipality) item.addEventListener('click', () => loadLocations(province, location.name));
                    body.appendChild(item);
                });
            })
            .catch(() => { body.innerHTML = '<span class="empty">Unable to load location details.</span>'; });
    }

    document.querySelectorAll('.province-trigger').forEach(button => button.addEventListener('click', () => loadLocations(button.dataset.province)));
    document.getElementById('closeLocationModal').addEventListener('click', () => modal.close());
    modal.addEventListener('click', event => { if (event.target === modal) modal.close(); });
});
</script>
@endpush