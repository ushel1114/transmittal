@extends('layout.layout')

@section('title', 'Email')

@push('styles')
<style>
.toggle-container {
    display: flex;
    align-items: center;
    gap: 8px;
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 44px;
    height: 24px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.toggle-switch input:checked + .toggle-slider {
    background-color: #006c35;
}

.toggle-switch input:focus + .toggle-slider {
    box-shadow: 0 0 1px #006c35;
}

.toggle-switch input:checked + .toggle-slider:before {
    transform: translateX(20px);
}

.toggle-label-text {
    font-size: 11px;
    color: #64748b;
    font-weight: 500;
}
</style>
@endpush

@section('page-styles')
<style>
html, body {
        overflow-x: hidden;
    }

    .channel-page-shell {
        padding-top: 57px;
    }

    .channel-fixed-header {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        height: 57px;
        border-bottom: 2px solid #94a3b8;
        box-shadow: 0 2px 6px rgb(15 23 42 / 10%);
    }

    .channel-workspace {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: repeat(2, minmax(0, 1fr));
        flex: 1;
        width: 100%;
        min-height: 0;
        align-items: stretch;
    }

    .channel-controls,
    .channel-records {
        display: flex;
        flex-direction: column;
        min-width: 0;
        min-height: 0;
        height: 100%;
        border: 1px solid #94a3b8;
        border-radius: 1rem;
        box-shadow: 0 2px 8px rgb(15 23 42 / 8%);
    }

    .contentContainer.channel-page-content {
        flex: 1;
        width: 100%;
        min-height: 0;
        max-width: none;
        margin: 0;
        box-sizing: border-box;
        align-items: stretch;
        justify-content: stretch;
        padding: 16px 18px;
    }

    .channel-controls > #controlActions,
    .channel-controls > #addRecordPanel {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
    }

    .channel-records > .p-4 {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-height: 0;
        gap: 0.75rem;
        overflow: hidden;
    }

    .channel-records .table-scroll-sync-top,
    .channel-records .table-scroll-sync-bottom {
        display: none;
    }

    .channel-records .table-wrapper {
        flex: 1;
        min-height: 0;
        width: 100%;
        max-width: 100%;
        overflow: auto;
        border: 1px solid #94a3b8;
        border-radius: 0.75rem;
        background: #fff;
    }

    #recordsPanel:has(.empty-state) .table-wrapper {
        display: none;
    }

    .channel-records .empty-state {
        flex: 1;
        min-height: 0;
        padding: 1rem !important;
    }

    .channel-pagination {
        flex: 0 0 auto;
        margin: auto 0 0 !important;
        padding-top: 0.5rem;
    }

    .channel-pagination #pagination-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .channel-pagination .channel-page-link,
    .channel-pagination .channel-page-disabled,
    .channel-pagination .channel-page-current {
        display: inline-flex;
        min-height: 2.25rem;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 0.875rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        font-size: 0.8125rem;
        font-weight: 700;
        text-decoration: none;
    }

    .channel-pagination .channel-page-link {
        border-color: #006c35;
        background: #006c35;
        color: #fff;
        transition: background-color 0.15s ease;
    }

    .channel-pagination .channel-page-link:hover {
        background: #005428;
    }

    .channel-pagination .channel-page-disabled {
        background: #f1f5f9;
        color: #94a3b8;
    }

    .channel-pagination .channel-page-current {
        background: #f8fafc;
        color: #334155;
    }

    @media (min-width: 768px) {
        .channel-workspace {
            grid-template-columns: minmax(300px, 360px) minmax(0, 1fr);
            grid-template-rows: minmax(0, 1fr);
        }
    }
</style>
@endsection

@section('content')
    <div class="min-h-screen flex flex-col bg-gradient-to-br from-pcic-100 via-white to-pcic-100 {{ $isLoggedIn ? 'channel-page-shell' : '' }}">

        <div class="odHeader sticky top-0 z-20 w-full bg-white/90 backdrop-blur-md border-b border-gray-200/60 {{ $isLoggedIn ? 'channel-fixed-header' : '' }}">
            <div class="max-w-6xl mx-auto h-full px-4 py-3 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="flex flex-col">
                        <h3 class="text-base font-black text-gray-900">Email</h3>
                        <p class="text-xs text-gray-500 font-semibold">NL Entry Module</p>
                    </div>
                </div>
                @if($isLoggedIn)
                <div class="flex items-center gap-3">
                    <div class="flex flex-col items-end">
                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Signed in as</div>
                        <div class="text-xs font-black text-gray-900">{{ $emailUserName }}</div>
                    </div>
                    <form action="{{ route('email.logout') }}" method="POST">
                        @csrf
                        <button class="logoutButton h-8 px-3 rounded-lg border border-gray-200 bg-white text-xs font-bold text-gray-600 hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-colors cursor-pointer" type="submit">Logout</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        <div class="contentContainer {{ $isLoggedIn ? 'channel-page-content' : '' }}">
    @if(!$isLoggedIn)
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg border border-gray-100/80 overflow-hidden">
            <div class="px-6 pt-6 pb-4 border-b border-gray-100 bg-gradient-to-b from-harvest-50/60 to-white text-center">
                <div class="w-12 h-12 rounded-xl bg-harvest-50 text-harvest-600 flex items-center justify-center text-sm font-black border border-harvest-100 mx-auto mb-3">EM</div>
                <h1 class="text-xl font-black text-gray-900">Who is entering records?</h1>
                <p class="text-sm text-gray-500 font-semibold mt-1">Select your name to continue.</p>
            </div>
            <div class="px-6 py-5">
        <form action="{{ route('email.login') }}" method="POST" class="officerOfTheDayNames flex flex-col gap-3" id="emailLoginForm">
            @csrf
            <select name="email_user" id="email_user" required class="h-11 px-3 rounded-xl border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                <option value="">Select user</option>
                @php
                    $officers = \App\Models\Officer::orderBy('name')->get();
                @endphp
                @foreach($officers as $officer)
                    <option value="{{ $officer->username ?? $officer->name }}">{{ $officer->name }}</option>
                @endforeach
            </select>
            <input type="password" name="email_password" id="email_password" placeholder="Password" required class="h-11 px-3 rounded-xl border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <button type="submit" class="h-10 rounded-xl bg-pcic-700 text-white text-sm font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Continue</button>
        </form>
            </div>
        </div>
                    @else
        <div class="channel-workspace gap-5 w-full">
            <div id="controlsPanel" class="channel-controls no-print">
                <div id="controlActions" class="record-tools bg-white rounded-2xl shadow-lg border border-gray-100/80 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-b from-pcic-50/60 to-white">
                    <h3 class="text-sm font-black text-gray-900">Filters &amp; tools</h3>
                    <p class="text-xs text-gray-500 font-semibold mt-0.5">Find and export encoded records</p>
                </div>
                <div class="px-5 py-4 flex flex-col gap-3">
	<div class="filter-container">
		<form action="{{ route('email-handler') }}" method="GET">
			<div class="date-filter-container border border-gray-200 bg-gray-50 rounded-lg p-3">
				<div class="flex flex-col gap-3">
					<label class="text-xs font-bold text-gray-700 mb-2">Filter Records By Date</label>

					<div class="grid grid-cols-1 md:grid-cols-2 gap-3">

						<div class="date-encoded-filter">
							<div class="flex items-center gap-2 mb-2">
							<input type="checkbox" id="use_date_encoded" name="use_date_encoded" value="1" {{ request('use_date_encoded') || (!request('use_date_received') && !request('date_received')) ? 'checked' : '' }} class="w-4 h-4 text-pcic-600 focus:ring-pcic-500 border-gray-300 rounded">
							<label for="use_date_encoded" class="text-xs font-medium text-gray-700">Date Encoded (when record was created)</label>
						</div>
							<input type="date" name="date_encoded" value="{{ request('date_encoded', now()->format('Y-m-d')) }}" class="h-10 px-3 rounded-lg border border-gray-300 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 bg-white outline-none text-sm shadow-sm w-full">
						</div>


						<div class="date-received-filter">
							<div class="flex items-center gap-2 mb-2">
							<input type="checkbox" id="use_date_received" name="use_date_received" value="1" {{ request('use_date_received') ? 'checked' : '' }} class="w-4 h-4 text-pcic-600 focus:ring-pcic-500 border-gray-300 rounded">
							<label for="use_date_received" class="text-xs font-medium text-gray-700">Date Received (when NL was received)</label>
						</div>
							<input type="date" name="date_received" value="{{ request('date_received', now()->format('Y-m-d')) }}" class="h-10 px-3 rounded-lg border border-gray-300 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 bg-white outline-none text-sm shadow-sm w-full">
						</div>
					</div>


					<div class="channel-date-help text-xs text-gray-500 bg-blue-50 border border-blue-200 rounded p-2 mt-2">
						<strong>How to use:</strong><br>
						• Check one or both date filters<br>
						• <strong>Date Encoded:</strong> Shows records created on specific date<br>
						• <strong>Date Received:</strong> Shows records received on specific date<br>
						• <strong>Both checked:</strong> Shows records matching both criteria
					</div>
				</div>
			</div>
			<div class="filter-actions-container border border-gray-200 rounded-lg p-3 bg-gray-50">
				<div class="flex gap-2">
					<button type="submit" class="h-10 px-4 rounded-lg bg-green-600 text-white text-xs font-semibold hover:bg-green-700 transition-colors cursor-pointer shadow-sm flex items-center justify-center">Filter Date</button>
					<a href="{{ route('email-handler') }}" class="h-10 px-4 rounded-lg bg-white text-gray-700 text-xs font-semibold hover:bg-gray-50 transition-colors cursor-pointer shadow-sm flex items-center justify-center">Clear Filters</a>
				</div>
			</div>
		</form>
	</div>
                    <button type="button" id="addRecordButton" aria-controls="addRecordPanel" aria-expanded="false" class="h-11 rounded-xl bg-pcic-700 text-white text-sm font-bold hover:bg-pcic-800 focus:outline-none focus:ring-2 focus:ring-pcic-500 focus:ring-offset-2 transition-colors cursor-pointer">Add Record</button>
                        @if($records->count() > 0)
                        <a href="{{ route('email.export-csv') }}" class="h-10 rounded-xl bg-white border border-gray-200 text-gray-700 text-sm font-bold hover:bg-gray-50 transition-colors cursor-pointer flex items-center justify-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Export CSV
                        </a>
                        @endif
                        <button type="button" class="downloadOldRecordsButton h-10 rounded-xl bg-white border border-gray-200 text-gray-700 text-sm font-bold hover:bg-gray-50 transition-colors cursor-pointer flex items-center justify-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Download Old Records to CSV
                        </button>
                </div>
            </div>

            <div id="addRecordPanel" class="hidden bg-white rounded-2xl shadow-lg border border-gray-100/80 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-b from-harvest-50/60 to-white flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-base font-black text-gray-900">Add an email record</h3>
                    <p class="text-xs text-gray-500 font-semibold mt-1">Enter the notice details. Your encoded records remain visible beside this form.</p>
                </div>
                <button type="button" id="returnToControlsButton" class="shrink-0 h-9 px-3 rounded-lg border border-gray-200 bg-white text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer">Back to controls</button>
            </div>
            <form action="{{ route('records') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-3 p-5" id="addRecordForm" data-async-record-form>
                @csrf
                <input type="hidden" name="source" value="Email">
                <label class="block text-xs font-bold text-gray-600" for="farmerName">Farmer name
                    <input type="text" id="farmerName" name="farmerName" required autocomplete="name" class="mt-1.5 h-10 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
                </label>
                <label class="block text-xs font-bold text-gray-600" for="province">Province
                    <select name="province" id="province" required class="mt-1.5 h-10 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                        <option value="">Select province</option>
                        <option value="Aurora">Aurora</option>
                        <option value="Nueva Ecija">Nueva Ecija</option>
                        <option value="Tarlac">Tarlac</option>
                    </select>
                </label>
                <label class="block text-xs font-bold text-gray-600" for="municipality">Municipality
                    <select name="municipality" id="municipality" required disabled class="mt-1.5 h-10 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-gray-50 uppercase">
                        <option value="">Select municipality</option>
                    </select>
                </label>
                <label class="block text-xs font-bold text-gray-600" for="barangay">Barangay
                    <select name="barangay" id="barangay" required disabled class="mt-1.5 h-10 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-gray-50 uppercase">
                        <option value="">Select barangay</option>
                    </select>
                </label>
                <input type="hidden" name="address" id="addRecordAddress">
                <label class="block text-xs font-bold text-gray-600" for="line">Line
                    <select name="line" id="line" required class="mt-1.5 h-10 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                        <option value="">Select line</option>
                        <option value="rice">Rice</option>
                        <option value="corn">Corn</option>
                        <option value="high-value">High-Value Crops</option>
                        <option value="clti">CLTI</option>
                        <option value="livestock">Livestock</option>
                        <option value="non-crop">Non-Crop</option>
                        <option value="fisheries">Fisheries</option>
                    </select>
                </label>
                <label class="block text-xs font-bold text-gray-600" for="program">Program
                    <select name="program" id="program" required class="mt-1.5 h-10 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                        <option value="">Select program</option>
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
                </label>
                <label class="block text-xs font-bold text-gray-600" for="date_occurrence">Date of occurrence
                    <input type="text" id="date_occurrence" name="date_occurrence" class="mt-1.5 h-10 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
                </label>
                <label class="block text-xs font-bold text-gray-600" for="date_received">Date received
                    <input type="date" id="date_received" name="date_received" value="{{ now()->format('Y-m-d') }}" class="mt-1.5 h-10 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
                </label>
                <label class="block text-xs font-bold text-gray-600" for="causeOfDamage">Cause of damage
                    <input type="text" id="causeOfDamage" name="causeOfDamage" required class="mt-1.5 h-10 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
                </label>
                <label class="block text-xs font-bold text-gray-600" for="modeOfPayment">Mode of payment
                    <select name="modeOfPayment" id="modeOfPayment" required class="mt-1.5 h-10 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                        <option value="">Select payment mode</option>
                        <option value="check">Check</option>
                        <option value="palawan">Palawan Pay</option>
                        <option value="gcash">GCash</option>
                        <option value="not_indicated">Not indicated</option>
                    </select>
                </label>
                <label class="block text-xs font-bold text-gray-600" for="remarks">Remarks / care of
                    <input type="text" id="remarks" name="remarks" class="mt-1.5 h-10 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
                </label>
                <label class="block text-xs font-bold text-gray-600" for="accounts">Email account
                    <input type="text" id="accounts" name="accounts" placeholder="Email address or username" class="mt-1.5 h-10 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
                </label>
                <label class="block text-xs font-bold text-gray-600" for="notice_images">Notice of loss / claim photos <span class="font-medium text-gray-400">(optional)</span>
                    <input type="file" id="notice_images" name="notice_images[]" accept="image/jpeg,image/png,image/webp" multiple class="mt-1.5 block w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-pcic-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-pcic-700 hover:file:bg-pcic-100">
                    <span class="mt-1 block text-xs font-medium text-gray-500">JPG, PNG, or WebP. Maximum 30 MB per photo.</span>
                </label>
                <button type="button" class="clear-add-notice-image-selection w-fit rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-bold text-gray-700 hover:bg-gray-50" hidden>Clear selected image</button>
                <label class="block text-xs font-bold text-gray-600" for="notice_pdfs">Supporting documents <span class="font-medium text-gray-400">(PDF, optional)</span>
                    <input type="file" id="notice_pdfs" name="notice_pdfs[]" accept="application/pdf,.pdf" multiple class="mt-1.5 block w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-pcic-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-pcic-700 hover:file:bg-pcic-100">
                    <span class="mt-1 block text-xs font-medium text-gray-500">PDF only. Maximum 30 MB per file.</span>
                </label>
                <button type="button" class="clear-add-notice-pdf-selection w-fit rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-bold text-gray-700 hover:bg-gray-50" hidden>Clear selected PDF</button>
                <div class="pt-2">
                    <button type="submit" class="h-11 w-full rounded-xl bg-pcic-700 text-sm font-bold text-white hover:bg-pcic-800 focus:outline-none focus:ring-2 focus:ring-pcic-500 focus:ring-offset-2 transition-colors cursor-pointer">Save email record</button>
                    <p class="mt-2 text-center text-xs text-gray-500">After saving, the record list updates without leaving this form.</p>
                </div>
            </form>
            </div>
            </div>

            <div id="recordsPanel" class="channel-records record-list bg-white rounded-2xl shadow-lg border border-gray-100/80 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-b from-pcic-50/60 to-white">
                    <h3 class="text-sm font-black text-gray-900">Records</h3>
                    <p class="text-xs text-gray-500 font-semibold mt-0.5">Your encoded records stay visible while you add a new one.</p>
                </div>
                <div class="p-4 overflow-x-auto">
                    <x-table :records="$records" :showDelete="false" :showCheckbox="false" :showSortableHeaders="false" :hideSourceColumn="true" :hideProvinceColumn="true" />
                    @if(method_exists($records, 'links'))
                        <div class="no-print channel-pagination">
                            <div id="pagination-container">
                                @if ($records->onFirstPage())
                                    <span class="channel-page-disabled">Previous</span>
                                @else
                                    <a href="{{ $records->appends(request()->query())->previousPageUrl() }}" class="channel-page-link">Previous</a>
                                @endif

                                <span class="channel-page-current">
                                    Page {{ $records->currentPage() }} of {{ $records->lastPage() }}
                                </span>

                                @if ($records->hasMorePages())
                                    <a href="{{ $records->appends(request()->query())->nextPageUrl() }}" class="channel-page-link">Next</a>
                                @else
                                    <span class="channel-page-disabled">Next</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    <dialog class="editRecordDialog rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(640px,calc(100vw-2rem))]" id="recordEditDialog">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Edit Record</h3>
        </div>
        <form class="editRecordform grid grid-cols-[auto_1fr] gap-x-4 gap-y-3 px-5 py-4 items-center" id="recordEditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="remove_notice_image" value="0">
            <input type="hidden" name="remove_notice_pdf" value="0">
            <input type="hidden" name="source" value="Email" id="editRecordSourceEmail">
            <label for="farmerName" class="text-xs font-bold text-gray-600 text-right">Farmer Name:</label>
            <input type="text" id="farmerName" name="farmerName" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <label for="province" class="text-xs font-bold text-gray-600 text-right">Province:</label>
            <select name="province" id="editProvince" required class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                <option value="">Select Province</option>
                <option value="Aurora">Aurora</option>
                <option value="Nueva Ecija">Nueva Ecija</option>
                <option value="Tarlac">Tarlac</option>
            </select>
            <label for="municipality" class="text-xs font-bold text-gray-600 text-right">Municipality:</label>
            <select name="municipality" id="editMunicipality" required disabled class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-gray-50 uppercase">
                <option value="">Select Municipality</option>
            </select>
            <label for="barangay" class="text-xs font-bold text-gray-600 text-right">Barangay:</label>
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
            <label for="date_occurrence" class="text-xs font-bold text-gray-600 text-right">Date occurrence:</label>
            <input type="text" id="date_occurrence" name="date_occurrence" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <label for="date_received" class="text-xs font-bold text-gray-600 text-right">Date received:</label>
            <input type="date" id="date_received" name="date_received" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <label for="causeOfDamage" class="text-xs font-bold text-gray-600 text-right">Cause of Damage:</label>
            <input type="text" id="causeOfDamage" name="causeOfDamage" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <label for="modeOfPayment" class="text-xs font-bold text-gray-600 text-right">Mode of payment:</label>
            <select name="modeOfPayment" id="modeOfPayment" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                <option value="">Select Mode of payment</option>
                <option value="check">Check</option>
                <option value="palawan">Palawan Pay</option>
                <option value="gcash">GCash</option>
                <option value="not_indicated">Not indicated</option>
            </select>
            <label for="remarks" class="text-xs font-bold text-gray-600 text-right">Remarks - Care of:</label>
            <input type="text" id="remarks" name="remarks" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full ">
            <label for="accounts" class="text-xs font-bold text-gray-600 text-right">Account (email):</label>
            <input type="text" id="accounts" name="accounts" placeholder="Email address or username" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full ">
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
            <div class="flex gap-2 pt-1">
                <button type="submit" class="h-9 px-4 rounded-lg bg-pcic-700 text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Update Record</button>
                <button type="button" class="closeEditRecordDialog h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Close</button>
            </div>
        </form>
    </dialog>
    @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
const editRecordDialog = document.getElementById('recordEditDialog');
const closeEditRecordModal = document.querySelector('.closeEditRecordDialog');
const editRecordForm = document.getElementById('recordEditForm');

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('editButton') || e.target.closest('.editButton')) {
        const button = e.target.classList.contains('editButton') ? e.target : e.target.closest('.editButton');

        if (!editRecordDialog || !editRecordForm) {
            console.error('Edit dialog or form not found');
            return;
        }

        try {
            const recordId = button.getAttribute('data-id');
            const farmerName = button.getAttribute('data-farmer-name');
            const province = button.getAttribute('data-province');
            const municipality = button.getAttribute('data-municipality');
            const barangay = button.getAttribute('data-barangay');
            const address = button.getAttribute('data-address');
            const program = button.getAttribute('data-program');
            const line = button.getAttribute('data-line');
            const causeOfDamage = button.getAttribute('data-cause-of-damage');
            const modeOfPayment = button.getAttribute('data-mode-of-payment');
            const accounts = button.getAttribute('data-accounts');
            const fbPageUrl = button.getAttribute('data-fb-page-url');
            const dateOccurrence = button.getAttribute('data-date-occurrence');
            const dateReceived = button.getAttribute('data-date-received');
            const remarks = button.getAttribute('data-remarks');
            const source = button.getAttribute('data-source');
            const transmittalNumber = button.getAttribute('data-transmittal-number');
            const adminTransmittalNumber = button.getAttribute('data-admin-transmittal-number');

            const farmerNameField = editRecordForm.querySelector('#farmerName');
            const editProvinceField = editRecordForm.querySelector('#editProvince');
            const editMunicipalityField = editRecordForm.querySelector('#editMunicipality');
            const editBarangayField = editRecordForm.querySelector('#editBarangay');
            const addressField = editRecordForm.querySelector('#editRecordAddress');
            const programField = editRecordForm.querySelector('#program');
            const lineField = editRecordForm.querySelector('#line');
            const causeOfDamageField = editRecordForm.querySelector('#causeOfDamage');
            const modeOfPaymentField = editRecordForm.querySelector('#modeOfPayment');
            const accountsField = editRecordForm.querySelector('#accounts');
            const fbPageUrlField = editRecordForm.querySelector('#facebook_page_url');
            const dateOccurrenceField = editRecordForm.querySelector('#date_occurrence');
            const dateReceivedField = editRecordForm.querySelector('#date_received');
            const remarksField = editRecordForm.querySelector('#remarks');
            const transmittalNumberField = editRecordForm.querySelector('#transmittal_number');
            const adminTransmittalNumberField = editRecordForm.querySelector('#admin_transmittal_number');
            const sourceField = editRecordForm.querySelector('#source');

            if (farmerNameField) farmerNameField.value = farmerName || '';
            if (editProvinceField) editProvinceField.value = province || '';
            if (editMunicipalityField) editMunicipalityField.value = municipality || '';
            if (editBarangayField) editBarangayField.value = barangay || '';
            if (addressField) addressField.value = address || '';
            if (programField) programField.value = program || '';
            if (lineField) lineField.value = line || '';
            if (causeOfDamageField) causeOfDamageField.value = causeOfDamage || '';
            if (modeOfPaymentField) modeOfPaymentField.value = modeOfPayment || '';
            if (accountsField) accountsField.value = accounts || '';
            if (fbPageUrlField) fbPageUrlField.value = fbPageUrl || '';
            if (dateOccurrenceField) dateOccurrenceField.value = dateOccurrence || '';
            if (dateReceivedField) dateReceivedField.value = dateReceived || '';
            if (remarksField) remarksField.value = remarks || '';
            if (transmittalNumberField) transmittalNumberField.value = transmittalNumber || '';
            if (adminTransmittalNumberField) adminTransmittalNumberField.value = adminTransmittalNumber || '';
            if (sourceField) sourceField.value = source || '';

            editRecordForm.action = '/records/' + recordId;

            if (editProvinceField && editMunicipalityField && editBarangayField) {
                if (editProvinceField.value) {
                    editMunicipalityField.disabled = false;
                    const event = new Event('change');
                    editProvinceField.dispatchEvent(event);

                    if (editMunicipalityField.value) {
                        editBarangayField.disabled = false;
                        const municipalityEvent = new Event('change');
                        editMunicipalityField.dispatchEvent(municipalityEvent);
                    }
                }
            }

            editRecordDialog.showModal();
        } catch (error) {
            console.error('Error opening edit dialog:', error);
        }
    }
});

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
                'Accept': 'application/json'
            }
        })
        .then(function(response) {
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
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
            showModalMessage('Error updating record. Please try again.', 'error');
        })
        .finally(function() {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = 'Update Record';
            }
        });
    });
}

function clearFilter(filterName) {
    const form = document.querySelector('form[action="{{ route('email-handler') }}"]');
    const input = form.querySelector(`input[name="${filterName}"]`);
    if (input) {
        input.value = '';
        form.submit();
    }
}

<script>
document.addEventListener('DOMContentLoaded', function() {

    const enableDateReceivedToggle = document.getElementById('enable_date_received');
    const dateReceivedInput = document.querySelector('input[name="date_received"]');
    const dateReceivedContainer = document.querySelector('.date-received-container');

    if (enableDateReceivedToggle && dateReceivedInput) {
        function updateEnableDateReceivedToggle() {
            if (enableDateReceivedToggle.checked) {
                dateReceivedInput.disabled = false;
                dateReceivedInput.style.opacity = '1';
                dateReceivedInput.style.backgroundColor = 'white';
                dateReceivedInput.style.pointerEvents = 'auto';
                if (dateReceivedContainer) {
                    dateReceivedContainer.style.opacity = '1';
                }
            } else {
                dateReceivedInput.disabled = true;
                dateReceivedInput.style.opacity = '0.5';
                dateReceivedInput.style.backgroundColor = '#f9fafb';
                dateReceivedInput.style.pointerEvents = 'none';
                if (dateReceivedContainer) {
                    dateReceivedContainer.style.opacity = '0.6';
                }
            }
        }

        enableDateReceivedToggle.addEventListener('change', updateEnableDateReceivedToggle);
        updateEnableDateReceivedToggle();
    }

    const dateEncodedToggle = document.getElementById('enable_date_encoded');
    const dateEncodedInput = document.querySelector('input[name="date_encoded"]');
    const dateEncodedContainer = document.querySelector('.date-encoded-container');

    if (dateEncodedToggle && dateEncodedInput) {
        function updateDateEncodedToggle() {
            if (dateEncodedToggle.checked) {
                dateEncodedInput.disabled = false;
                dateEncodedInput.style.opacity = '1';
                dateEncodedInput.style.backgroundColor = 'white';
                dateEncodedInput.style.pointerEvents = 'auto';
                if (dateEncodedContainer) {
                    dateEncodedContainer.style.opacity = '1';
                }
            } else {
                dateEncodedInput.disabled = true;
                dateEncodedInput.style.opacity = '0.5';
                dateEncodedInput.style.backgroundColor = '#f9fafb';
                dateEncodedInput.style.pointerEvents = 'none';
                if (dateEncodedContainer) {
                    dateEncodedContainer.style.opacity = '0.6';
                }
            }
        }

        dateEncodedToggle.addEventListener('change', updateDateEncodedToggle);
        updateDateEncodedToggle();
    }
});
</script>

<script>
(function() {
    var addRecordPanel = document.getElementById('addRecordPanel');
    var controlActions = document.getElementById('controlActions');
    var addRecordButton = document.getElementById('addRecordButton');
    var returnToControlsButton = document.getElementById('returnToControlsButton');

    function showAddRecordForm() {
        if (!addRecordPanel || !controlActions) {
            return;
        }

        controlActions.hidden = true;
        controlActions.classList.add('hidden');
        addRecordPanel.hidden = false;
        addRecordPanel.classList.remove('hidden');
        addRecordButton?.setAttribute('aria-expanded', 'true');
        addRecordPanel.querySelector('#farmerName')?.focus();
    }

    function showControls() {
        if (!addRecordPanel || !controlActions) {
            return;
        }

        addRecordPanel.hidden = true;
        addRecordPanel.classList.add('hidden');
        controlActions.hidden = false;
        controlActions.classList.remove('hidden');
        addRecordButton?.setAttribute('aria-expanded', 'false');
        addRecordButton?.focus();
    }

    addRecordButton?.addEventListener('click', showAddRecordForm);
    returnToControlsButton?.addEventListener('click', showControls);

    function populateFormWithLatestRecord() {
        fetch('{{ route('records.latest') }}?source=Email')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.record) {
                    const form = addRecordPanel ? addRecordPanel.querySelector('form') : null;
                    if (form) {
                        const provinceField = form.querySelector('#province');
                        const shouldPrefillLocation = provinceField && !provinceField.value && data.record.province;
                        if (shouldPrefillLocation) {
                            provinceField.value = data.record.province;
                            provinceField.dispatchEvent(new Event('change'));
                        }
                        if (form.querySelector('#modeOfPayment') && !form.querySelector('#modeOfPayment').value) form.querySelector('#modeOfPayment').value = data.record.modeOfPayment || '';
                        if (form.querySelector('#date_received') && !form.querySelector('#date_received').value) form.querySelector('#date_received').value = data.record.date_received || '';
                        if (form.querySelector('#accounts') && !form.querySelector('#accounts').value) form.querySelector('#accounts').value = data.record.accounts || '';

                        setTimeout(() => {
                            if (shouldPrefillLocation && form.querySelector('#municipality') && data.record.municipality) {
                                form.querySelector('#municipality').value = data.record.municipality;
                                form.querySelector('#municipality').dispatchEvent(new Event('change'));
                            }
                            setTimeout(() => {
                                if (shouldPrefillLocation && form.querySelector('#barangay') && data.record.barangay) {
                                    form.querySelector('#barangay').value = data.record.barangay;
                                }
                            }, 100);
                        }, 100);
                    }
                }
            })
            .catch(error => console.error('Error fetching latest record:', error));
    }

    populateFormWithLatestRecord();

    function saveLocationValues() {
        var province = document.getElementById('province');
        var municipality = document.getElementById('municipality');
        var barangay = document.getElementById('barangay');

        if (province && municipality && barangay) {
            localStorage.setItem('email_province', province.value);
            localStorage.setItem('email_municipality', municipality.value);
            localStorage.setItem('email_barangay', barangay.value);
        }
    }

    function restoreLocationValues() {
        var province = document.getElementById('province');
        var municipality = document.getElementById('municipality');
        var barangay = document.getElementById('barangay');

        if (province && municipality && barangay) {
            var savedProvince = localStorage.getItem('email_province');
            var savedMunicipality = localStorage.getItem('email_municipality');
            var savedBarangay = localStorage.getItem('email_barangay');

            if (savedProvince) {
                province.value = savedProvince;
                municipality.disabled = false;
                municipality.classList.remove('bg-gray-50');
                municipality.classList.add('bg-white');

                var event = new Event('change');
                province.dispatchEvent(event);

                setTimeout(function() {
                    if (savedMunicipality) {
                        municipality.value = savedMunicipality;
                        barangay.disabled = false;
                        barangay.classList.remove('bg-gray-50');
                        barangay.classList.add('bg-white');

                        var municipalityEvent = new Event('change');
                        municipality.dispatchEvent(municipalityEvent);

                        setTimeout(function() {
                            if (savedBarangay) {
                                barangay.value = savedBarangay;
                            }
                        }, 100);
                    }
                }, 100);
            }
        }
    }

    function clearLocationValues() {
        localStorage.removeItem('email_province');
        localStorage.removeItem('email_municipality');
        localStorage.removeItem('email_barangay');
    }

    var addRecordForm = document.getElementById('addRecordForm');
    if (addRecordForm) {
        addRecordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var provinceField = addRecordForm.querySelector('#province');
            var municipalityField = addRecordForm.querySelector('#municipality');
            var barangayField = addRecordForm.querySelector('#barangay');
            var addressField = addRecordForm.querySelector('#addRecordAddress');
            if (provinceField && municipalityField && barangayField && addressField) {
                addressField.value = [barangayField.value, municipalityField.value, provinceField.value]
                    .filter(Boolean)
                    .join(', ');
            }
            saveLocationValues();

            var dateReceivedValue = addRecordForm.querySelector('#date_received') ? addRecordForm.querySelector('#date_received').value : '';
            var modeOfPaymentValue = addRecordForm.querySelector('#modeOfPayment') ? addRecordForm.querySelector('#modeOfPayment').value : '';
            var provinceValue = addRecordForm.querySelector('#province') ? addRecordForm.querySelector('#province').value : '';
            var municipalityValue = addRecordForm.querySelector('#municipality') ? addRecordForm.querySelector('#municipality').value : '';
            var barangayValue = addRecordForm.querySelector('#barangay') ? addRecordForm.querySelector('#barangay').value : '';
            var accountsValue = addRecordForm.querySelector('#accounts') ? addRecordForm.querySelector('#accounts').value : '';

            var formData = new FormData(addRecordForm);
            var submitBtn = addRecordForm.querySelector('button[type="submit"]');

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Adding...';
            }

            fetch(addRecordForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showModalMessage(data.message, 'success');
                    if (addRecordForm.querySelector('#date_received')) addRecordForm.querySelector('#date_received').value = dateReceivedValue;
                    if (addRecordForm.querySelector('#modeOfPayment')) addRecordForm.querySelector('#modeOfPayment').value = modeOfPaymentValue;
                    if (addRecordForm.querySelector('#province')) addRecordForm.querySelector('#province').value = provinceValue;
                    if (addRecordForm.querySelector('#municipality')) addRecordForm.querySelector('#municipality').value = municipalityValue;
                    if (addRecordForm.querySelector('#barangay')) addRecordForm.querySelector('#barangay').value = barangayValue;
                    if (addRecordForm.querySelector('#accounts')) addRecordForm.querySelector('#accounts').value = accountsValue;

                    if (addRecordForm.querySelector('#farmerName')) addRecordForm.querySelector('#farmerName').value = '';
                    if (addRecordForm.querySelector('#line')) addRecordForm.querySelector('#line').value = '';
                    if (addRecordForm.querySelector('#program')) addRecordForm.querySelector('#program').value = '';
                    if (addRecordForm.querySelector('#causeOfDamage')) addRecordForm.querySelector('#causeOfDamage').value = '';
                    if (addRecordForm.querySelector('#date_occurrence')) addRecordForm.querySelector('#date_occurrence').value = '';
                    if (addRecordForm.querySelector('#remarks')) addRecordForm.querySelector('#remarks').value = '';
                    if (addRecordForm.querySelector('#controlNumber')) addRecordForm.querySelector('#controlNumber').value = '';
                    if (addRecordForm.querySelector('#notice_images')) addRecordForm.querySelector('#notice_images').value = '';
                    if (addRecordForm.querySelector('#notice_pdfs')) addRecordForm.querySelector('#notice_pdfs').value = '';
                    addRecordForm.querySelector('.clear-add-notice-image-selection')?.setAttribute('hidden', '');
                    addRecordForm.querySelector('.clear-add-notice-pdf-selection')?.setAttribute('hidden', '');

                    fetch(window.location.href, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Could not refresh records. HTTP ' + response.status);
                            }
                            return response.text();
                        })
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newTable = doc.querySelector('#recordsPanel');
                            const currentTable = document.querySelector('#recordsPanel');
                            if (!newTable || !currentTable) {
                                throw new Error('Could not find the updated records panel.');
                            }
                            currentTable.innerHTML = newTable.innerHTML;
                        })
                        .catch(error => {
                            console.error('Record saved but records panel refresh failed:', error);
                            showModalMessage('Record saved, but the list could not refresh. Reload the page to view it.', 'warning');
                        });
                } else {
                    var uploadError = Object.values(data.errors || {}).flat()[0] || null;
                    showModalMessage(uploadError || data.message || 'Error adding record', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showModalMessage('Error adding record', 'error');
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Add Record';
                }
            });
        });
    }

})();

</script>

<script>
window.addEventListener('beforeunload', function(e) {
    navigator.sendBeacon('{{ route('email.logout') }}', new FormData());
});

document.addEventListener('visibilitychange', function() {
    if (document.visibilityState === 'hidden') {
        setTimeout(function() {
            if (document.visibilityState === 'hidden') {
                navigator.sendBeacon('{{ route('email.logout') }}', new FormData());
            }
        }, 30000);
    }
});
</script>
@endpush
