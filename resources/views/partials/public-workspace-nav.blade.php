<aside class="public-workspace-sidebar" aria-label="Public workspace navigation">
    <div class="public-workspace-brand">
        <button type="button" class="public-workspace-toggle" aria-label="Collapse navigation" aria-expanded="true" title="Collapse navigation">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <div class="public-workspace-brand-content">
            <img src="{{ asset('images/PCIC_RO3A_LOGO.jpg') }}" alt="">
            <span>
                <strong>PCIC RO III-A</strong>
                <small>NL/CI Records Monitoring</small>
            </span>
        </div>
    </div>

    @unless ($adminNavigation ?? false)
        <nav class="public-workspace-links" aria-label="Main navigation">
            <a href="{{ route('welcome') }}" @if(request()->routeIs('welcome')) aria-current="page" @endif>
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-6v-7h-4v7H4a1 1 0 0 1-1-1z"></path></svg>
                <span>Home</span>
            </a>
            <a href="{{ route('all-records') }}" @if(request()->routeIs('all-records')) aria-current="page" @endif>
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M7 3h7l5 5v13H7z"></path><path d="M14 3v6h6M10 13h6M10 17h6"></path></svg>
                <span>All Records</span>
            </a>
            <a href="{{ route('public-dashboard') }}" @if(request()->routeIs('public-dashboard')) aria-current="page" @endif>
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 3v18h18"></path><path d="m19 9-5 5-4-4-5 5"></path></svg>
                <span>Public Dashboard</span>
            </a>
        </nav>
    @endunless

    @if ($adminNavigation ?? false)
        <div class="public-workspace-section-label">Admin workspace</div>
        <nav class="public-workspace-links admin-workspace-links" aria-label="Admin workspace sections">
            <button type="button" class="active" id="btn-dashboard" aria-controls="dashboard-section" aria-current="page">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 3h8v8H3zM13 3h8v5h-8zM13 10h8v11h-8zM3 13h8v8H3z"></path></svg>
                <span>Dashboard</span>
            </button>
            <button type="button" id="btn-nl-records" aria-controls="nl-records-section">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M7 3h7l5 5v13H7z"></path><path d="M14 3v6h6M10 13h6M10 17h6"></path></svg>
                <span>NL Records</span>
            </button>
        </nav>

        <div class="public-workspace-section-label">Tools</div>
        <div class="public-workspace-links admin-tool-links" aria-label="Admin tools">
            <button type="button" id="openActiveUsersModal" title="View active users">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span>Active users</span>
            </button>
            <button type="button" id="openUserMaintenanceModal" title="User Maintenance - Manage Officers">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12.22 2h-.44a2 2 0 0 0-2 1.72l-.15 1.05a7.9 7.9 0 0 0-1.73 1l-.99-.47a2 2 0 0 0-2.55.73l-.22.38a2 2 0 0 0 .55 2.6l.84.64a8.1 8.1 0 0 0 0 2l-.84.64a2 2 0 0 0-.55 2.6l.22.38a2 2 0 0 0 2.55.73l.99-.47a7.9 7.9 0 0 0 1.73 1l.15 1.05a2 2 0 0 0 2 1.72h.44a2 2 0 0 0 2-1.72l.15-1.05a7.9 7.9 0 0 0 1.73-1l.99.47a2 2 0 0 0 2.55-.73l.22-.38a2 2 0 0 0-.55-2.6l-.84-.64a8.1 8.1 0 0 0 0-2l.84-.64a2 2 0 0 0 .55-2.6l-.22-.38a2 2 0 0 0-2.55-.73l-.99.47a7.9 7.9 0 0 0-1.73-1l-.15-1.05a2 2 0 0 0-2-1.72Z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <span>User maintenance</span>
            </button>
            <button type="button" id="openAdminUsersModal" title="Admin Users">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"></path><path d="M5 21v-2a7 7 0 0 1 14 0v2M19 8h3m-1.5-1.5v3"></path></svg>
                <span>Admin users</span>
            </button>
            <button type="button" id="openReportsModal" title="Reports">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 20V4M4 20h17"></path><path d="M8 16v-4m4 4V7m4 9v-6m4 6V9"></path></svg>
                <span>Reports</span>
            </button>
        </div>
    @endif

    <a href="{{ route('welcome') }}" class="public-workspace-back">← Return to modules</a>
</aside>
