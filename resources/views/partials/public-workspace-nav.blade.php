<aside class="public-workspace-sidebar" aria-label="Public workspace navigation">
    <a href="{{ route('welcome') }}" class="public-workspace-brand">
        <img src="{{ asset('images/PCIC_RO3A_LOGO.jpg') }}" alt="">
        <span>
            <strong>PCIC RO III-A</strong>
            <small>NL/CI Records Monitoring</small>
        </span>
    </a>

    <nav class="public-workspace-links">
        <a href="{{ route('welcome') }}">Home</a>
        <a href="{{ route('all-records') }}" @if(request()->routeIs('all-records')) aria-current="page" @endif>All Records</a>
        <a href="{{ route('public-dashboard') }}" @if(request()->routeIs('public-dashboard')) aria-current="page" @endif>Public Dashboard</a>
        <a href="{{ route('admin.login') }}">Administrator</a>
    </nav>

    <a href="{{ route('welcome') }}" class="public-workspace-back">← Return to modules</a>
</aside>
