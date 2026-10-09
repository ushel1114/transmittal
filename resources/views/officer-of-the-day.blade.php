@extends('layout.layout')

@section('title', 'Officer of the day')

@section('page-styles')
<style>
html,
body {
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

.channel-add-record-form {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.5rem 0.75rem;
    padding: 0.75rem;
}

.channel-add-record-form > label {
    display: block;
    min-width: 0;
    color: #4b5563;
    font-size: 10px;
    font-weight: 600;
    line-height: 1rem;
}

.channel-add-record-form > label > input,
.channel-add-record-form > label > select {
    box-sizing: border-box;
    width: 100%;
    height: 2.125rem;
    margin-top: 0.25rem;
    padding: 0 0.625rem;
    font-size: 0.75rem;
}

.channel-add-record-form > div {
    grid-column: 1 / -1;
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

.channel-records:has(.empty-state) .table-wrapper {
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

@media (min-width: 768px) {
    .channel-workspace {
        grid-template-columns: minmax(300px, 360px) minmax(0, 1fr);
        grid-template-rows: minmax(0, 1fr);
    }
}
</style>
@endsection

@section('content')
    <div class="min-h-screen flex flex-col bg-gradient-to-br from-pcic-100 via-white to-pcic-100 {{ $officerName ? 'channel-page-shell' : '' }}">

        <div class="odHeader sticky top-0 z-20 w-full bg-white/90 backdrop-blur-md border-b border-gray-200/60 {{ $officerName ? 'channel-fixed-header' : '' }}">
            <div class="max-w-6xl mx-auto h-full px-4 py-3 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="flex flex-col">
                        <h3 class="text-base font-black text-gray-900">Officer of the Day</h3>
                        <p class="text-xs text-gray-500 font-semibold">NL Entry Module</p>
                    </div>
                </div>
                @if($officerName)
                <div class="flex items-center gap-3">
                    <div class="flex flex-col items-end">
                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">OD</div>
                        <div class="text-xs font-black text-gray-900">{{ $officerName }}</div>
                    </div>
                    <form action="{{ route('officer.logout') }}" method="POST">
                        @csrf
                        <button class="logoutButton h-8 px-3 rounded-lg border border-gray-200 bg-white text-xs font-bold text-gray-600 hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-colors cursor-pointer" type="submit">Logout</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        <div class="contentContainer {{ $officerName ? 'channel-page-content' : '' }}">
    @if(!$officerName)
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg border border-gray-100/80 overflow-hidden">
            <div class="px-6 pt-6 pb-4 border-b border-gray-100 bg-gradient-to-b from-pcic-50/60 to-white text-center">
                <div class="w-12 h-12 rounded-xl bg-pcic-100 text-pcic-700 flex items-center justify-center text-sm font-black border border-pcic-200 mx-auto mb-3">OD</div>
                <h1 class="text-xl font-black text-gray-900">Officer of the Day</h1>
                <p class="text-sm text-gray-500 font-semibold mt-1">Select your name to continue.</p>
            </div>
            <div class="px-6 py-5">
        <form action="{{ route('officer.login') }}" method="POST" class="officerOfTheDayNames flex flex-col gap-3">
            @csrf
            <select id="officerName" name="officerName" required
                class="h-11 px-3 rounded-xl border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                <option value="">Select Officer of the day</option>
                @php
                    $officers = \App\Models\Officer::orderBy('name')->get();
                @endphp
                @foreach($officers as $officer)
                    <option value="{{ $officer->username ?? $officer->name }}">{{ $officer->name }}</option>
                @endforeach
            </select>
            <input type="password" name="officer_password" id="officer_password" placeholder="Password" required class="h-11 px-3 rounded-xl border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <button type="submit" class="h-10 rounded-xl bg-pcic-700 text-white text-sm font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Enter</button>
        </form>
            </div>
        </div>
    @else
        <div class="channel-workspace gap-5 w-full">
            <div class="channel-controls no-print bg-white rounded-2xl shadow-lg border border-gray-100/80 overflow-hidden">
                <div id="controlActions" class="flex flex-col min-h-0 overflow-y-auto">
                    <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-b from-pcic-50/60 to-white">
                        <h3 class="text-sm font-black text-gray-900">Filters &amp; tools</h3>
                        <p class="text-xs text-gray-500 font-semibold mt-0.5">Filter and manage encoded records</p>
                    </div>
                    <div class="od-session-body px-5 py-4 flex flex-col gap-3">
	<div class="filter-container">
		<form action="{{ route('officer-of-the-day') }}" method="GET">
						<div class="date-received-container border border-gray-200 bg-gray-50 rounded-lg p-3">
				<div class="flex flex-col gap-2">
					<label class="text-xs font-bold text-gray-700 mb-1">Date Received</label>
					<div class="flex items-center gap-2">
						<input type="date" name="created_at" value="{{ request('created_at', now()->format('Y-m-d')) }}" class="h-10 px-3 rounded-lg border border-gray-300 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 bg-white outline-none text-sm shadow-sm w-full">
					</div>
				</div>
			</div>
			<div class="filter-actions-container border border-gray-200 rounded-lg p-3 bg-gray-50">
				<div class="flex gap-2">
					<button type="submit" class="h-10 px-4 rounded-lg bg-green-600 text-white text-xs font-semibold hover:bg-green-700 transition-colors cursor-pointer shadow-sm flex items-center justify-center">Filter Date</button>
					<a href="{{ route('officer-of-the-day') }}" class="h-10 px-4 rounded-lg bg-white text-gray-700 text-xs font-semibold hover:bg-gray-50 transition-colors cursor-pointer shadow-sm flex items-center justify-center">Clear Filters</a>
				</div>
			</div>
		</form>
	</div>
                    @if($officerApproved)
                        <div class="px-3 py-2.5 rounded-lg bg-green-50 border border-green-200 text-green-800 text-xs font-semibold">Your login is approved. You may add records.</div>
                        <button type="button" id="addRecordButton" aria-controls="addRecordPanel" aria-expanded="false" class="addRecordButton h-10 rounded-xl bg-green-600 text-white text-sm font-bold hover:bg-green-700 transition-colors cursor-pointer">Add record</button>
                        @if($records->count() > 0)
                        <a href="{{ route('officer.export-csv') }}" class="h-10 rounded-xl bg-white border border-gray-200 text-gray-700 text-sm font-bold hover:bg-gray-50 transition-colors cursor-pointer flex items-center justify-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Export CSV
                        </a>
                        @endif
                        <button type="button" class="downloadOldRecordsButton h-10 rounded-xl bg-white border border-gray-200 text-gray-700 text-sm font-bold hover:bg-gray-50 transition-colors cursor-pointer flex items-center justify-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Download Old Records to CSV
                        </button>
                    @else
                        <div class="px-3 py-2.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold">Your login is pending admin approval. You cannot add records until it is approved.</div>
                    @endif

                    @if($records->count() > 0)
                            <form id="submitTransmittalForm" action="{{ route('records.submit-transmittal') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="source" value="OD">
                                <input type="hidden" name="custom_transmittal_suffix" id="customTransmittalSuffix">
                                <button type="button" id="submitTransmittalBtn" class="h-10 rounded-xl bg-harvest-500 text-white text-sm font-bold hover:bg-harvest-600 transition-colors cursor-pointer w-full">Submit Transmittal</button>
                            </form>
                    @endif
                    </div>
                </div>
                @if($officerApproved)
                    <div id="addRecordPanel" class="hidden bg-white overflow-y-auto" hidden>
                        <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-b from-pcic-50/60 to-white flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-sm font-black text-gray-900">Add a record</h3>
                                <p class="text-xs text-gray-500 font-semibold mt-0.5">Enter the notice details.</p>
                            </div>
                            <button type="button" id="returnToControlsButton" class="shrink-0 h-9 px-3 rounded-lg border border-gray-200 bg-white text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer">Back to controls</button>
                        </div>
                        <form action="{{ route('records') }}" method="POST" enctype="multipart/form-data" class="channel-add-record-form" id="addRecordForm">
                            @csrf
                            <input type="hidden" name="source" value="OD">
                            <label for="farmerName">Farmer name
                                <input type="text" id="farmerName" name="farmerName" required autocomplete="name" placeholder="Farmer name" class="rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none">
                            </label>
                            <label for="province">Province
                                <select name="province" id="province" required class="rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none bg-white uppercase">
                                    <option value="">Select province</option>
                                    <option value="Aurora">Aurora</option>
                                    <option value="Nueva Ecija">Nueva Ecija</option>
                                    <option value="Tarlac">Tarlac</option>
                                </select>
                            </label>
                            <label for="municipality">Municipality
                                <select name="municipality" id="municipality" required disabled class="rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none bg-gray-50 uppercase">
                                    <option value="">Select municipality</option>
                                </select>
                            </label>
                            <label for="barangay">Barangay
                                <select name="barangay" id="barangay" required disabled class="rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none bg-gray-50 uppercase">
                                    <option value="">Select barangay</option>
                                </select>
                            </label>
                            <input type="hidden" name="address" id="addRecordAddress">
                            <label for="line">Line
                                <select name="line" id="line" required class="rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none bg-white uppercase">
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
                            <label for="program">Program
                                <select name="program" id="program" required class="rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none bg-white uppercase">
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
                                    <option value="CFITF-CIP">CFITF-CIP</option>
                                </select>
                            </label>
                            <label for="date_occurrence">Date of occurrence
                                <input type="text" id="date_occurrence" name="date_occurrence" placeholder="Date of occurrence" class="rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none">
                            </label>
                            <label for="date_received">Date received
                                <input type="date" id="date_received" name="date_received" value="{{ now()->format('Y-m-d') }}" class="rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none">
                            </label>
                            <label for="causeOfDamage">Cause of damage
                                <input type="text" id="causeOfDamage" name="causeOfDamage" required placeholder="Cause of damage" class="rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none">
                            </label>
                            <label for="modeOfPayment">Mode of payment
                                <select name="modeOfPayment" id="modeOfPayment" required class="rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none bg-white uppercase">
                                    <option value="">Select payment mode</option>
                                    <option value="check">Check</option>
                                    <option value="palawan">Palawan Pay</option>
                                    <option value="gcash">GCash</option>
                                    <option value="not_indicated">Not indicated</option>
                                </select>
                            </label>
                            <label for="remarks">Remarks / care of
                                <input type="text" id="remarks" name="remarks" placeholder="Remarks / care of" class="rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none">
                            </label>
                            <label for="controlNumber">Control number
                                <input type="text" id="controlNumber" name="control_number" placeholder="Control number" class="rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none">
                            </label>
                            <div class="flex gap-2 pt-1">
                                <button type="submit" class="h-9 px-4 rounded-lg bg-pcic-700 text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Add record</button>
                                <button type="button" id="cancelAddRecordButton" class="h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Cancel</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <div class="channel-records bg-white rounded-2xl shadow-lg border border-gray-100/80 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-b from-pcic-50/60 to-white">
                    <h3 class="text-sm font-black text-gray-900">Records</h3>
                    <p class="text-xs text-gray-500 font-semibold mt-0.5">Latest encoded NLs</p>
                </div>
                <div class="p-4 overflow-x-auto">
                    <x-table :records="$records" :showDelete="false" :showCheckbox="false" :showSortableHeaders="false" :hideAccountsColumn="true" :hideSourceColumn="true" :hideProvinceColumn="true" :useDateEncodedAsDateReceived="false" :showFilters="false" />
                    @if(method_exists($records, 'links'))
                        <div class="channel-pagination no-print" style="margin: 10px 0; text-align: center;">
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
                    @endif
                </div>
            </div>
        </div>

    <dialog id="transmittalDialog" class="rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(400px,calc(100vw-2rem))]">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Submit Transmittal</h3>
        </div>
        <div class="px-5 py-4">
            <div class="grid grid-cols-[auto_1fr] gap-x-4 gap-y-3 items-center">
                <span class="text-xs font-bold text-gray-600 text-right">Prefix:</span>
                <input type="text" id="transmittalPrefix" readonly class="h-9 px-3 rounded-lg bg-gray-100 border border-gray-200 text-sm font-bold text-gray-700 w-full">
                <span class="text-xs font-bold text-gray-600 text-right">Suffix:</span>
                <input type="number" id="transmittalSuffix" min="1" max="999" maxlength="3" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-harvest-500 focus:ring-2 focus:ring-harvest-100 outline-none text-sm font-bold w-full">
            </div>
            <div class="flex gap-2 justify-end mt-4">
                <button type="button" id="cancelTransmittalBtn" class="h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Cancel</button>
                <button type="button" id="confirmTransmittalBtn" class="h-9 px-4 rounded-lg bg-harvest-500 text-white text-xs font-bold hover:bg-harvest-600 transition-colors cursor-pointer">Submit</button>
            </div>
        </div>
    </dialog>

    <script>
        function selectLatestLocation(select, value) {
            const option = Array.from(select.options).find(option =>
                option.value.trim().toLocaleUpperCase() === String(value).trim().toLocaleUpperCase()
            );

            if (option) {
                select.value = option.value;
            }
        }

        function populateFormWithLatestRecord() {
            fetch('{{ route('records.latest') }}?source=OD')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.record) {
                        const form = document.querySelector('#addRecordPanel form');
                        if (form) {
                            if (form.querySelector('#farmerName')) form.querySelector('#farmerName').value = '';
                            if (form.querySelector('#line')) form.querySelector('#line').value = '';
                            if (form.querySelector('#program')) form.querySelector('#program').value = '';
                            if (form.querySelector('#causeOfDamage')) form.querySelector('#causeOfDamage').value = '';
                            if (form.querySelector('#date_occurrence')) form.querySelector('#date_occurrence').value = '';
                            if (form.querySelector('#remarks')) form.querySelector('#remarks').value = '';
                            if (form.querySelector('#controlNumber')) form.querySelector('#controlNumber').value = '';

                            if (form.querySelector('#province')) {
                                const provinceField = form.querySelector('#province');
                                selectLatestLocation(provinceField, data.record.province || '');
                                provinceField.dispatchEvent(new Event('change'));
                            }
                            if (form.querySelector('#modeOfPayment')) form.querySelector('#modeOfPayment').value = data.record.modeOfPayment || '';
                            if (form.querySelector('#date_received')) form.querySelector('#date_received').value = data.record.date_received || '';
                            if (form.querySelector('#controlNumber')) form.querySelector('#controlNumber').value = data.record.control_number || '';

                            setTimeout(() => {
                                if (form.querySelector('#municipality') && data.record.municipality) {
                                    const municipalityField = form.querySelector('#municipality');
                                    selectLatestLocation(municipalityField, data.record.municipality);
                                    municipalityField.dispatchEvent(new Event('change'));
                                }
                                setTimeout(() => {
                                    if (form.querySelector('#barangay') && data.record.barangay) {
                                        selectLatestLocation(form.querySelector('#barangay'), data.record.barangay);
                                    }
                                }, 100);
                            }, 100);
                        }
                    }
                })
                .catch(error => console.error('Error fetching latest record:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.getElementById('submitTransmittalBtn');
            const dialog = document.getElementById('transmittalDialog');
            const prefixInput = document.getElementById('transmittalPrefix');
            const suffixInput = document.getElementById('transmittalSuffix');
            const cancelBtn = document.getElementById('cancelTransmittalBtn');
            const confirmBtn = document.getElementById('confirmTransmittalBtn');
            const form = document.getElementById('submitTransmittalForm');
            const suffixHidden = document.getElementById('customTransmittalSuffix');
            const addRecordBtn = document.querySelector('.addRecordButton');

            if (addRecordBtn) {
                addRecordBtn.addEventListener('click', populateFormWithLatestRecord);
            }

            const addRecordForm = document.getElementById('addRecordForm');
            if (addRecordForm) {
                addRecordForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const provinceField = addRecordForm.querySelector('#province');
                    const municipalityField = addRecordForm.querySelector('#municipality');
                    const barangayField = addRecordForm.querySelector('#barangay');
                    const addressField = addRecordForm.querySelector('#addRecordAddress');
                    if (addressField) {
                        addressField.value = [barangayField?.value, municipalityField?.value, provinceField?.value]
                            .filter(Boolean)
                            .join(', ');
                    }

                    const dateReceivedValue = addRecordForm.querySelector('#date_received') ? addRecordForm.querySelector('#date_received').value : '';
                    const modeOfPaymentValue = addRecordForm.querySelector('#modeOfPayment') ? addRecordForm.querySelector('#modeOfPayment').value : '';
                    const provinceValue = addRecordForm.querySelector('#province') ? addRecordForm.querySelector('#province').value : '';
                    const municipalityValue = addRecordForm.querySelector('#municipality') ? addRecordForm.querySelector('#municipality').value : '';
                    const barangayValue = addRecordForm.querySelector('#barangay') ? addRecordForm.querySelector('#barangay').value : '';
                    const controlNumberValue = addRecordForm.querySelector('#controlNumber') ? addRecordForm.querySelector('#controlNumber').value : '';

                    const formData = new FormData(addRecordForm);
                    const submitBtn = addRecordForm.querySelector('button[type="submit"]');

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
                            if (addRecordForm.querySelector('#controlNumber')) addRecordForm.querySelector('#controlNumber').value = controlNumberValue;

                            if (addRecordForm.querySelector('#farmerName')) addRecordForm.querySelector('#farmerName').value = '';
                            if (addRecordForm.querySelector('#line')) addRecordForm.querySelector('#line').value = '';
                            if (addRecordForm.querySelector('#program')) addRecordForm.querySelector('#program').value = '';
                            if (addRecordForm.querySelector('#causeOfDamage')) addRecordForm.querySelector('#causeOfDamage').value = '';
                            if (addRecordForm.querySelector('#date_occurrence')) addRecordForm.querySelector('#date_occurrence').value = '';
                            if (addRecordForm.querySelector('#remarks')) addRecordForm.querySelector('#remarks').value = '';
                            setTimeout(function() {
                                fetch(window.location.href, {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(response => response.text())
                                .then(html => {
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(html, 'text/html');
                                    const newTable = doc.querySelector('.overflow-x-auto');
                                    const currentTable = document.querySelector('.overflow-x-auto');
                                    if (newTable && currentTable) {
                                        currentTable.innerHTML = newTable.innerHTML;
                                    }
                                });
                            }, 1500);
                        } else {
                            const uploadError = Object.values(data.errors || {}).flat()[0];
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
                            submitBtn.textContent = 'Add record';
                        }
                    });
                });
            }

            submitBtn.addEventListener('click', function() {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                prefixInput.value = `${year}-${month}${day}`;

                suffixInput.value = '';
                suffixInput.focus();
                dialog.showModal();
            });

            cancelBtn.addEventListener('click', function() {
                dialog.close();
            });

            confirmBtn.addEventListener('click', function() {
                const suffix = suffixInput.value.trim();

                if (!suffix || suffix.length < 1 || suffix.length > 3 || isNaN(suffix)) {
                    showModalMessage('Please enter a valid number between 1 and 999', 'warning');
                    suffixInput.focus();
                    return;
                }

                suffixHidden.value = suffix.padStart(3, '0');
                dialog.close();
                form.submit();
            });

            suffixInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    confirmBtn.click();
                }
            });
        });
    </script>
    <dialog class="editRecordDialog rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(640px,calc(100vw-2rem))]" id="recordEditDialog">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Edit Record</h3>
        </div>
        <form class="editRecordform grid grid-cols-[auto_1fr] gap-x-4 gap-y-3 px-5 py-4 items-center" id="recordEditForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="source" value="OD" id="editRecordSourceOd">
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
                <option value="CFITF-CIP">CFITF-CIP</option>
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
            <input type="text" id="remarks" name="remarks" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <label for="controlNumber" class="text-xs font-bold text-gray-600 text-right">Control Number:</label>
            <input type="text" id="controlNumber" name="control_number" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
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

@push('scripts')
<script>
(function() {
    const addRecordButton = document.getElementById('addRecordButton');
    const controlActions = document.getElementById('controlActions');
    const addRecordPanel = document.getElementById('addRecordPanel');
    const returnToControlsButton = document.getElementById('returnToControlsButton');
    const cancelAddRecordButton = document.getElementById('cancelAddRecordButton');

    function showAddRecordPanel() {
        if (!controlActions || !addRecordPanel) {
            console.error('Officer of the Day add-record panel is unavailable.');
            return;
        }

        controlActions.hidden = true;
        controlActions.classList.add('hidden');
        addRecordPanel.hidden = false;
        addRecordPanel.classList.remove('hidden');
        addRecordButton?.setAttribute('aria-expanded', 'true');
        addRecordPanel.querySelector('#farmerName')?.focus();
    }

    function showControlActions() {
        if (!controlActions || !addRecordPanel) {
            console.error('Officer of the Day controls panel is unavailable.');
            return;
        }

        addRecordPanel.hidden = true;
        addRecordPanel.classList.add('hidden');
        controlActions.hidden = false;
        controlActions.classList.remove('hidden');
        addRecordButton?.setAttribute('aria-expanded', 'false');
        addRecordButton?.focus();
    }

    addRecordButton?.addEventListener('click', showAddRecordPanel);
    returnToControlsButton?.addEventListener('click', showControlActions);
    cancelAddRecordButton?.addEventListener('click', showControlActions);
})();
</script>

@vite('resources/js/pages/officer-records.js')

@endsection
