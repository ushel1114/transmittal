@extends('layout.layout')

@section('title', 'Facebook')

@push('styles')
<style>
</style>
@endpush

@section('page-styles')
<style>
    html, body {
        overflow-x: hidden;
    }
</style>
@endsection

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-pcic-100 via-white to-pcic-100">
        {{-- Top Header Bar --}}
        <div class="odHeader sticky top-0 z-20 w-full bg-white/90 backdrop-blur-md border-b border-gray-200/60">
            <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="flex flex-col">
                        <h3 class="text-base font-black text-gray-900">Facebook</h3>
                        <p class="text-xs text-gray-500 font-semibold">NL Entry Module</p>
                    </div>
                </div>
                @if($isLoggedIn)
                <div class="flex items-center gap-3">
                    <div class="flex flex-col items-end">
                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">FB</div>
                        <div class="text-xs font-black text-gray-900">{{ $facebookUserName }}</div>
                    </div>
                    <form action="{{ route('facebook.logout') }}" method="POST">
                        @csrf
                        <button class="logoutButton h-8 px-3 rounded-lg border border-gray-200 bg-white text-xs font-bold text-gray-600 hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-colors cursor-pointer" type="submit">Logout</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        <div class="contentContainer">
    @if(!$isLoggedIn)
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg border border-gray-100/80 overflow-hidden">
            <div class="px-6 pt-6 pb-4 border-b border-gray-100 bg-gradient-to-b from-pcic-50/60 to-white text-center">
                <div class="w-12 h-12 rounded-xl bg-pcic-50 text-pcic-600 flex items-center justify-center text-sm font-black border border-pcic-100 mx-auto mb-3">FB</div>
                <h1 class="text-xl font-black text-gray-900">Facebook Login</h1>
                <p class="text-sm text-gray-500 font-semibold mt-1">Enter your credentials to continue.</p>
            </div>
            <div class="px-6 py-5">
        <form action="{{ route('facebook.login') }}" method="POST" class="officerOfTheDayNames flex flex-col gap-3" id="facebookLoginForm">
            @csrf
            <select name="facebook_user" id="facebook_user" required class="h-11 px-3 rounded-xl border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                <option value="">Select user</option>
                @php
                    $officers = \App\Models\Officer::orderBy('name')->get();
                @endphp
                @foreach($officers as $officer)
                    <option value="{{ $officer->username ?? $officer->name }}">{{ $officer->name }}</option>
                @endforeach
            </select>
            <input type="password" name="facebook_password" id="facebook_password" placeholder="Password" required class="h-11 px-3 rounded-xl border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <button type="submit" class="h-10 rounded-xl bg-pcic-700 text-white text-sm font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Login</button>
        </form>
            </div>
        </div>
    @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 w-full">
            <div class="no-print bg-white rounded-2xl shadow-lg border border-gray-100/80 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-b from-pcic-50/60 to-white">
                    <h3 class="text-sm font-black text-gray-900">Session</h3>
                    <p class="text-xs text-gray-500 font-semibold mt-0.5">Actions</p>
                </div>
                <div class="px-5 py-4 flex flex-col gap-3">
                    <div class="filter-container">
                        <form action="{{ route('facebook-handler') }}" method="GET">
                            <div class="date-filter-container border border-gray-200 bg-gray-50 rounded-lg p-3">
                                <div class="flex flex-col gap-3">
                                    <label class="text-xs font-bold text-gray-700 mb-2">Filter Records By Date</label>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <!-- Date Encoded Filter -->
                                        <div class="date-encoded-filter">
                                            <div class="flex items-center gap-2 mb-2">
                                            <input type="checkbox" id="use_date_encoded" name="use_date_encoded" value="1" {{ request('use_date_encoded') || (!request('use_date_received') && !request('date_received')) ? 'checked' : '' }} class="w-4 h-4 text-pcic-600 focus:ring-pcic-500 border-gray-300 rounded">
                                            <label for="use_date_encoded" class="text-xs font-medium text-gray-700">Date Encoded (when record was created)</label>
                                        </div>
                                            <input type="date" name="date_encoded" value="{{ request('date_encoded', now()->format('Y-m-d')) }}" class="h-10 px-3 rounded-lg border border-gray-300 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 bg-white outline-none text-sm shadow-sm w-full">
                                        </div>
                                        
                                        <!-- Date Received Filter -->
                                        <div class="date-received-filter">
                                            <div class="flex items-center gap-2 mb-2">
                                            <input type="checkbox" id="use_date_received" name="use_date_received" value="1" {{ request('use_date_received') ? 'checked' : '' }} class="w-4 h-4 text-pcic-600 focus:ring-pcic-500 border-gray-300 rounded">
                                            <label for="use_date_received" class="text-xs font-medium text-gray-700">Date Received (when NL was received)</label>
                                        </div>
                                            <input type="date" name="date_received" value="{{ request('date_received', now()->format('Y-m-d')) }}" class="h-10 px-3 rounded-lg border border-gray-300 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 bg-white outline-none text-sm shadow-sm w-full">
                                        </div>
                                    </div>
                                    
                                    <!-- Filter Options Help -->
                                    <div class="text-xs text-gray-500 bg-blue-50 border border-blue-200 rounded p-2 mt-2">
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
                                    <a href="{{ route('facebook-handler') }}" class="h-10 px-4 rounded-lg bg-white text-gray-700 text-xs font-semibold hover:bg-gray-50 transition-colors cursor-pointer shadow-sm flex items-center justify-center">Clear Filters</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <button type="button" class="addRecordButton h-10 rounded-xl bg-pcic-700 text-white text-sm font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Add Record</button>
                    @if($records->count() > 0)
                    <a href="{{ route('facebook.export-csv') }}" class="h-10 rounded-xl bg-white border border-gray-200 text-gray-700 text-sm font-bold hover:bg-gray-50 transition-colors cursor-pointer flex items-center justify-center gap-2">
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

            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-100/80 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-b from-pcic-50/60 to-white">
                    <h3 class="text-sm font-black text-gray-900">Records</h3>
                    <p class="text-xs text-gray-500 font-semibold mt-0.5">Latest encoded NLs</p>
                </div>
                <div class="p-4 overflow-x-auto">
                    <x-table :records="$records" :showDelete="false" :showCheckbox="false" :showSortableHeaders="false" :hideSourceColumn="true" :hideProvinceColumn="true" />
                    @if(method_exists($records, 'links'))
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
                    @endif
                </div>
            </div>
        </div>

        <!-- Backdrop -->
        <div id="addRecordBackdrop" class="fixed inset-0 bg-gray-900/50 z-[9998] hidden" style="display: none;"></div>

        <!-- Add Record Modal -->
        <div id="addRecordDialog" class="addRecordDialog rounded-2xl shadow-2xl bg-white p-0 w-[min(640px,calc(100vw-2rem))] fixed z-[9999] hidden" style="display: none; position: fixed; z-index: 9999;">
            <div id="addRecordDialogheader" class="px-5 pt-5 pb-3 border-b border-gray-100 cursor-move">
                <h3 class="text-base font-black text-gray-900">Add Record</h3>
            </div>
            <form action="{{ route('records') }}" method="POST" class="grid grid-cols-[auto_1fr] gap-x-4 gap-y-3 px-5 py-4 items-center" id="addRecordForm">
                @csrf
                <input type="hidden" name="source" value="Facebook">
            <label for="farmerName" class="text-xs font-bold text-gray-600 text-right">Farmer Name:</label>
            <input type="text" id="farmerName" name="farmerName" required class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <label for="province" class="text-xs font-bold text-gray-600 text-right">Province:</label>
            <select name="province" id="province" required class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                <option value="">Select Province</option>
                <option value="Aurora">Aurora</option>
                <option value="Nueva Ecija">Nueva Ecija</option>
                <option value="Tarlac">Tarlac</option>
            </select>
            <label for="municipality" class="text-xs font-bold text-gray-600 text-right">Municipality:</label>
            <select name="municipality" id="municipality" required disabled class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-gray-50 uppercase">
                <option value="">Select Municipality</option>
            </select>
            <label for="barangay" class="text-xs font-bold text-gray-600 text-right">Barangay:</label>
            <select name="barangay" id="barangay" required disabled class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-gray-50 uppercase">
                <option value="">Select Barangay</option>
            </select>
            <input type="hidden" name="address" id="addRecordAddress">
            <label for="line" class="text-xs font-bold text-gray-600 text-right">Line:</label>
            <select name="line" id="line" required class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
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
            <select name="program" id="program" required class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
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
            <input type="date" id="date_received" name="date_received" value="{{ now()->format('Y-m-d') }}" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <label for="causeOfDamage" class="text-xs font-bold text-gray-600 text-right">Cause of Damage:</label>
            <input type="text" id="causeOfDamage" name="causeOfDamage" required class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <label for="modeOfPayment" class="text-xs font-bold text-gray-600 text-right">Mode of payment:</label>
            <select name="modeOfPayment" id="modeOfPayment" required class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full bg-white uppercase">
                <option value="">Select Mode of payment</option>
                <option value="check">Check</option>
                <option value="palawan">Palawan Pay</option>
                <option value="gcash">GCash</option>
                <option value="not_indicated">Not indicated</option>
            </select>
            <label for="remarks" class="text-xs font-bold text-gray-600 text-right">Remarks - Care of:</label>
            <input type="text" id="remarks" name="remarks" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full ">
            <label for="accounts" class="text-xs font-bold text-gray-600 text-right">Account / page:</label>
            <input type="text" id="accounts" name="accounts" required placeholder="Name of Facebook page or account" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <label for="facebook_page_url" class="text-xs font-bold text-gray-600 text-right">FB page link:</label>
            <input type="url" id="facebook_page_url" name="facebook_page_url" placeholder="https://www.facebook.com/..." class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <div></div>
            <div class="flex gap-2 pt-1">
                <button type="submit" class="h-9 px-4 rounded-lg bg-pcic-700 text-white text-xs font-bold hover:bg-pcic-800 transition-colors cursor-pointer">Add Record</button>
                <button type="button" class="closeAddRecordModal h-9 px-4 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">Close</button>
            </div>
        </form>
    </div>
    <dialog class="editRecordDialog rounded-2xl shadow-2xl bg-white backdrop:bg-black/40 p-0 w-[min(640px,calc(100vw-2rem))]" id="recordEditDialog">
        <div class="px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-black text-gray-900">Edit Record</h3>
        </div>
        <form class="editRecordform grid grid-cols-[auto_1fr] gap-x-4 gap-y-3 px-5 py-4 items-center" id="recordEditForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="source" value="Facebook" id="editRecordSourceFacebook">
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
            <label for="accounts" class="text-xs font-bold text-gray-600 text-right">Account / page:</label>
            <input type="text" id="accounts" name="accounts" required placeholder="Name of Facebook page or account" class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
            <label for="facebook_page_url" class="text-xs font-bold text-gray-600 text-right">FB page link:</label>
            <input type="url" id="facebook_page_url" name="facebook_page_url" placeholder="https://www.facebook.com/..." class="h-9 px-3 rounded-lg border border-gray-200 focus:border-pcic-500 focus:ring-2 focus:ring-pcic-100 outline-none text-sm w-full">
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
// Automatic logout on browser/tab close
window.addEventListener('beforeunload', function(e) {
    // Send logout request using navigator.sendBeacon for reliable delivery
    navigator.sendBeacon('{{ route('facebook.logout') }}', new FormData());
});

// Also handle page visibility change (user switches tabs)
document.addEventListener('visibilitychange', function() {
    if (document.visibilityState === 'hidden') {
        // User switched away from the tab, mark as away after a delay
        setTimeout(function() {
            if (document.visibilityState === 'hidden') {
                navigator.sendBeacon('{{ route('facebook.logout') }}', new FormData());
            }
        }, 30000); // 30 seconds delay
    }
});

// Add Record Modal
document.addEventListener('DOMContentLoaded', function() {
    var addRecordButton = document.querySelector('.addRecordButton');
    var addRecordDialog = document.querySelector('.addRecordDialog');
    var closeAddRecordModal = document.querySelector('.closeAddRecordModal');

    if (closeAddRecordModal && addRecordDialog) {
        closeAddRecordModal.addEventListener('click', function() {
            addRecordDialog.close();
        });
    }

    // Edit Record Modal - Use event delegation to handle dynamically loaded buttons
    var editRecordDialog = document.getElementById('recordEditDialog');
    var closeEditRecordModal = document.querySelector('.closeEditRecordDialog');
    var editRecordForm = document.getElementById('recordEditForm');

    // Use event delegation on the document to handle edit button clicks
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('editButton') || e.target.closest('.editButton')) {
            var button = e.target.classList.contains('editButton') ? e.target : e.target.closest('.editButton');
            
            if (!editRecordDialog || !editRecordForm) {
                console.error('Edit dialog or form not found');
                return;
            }

            try {
                var recordId = button.getAttribute('data-id');
                var farmerName = button.getAttribute('data-farmer-name');
                var province = button.getAttribute('data-province');
                var municipality = button.getAttribute('data-municipality');
                var barangay = button.getAttribute('data-barangay');
                var address = button.getAttribute('data-address');
                var program = button.getAttribute('data-program');
                var line = button.getAttribute('data-line');
                var causeOfDamage = button.getAttribute('data-cause-of-damage');
                var modeOfPayment = button.getAttribute('data-mode-of-payment');
                var accounts = button.getAttribute('data-accounts');
                var fbPageUrl = button.getAttribute('data-fb-page-url');
                var dateOccurrence = button.getAttribute('data-date-occurrence');
                var dateReceived = button.getAttribute('data-date-received');
                var remarks = button.getAttribute('data-remarks');
                var source = button.getAttribute('data-source');
                var transmittalNumber = button.getAttribute('data-transmittal-number');
                var adminTransmittalNumber = button.getAttribute('data-admin-transmittal-number');

                // Populate form fields
                var farmerNameField = editRecordForm.querySelector('#farmerName');
                var editProvinceField = editRecordForm.querySelector('#editProvince');
                var editMunicipalityField = editRecordForm.querySelector('#editMunicipality');
                var editBarangayField = editRecordForm.querySelector('#editBarangay');
                var addressField = editRecordForm.querySelector('#editRecordAddress');
                var programField = editRecordForm.querySelector('#program');
                var lineField = editRecordForm.querySelector('#line');
                var causeOfDamageField = editRecordForm.querySelector('#causeOfDamage');
                var modeOfPaymentField = editRecordForm.querySelector('#modeOfPayment');
                var accountsField = editRecordForm.querySelector('#accounts');
                var fbPageUrlField = editRecordForm.querySelector('#facebook_page_url');
                var dateOccurrenceField = editRecordForm.querySelector('#date_occurrence');
                var dateReceivedField = editRecordForm.querySelector('#date_received');
                var remarksField = editRecordForm.querySelector('#remarks');
                var transmittalNumberField = editRecordForm.querySelector('#transmittal_number');
                var adminTransmittalNumberField = editRecordForm.querySelector('#admin_transmittal_number');

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

                // Set form action
                editRecordForm.action = '/records/' + recordId;
                console.log('Setting form action to:', editRecordForm.action);
                
                // Check if CSRF token is available
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                console.log('CSRF token found:', !!csrfToken);
                if (!csrfToken) {
                    console.error('CSRF token not found');
                    return;
                }

                // Enable municipality and barangay selects based on province
                if (editProvinceField && editMunicipalityField && editBarangayField) {
                    if (editProvinceField.value) {
                        editMunicipalityField.disabled = false;
                        // Trigger municipality update
                        var event = new Event('change');
                        editProvinceField.dispatchEvent(event);
                        
                        if (editMunicipalityField.value) {
                            editBarangayField.disabled = false;
                            // Trigger barangay update
                            var municipalityEvent = new Event('change');
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

    // Handle form submission for edit record
    if (editRecordForm) {
        editRecordForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Update hidden address field before submission
            var editProvinceField = editRecordForm.querySelector('#editProvince');
            var editMunicipalityField = editRecordForm.querySelector('#editMunicipality');
            var editBarangayField = editRecordForm.querySelector('#editBarangay');
            var addressField = editRecordForm.querySelector('#editRecordAddress');
            if (editProvinceField && editMunicipalityField && editBarangayField && addressField) {
                addressField.value = [editBarangayField.value, editMunicipalityField.value, editProvinceField.value]
                    .filter(Boolean)
                    .join(', ');
            }

            console.log('Edit form submit triggered');

            var formData = new FormData(editRecordForm);
            // Ensure _method parameter is included for PUT request
            if (!formData.has('_method')) {
                formData.append('_method', 'PUT');
            }
            var formAction = editRecordForm.action;

            console.log('Form action:', formAction);
            console.log('Form data:', Array.from(formData.entries()));
            
            // Show loading state
            var submitButton = editRecordForm.querySelector('button[type="submit"]');
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
                console.log('Response headers:', response.headers);
                console.log('Response ok:', response.ok);
                
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status + ': ' + response.statusText);
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
                    // Close modal
                    editRecordDialog.close();
                    // Reload page to show updated data
                    window.location.reload();
                } else {
                    showModalMessage('Error updating record: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(function(error) {
                console.error('Fetch error:', error);
                showModalMessage('Error updating record. Please try again.', 'error');
            })
            .finally(function() {
                // Reset button state
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Update Record';
                }
            });
        });
    }

    // Cascading dropdowns for add and edit forms
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
Poblacion,Cabiao,Nueva Ecija
Bagong Sikat,Cabiao,Nueva Ecija
Buenavista,Cabiao,Nueva Ecija
San Isidro,Cabiao,Nueva Ecija
Sinipit,Cabiao,Nueva Ecija
Huma,Cabiao,Nueva Ecija
Entablado,Cabiao,Nueva Ecija
Nieves,Cabiao,Nueva Ecija
San Roque,Cabiao,Nueva Ecija
Santa Ines,Cabiao,Nueva Ecija
Santo Cristo,Cabiao,Nueva Ecija
Santa Rita,Cabiao,Nueva Ecija
San Gregorio,Cabiao,Nueva Ecija
Baluarte,Cabiao,Nueva Ecija
Bangkal,Cabiao,Nueva Ecija
Caalibangbangan,Cabiao,Nueva Ecija
Cabisuculan,Cabiao,Nueva Ecija
Calabasa,Cabiao,Nueva Ecija
Calumpang,Cabiao,Nueva Ecija
Caniogan,Cabiao,Nueva Ecija
Casile,Cabiao,Nueva Ecija
Castañeda,Cabiao,Nueva Ecija
Maligaya,Cabiao,Nueva Ecija
Pantoc Bula,Cabiao,Nueva Ecija
Pulo,Cabiao,Nueva Ecija
Sapa,Cabiao,Nueva Ecija
Tibag,Cabiao,Nueva Ecija
Tula,Cabiao,Nueva Ecija
Bagong Buhay,Carranglan,Nueva Ecija
Barangay 1,Carranglan,Nueva Ecija
Barangay 2,Carranglan,Nueva Ecija
Barangay 3,Carranglan,Nueva Ecija
Barangay 4,Carranglan,Nueva Ecija
Barangay 5,Carranglan,Nueva Ecija
Barangay 6,Carranglan,Nueva Ecija
Barangay 7,Carranglan,Nueva Ecija
Barangay 8,Carranglan,Nueva Ecija
Burgos,Carranglan,Nueva Ecija
Cabitucanan,Carranglan,Nueva Ecija
Calipatan,Carranglan,Nueva Ecija
Canaway,Carranglan,Nueva Ecija
D.D. Edwards,Carranglan,Nueva Ecija
Gen. Luna,Carranglan,Nueva Ecija
Larion,Carranglan,Nueva Ecija
Pob.,Carranglan,Nueva Ecija
Pudoc,Carranglan,Nueva Ecija
San Felipe,Carranglan,Nueva Ecija
Santo Rosario,Carranglan,Nueva Ecija
Udarb,Carranglan,Nueva Ecija
Yanac,Carranglan,Nueva Ecija
Alangalang,Cuyapo,Nueva Ecija
Bacao,Cuyapo,Nueva Ecija
Bucana,Cuyapo,Nueva Ecija
Bungot,Cuyapo,Nueva Ecija
Calaba,Cuyapo,Nueva Ecija
Calabasa,Cuyapo,Nueva Ecija
Calitlitan,Cuyapo,Nueva Ecija
Calsib,Cuyapo,Nueva Ecija
Canaan,Cuyapo,Nueva Ecija
Casilagan,Cuyapo,Nueva Ecija
Curva,Cuyapo,Nueva Ecija
Dulong Bayan,Cuyapo,Nueva Ecija
Guimba,Cuyapo,Nueva Ecija
Labney,Cuyapo,Nueva Ecija
Lagula,Cuyapo,Nueva Ecija
Langka,Cuyapo,Nueva Ecija
Licos,Cuyapo,Nueva Ecija
Lourdes,Cuyapo,Nueva Ecija
Mabini,Cuyapo,Nueva Ecija
Malapit,Cuyapo,Nueva Ecija
Nagpandayan,Cuyapo,Nueva Ecija
Poblacion,Cuyapo,Nueva Ecija
Pulo,Cuyapo,Nueva Ecija
San Roque,Cuyapo,Nueva Ecija
Santa Cruz,Cuyapo,Nueva Ecija
Santo Niño,Cuyapo,Nueva Ecija
Santo Tomas,Cuyapo,Nueva Ecija
Sinipit,Cuyapo,Nueva Ecija
Tagumpay,Cuyapo,Nueva Ecija
Villa Flores,Cuyapo,Nueva Ecija
Villa Peña,Cuyapo,Nueva Ecija
Balsing,City of Gapan,Nueva Ecija
Bayabas,City of Gapan,Nueva Ecija
Bungot,City of Gapan,Nueva Ecija
Buray,City of Gapan,Nueva Ecija
Cacarawan,City of Gapan,Nueva Ecija
Calaacan,City of Gapan,Nueva Ecija
Cayungan,City of Gapan,Nueva Ecija
Dona Carmen,City of Gapan,Nueva Ecija
Luzviminda,City of Gapan,Nueva Ecija
Mabini,City of Gapan,Nueva Ecija
Macabud,City of Gapan,Nueva Ecija
Mahipon,City of Gapan,Nueva Ecija
Malingling,City of Gapan,Nueva Ecija
Manlag,City of Gapan,Nueva Ecija
Panggol,City of Gapan,Nueva Ecija
Poblacion,City of Gapan,Nueva Ecija
San Antonio,City of Gapan,Nueva Ecija
San Isidro,City of Gapan,Nueva Ecija
San Lorenzo,City of Gapan,Nueva Ecija
San Nicolas,City of Gapan,Nueva Ecija
San Roque,City of Gapan,Nueva Ecija
Santa Cruz,City of Gapan,Nueva Ecija
Santo Cristo,City of Gapan,Nueva Ecija
Santo Niño,City of Gapan,Nueva Ecija
Santo Rosario,City of Gapan,Nueva Ecija
Sinipit,City of Gapan,Nueva Ecija
Tagumpay,City of Gapan,Nueva Ecija
Agtipalo,General Mamerto Natividad,Nueva Ecija
Bangkal,General Mamerto Natividad,Nueva Ecija
Bigte,General Mamerto Natividad,Nueva Ecija
Cabiao,General Mamerto Natividad,Nueva Ecija
Castañeda,General Mamerto Natividad,Nueva Ecija
Kabay,General Mamerto Natividad,Nueva Ecija
Mag-asawang Sampaga,General Mamerto Natividad,Nueva Ecija
Maligaya,General Mamerto Natividad,Nueva Ecija
Matingkis,General Mamerto Natividad,Nueva Ecija
Poblacion,General Mamerto Natividad,Nueva Ecija
Pula,General Mamerto Natividad,Nueva Ecija
Santo Rosario,General Mamerto Natividad,Nueva Ecija
Singalat,General Mamerto Natividad,Nueva Ecija
Pulong Gubat,General Tinio,Nueva Ecija
Rio Chico,General Tinio,Nueva Ecija
Poblacion,General Tinio,Nueva Ecija
Papaya,General Tinio,Nueva Ecija
Baret,General Tinio,Nueva Ecija
Brgy. 1,General Tinio,Nueva Ecija
Brgy. 2,General Tinio,Nueva Ecija
Brgy. 3,General Tinio,Nueva Ecija
Brgy. 4,General Tinio,Nueva Ecija
Brgy. 5,General Tinio,Nueva Ecija
Brgy. 6,General Tinio,Nueva Ecija
Brgy. 7,General Tinio,Nueva Ecija
Brgy. 8,General Tinio,Nueva Ecija
Aduas Centro,Guimba,Nueva Ecija
Aduas Norte,Guimba,Nueva Ecija
Aduas Sur,Guimba,Nueva Ecija
Bangan 1st,Guimba,Nueva Ecija
Bangan 2nd,Guimba,Nueva Ecija
Calaba,Guimba,Nueva Ecija
Cawayan,Guimba,Nueva Ecija
District 1,Guimba,Nueva Ecija
District 2,Guimba,Nueva Ecija
District 3,Guimba,Nueva Ecija
Gapan,Guimba,Nueva Ecija
Mariano,Guimba,Nueva Ecija
Narvaez,Guimba,Nueva Ecija
Rizal,Guimba,Nueva Ecija
San Agustin,Guimba,Nueva Ecija
San Andres,Guimba,Nueva Ecija
San Bernardino,Guimba,Nueva Ecija
San Cristobal,Guimba,Nueva Ecija
San Francisco,Guimba,Nueva Ecija
San Isidro,Guimba,Nueva Ecija
San Jose,Guimba,Nueva Ecija
San Juan,Guimba,Nueva Ecija
San Leonardo,Guimba,Nueva Ecija
San Marcos,Guimba,Nueva Ecija
San Miguel,Guimba,Nueva Ecija
San Pedro,Guimba,Nueva Ecija
San Roque,Guimba,Nueva Ecija
San Vicente,Guimba,Nueva Ecija
Santa Cruz,Guimba,Nueva Ecija
Santa Maria,Guimba,Nueva Ecija
Santa Rita,Guimba,Nueva Ecija
Santo Cristo,Guimba,Nueva Ecija
Santo Niño,Guimba,Nueva Ecija
Santo Rosario,Guimba,Nueva Ecija
Sapang,Guimba,Nueva Ecija
Tabi,Guimba,Nueva Ecija
Tangcarang,Guimba,Nueva Ecija
Tayok,Guimba,Nueva Ecija
Tulay,Guimba,Nueva Ecija
Villa Natividad,Guimba,Nueva Ecija
Agapito,Jaen,Nueva Ecija
Aguinaldo,Jaen,Nueva Ecija
Bayani,Jaen,Nueva Ecija
Binon,Jaen,Nueva Ecija
Bucal,Jaen,Nueva Ecija
Cabayao,Jaen,Nueva Ecija
Cabcab,Jaen,Nueva Ecija
Cacarawan,Jaen,Nueva Ecija
Calaacan,Jaen,Nueva Ecija
Calitlitan,Jaen,Nueva Ecija
Calsib,Jaen,Nueva Ecija
Canaan,Jaen,Nueva Ecija
Casilagan,Jaen,Nueva Ecija
Curva,Jaen,Nueva Ecija
Dulong Bayan,Jaen,Nueva Ecija
Lambakin,Jaen,Nueva Ecija
Lanas,Jaen,Nueva Ecija
Langka,Jaen,Nueva Ecija
Licos,Jaen,Nueva Ecija
Lourdes,Jaen,Nueva Ecija
Mabini,Jaen,Nueva Ecija
Malapit,Jaen,Nueva Ecija
Nagpandayan,Jaen,Nueva Ecija
Poblacion,Jaen,Nueva Ecija
Pulo,Jaen,Nueva Ecija
San Agustin,Jaen,Nueva Ecija
San Jose,Jaen,Nueva Ecija
San Pablo,Jaen,Nueva Ecija
San Pedro,Jaen,Nueva Ecija
San Roque,Jaen,Nueva Ecija
Santa Cruz,Jaen,Nueva Ecija
Santo Niño,Jaen,Nueva Ecija
Santo Tomas,Jaen,Nueva Ecija
Sinipit,Jaen,Nueva Ecija
Tagumpay,Jaen,Nueva Ecija
Villa Flores,Jaen,Nueva Ecija
Villa Peña,Jaen,Nueva Ecija
Agtipalo,Laur,Nueva Ecija
Baluarte,Laur,Nueva Ecija
Bangkalis,Laur,Nueva Ecija
Canaway,Laur,Nueva Ecija
Castañeda,Laur,Nueva Ecija
Natividad,Laur,Nueva Ecija
Poblacion,Laur,Nueva Ecija
San Fernando,Laur,Nueva Ecija
San Isidro,Laur,Nueva Ecija
San Jose,Laur,Nueva Ecija
San Juan,Laur,Nueva Ecija
San Miguel,Laur,Nueva Ecija
San Pedro,Laur,Nueva Ecija
San Roque,Laur,Nueva Ecija
Santa Cruz,Laur,Nueva Ecija
Santo Cristo,Laur,Nueva Ecija
Santo Niño,Laur,Nueva Ecija
Santo Rosario,Laur,Nueva Ecija
Sinipit,Laur,Nueva Ecija
Tagumpay,Laur,Nueva Ecija
Villa Flores,Laur,Nueva Ecija
Villa Peña,Laur,Nueva Ecija
Pulong Gubat,Licab,Nueva Ecija
Licaong,Licab,Nueva Ecija
Lombac,Licab,Nueva Ecija
San Cristobal,Licab,Nueva Ecija
San Jose,Licab,Nueva Ecija
San Juan,Licab,Nueva Ecija
Santa Maria,Licab,Nueva Ecija
Santo Tomas,Licab,Nueva Ecija
Sinipit,Licab,Nueva Ecija
Agtipalo,Llanera,Nueva Ecija
Baluarte,Llanera,Nueva Ecija
Bangkalis,Llanera,Nueva Ecija
Canaway,Llanera,Nueva Ecija
Castañeda,Llanera,Nueva Ecija
Natividad,Llanera,Nueva Ecija
Poblacion,Llanera,Nueva Ecija
San Fernando,Llanera,Nueva Ecija
San Isidro,Llanera,Nueva Ecija
San Jose,Llanera,Nueva Ecija
San Juan,Llanera,Nueva Ecija
San Miguel,Llanera,Nueva Ecija
San Pedro,Llanera,Nueva Ecija
San Roque,Llanera,Nueva Ecija
Santa Cruz,Llanera,Nueva Ecija
Santo Cristo,Llanera,Nueva Ecija
Santo Niño,Llanera,Nueva Ecija
Santo Rosario,Llanera,Nueva Ecija
Sinipit,Llanera,Nueva Ecija
Tagumpay,Llanera,Nueva Ecija
Villa Flores,Llanera,Nueva Ecija
Villa Peña,Llanera,Nueva Ecija
Bagong Silang,Lupao,Nueva Ecija
Cagayan,Lupao,Nueva Ecija
Calaba,Lupao,Nueva Ecija
Calitlitan,Lupao,Nueva Ecija
Calsib,Lupao,Nueva Ecija
Canaan,Lupao,Nueva Ecija
Casilagan,Lupao,Nueva Ecija
Curva,Lupao,Nueva Ecija
Dulong Bayan,Lupao,Nueva Ecija
Lambakin,Lupao,Nueva Ecija
Lanas,Lupao,Nueva Ecija
Langka,Lupao,Nueva Ecija
Licos,Lupao,Nueva Ecija
Lourdes,Lupao,Nueva Ecija
Mabini,Lupao,Nueva Ecija
Malapit,Lupao,Nueva Ecija
Nagpandayan,Lupao,Nueva Ecija
Poblacion,Lupao,Nueva Ecija
Pulo,Lupao,Nueva Ecija
San Agustin,Lupao,Nueva Ecija
San Jose,Lupao,Nueva Ecija
San Pablo,Lupao,Nueva Ecija
San Pedro,Lupao,Nueva Ecija
San Roque,Lupao,Nueva Ecija
Santa Cruz,Lupao,Nueva Ecija
Santo Niño,Lupao,Nueva Ecija
Santo Tomas,Lupao,Nueva Ecija
Sinipit,Lupao,Nueva Ecija
Tagumpay,Lupao,Nueva Ecija
Villa Flores,Lupao,Nueva Ecija
Villa Peña,Lupao,Nueva Ecija
Agtipalo,Science City of Muñoz,Nueva Ecija
Baluarte,Science City of Muñoz,Nueva Ecija
Bangkalis,Science City of Muñoz,Nueva Ecija
Canaway,Science City of Muñoz,Nueva Ecija
Castañeda,Science City of Muñoz,Nueva Ecija
Natividad,Science City of Muñoz,Nueva Ecija
Poblacion,Science City of Muñoz,Nueva Ecija
San Fernando,Science City of Muñoz,Nueva Ecija
San Isidro,Science City of Muñoz,Nueva Ecija
San Jose,Science City of Muñoz,Nueva Ecija
San Juan,Science City of Muñoz,Nueva Ecija
San Miguel,Science City of Muñoz,Nueva Ecija
San Pedro,Science City of Muñoz,Nueva Ecija
San Roque,Science City of Muñoz,Nueva Ecija
Santa Cruz,Science City of Muñoz,Nueva Ecija
Santo Cristo,Science City of Muñoz,Nueva Ecija
Santo Niño,Science City of Muñoz,Nueva Ecija
Santo Rosario,Science City of Muñoz,Nueva Ecija
Sinipit,Science City of Muñoz,Nueva Ecija
Tagumpay,Science City of Muñoz,Nueva Ecija
Villa Flores,Science City of Muñoz,Nueva Ecija
Villa Peña,Science City of Muñoz,Nueva Ecija
Agtipalo,Nampicuan,Nueva Ecija
Baluarte,Nampicuan,Nueva Ecija
Bangkalis,Nampicuan,Nueva Ecija
Canaway,Nampicuan,Nueva Ecija
Castañeda,Nampicuan,Nueva Ecija
Natividad,Nampicuan,Nueva Ecija
Poblacion,Nampicuan,Nueva Ecija
San Fernando,Nampicuan,Nueva Ecija
San Isidro,Nampicuan,Nueva Ecija
San Jose,Nampicuan,Nueva Ecija
San Juan,Nampicuan,Nueva Ecija
San Miguel,Nampicuan,Nueva Ecija
San Pedro,Nampicuan,Nueva Ecija
San Roque,Nampicuan,Nueva Ecija
Santa Cruz,Nampicuan,Nueva Ecija
Santo Cristo,Nampicuan,Nueva Ecija
Santo Niño,Nampicuan,Nueva Ecija
Santo Rosario,Nampicuan,Nueva Ecija
Sinipit,Nampicuan,Nueva Ecija
Tagumpay,Nampicuan,Nueva Ecija
Villa Flores,Nampicuan,Nueva Ecija
Villa Peña,Nampicuan,Nueva Ecija
Agtipalo,City of Palayan,Nueva Ecija
Baluarte,City of Palayan,Nueva Ecija
Bangkalis,City of Palayan,Nueva Ecija
Canaway,City of Palayan,Nueva Ecija
Castañeda,City of Palayan,Nueva Ecija
Natividad,City of Palayan,Nueva Ecija
Poblacion,City of Palayan,Nueva Ecija
San Fernando,City of Palayan,Nueva Ecija
San Isidro,City of Palayan,Nueva Ecija
San Jose,City of Palayan,Nueva Ecija
San Juan,City of Palayan,Nueva Ecija
San Miguel,City of Palayan,Nueva Ecija
San Pedro,City of Palayan,Nueva Ecija
San Roque,City of Palayan,Nueva Ecija
Santa Cruz,City of Palayan,Nueva Ecija
Santo Cristo,City of Palayan,Nueva Ecija
Santo Niño,City of Palayan,Nueva Ecija
Santo Rosario,City of Palayan,Nueva Ecija
Sinipit,City of Palayan,Nueva Ecija
Tagumpay,City of Palayan,Nueva Ecija
Villa Flores,City of Palayan,Nueva Ecija
Villa Peña,City of Palayan,Nueva Ecija
Agtipalo,Pantabangan,Nueva Ecija
Baluarte,Pantabangan,Nueva Ecija
Bangkalis,Pantabangan,Nueva Ecija
Canaway,Pantabangan,Nueva Ecija
Castañeda,Pantabangan,Nueva Ecija
Natividad,Pantabangan,Nueva Ecija
Poblacion,Pantabangan,Nueva Ecija
San Fernando,Pantabangan,Nueva Ecija
San Isidro,Pantabangan,Nueva Ecija
San Jose,Pantabangan,Nueva Ecija
San Juan,Pantabangan,Nueva Ecija
San Miguel,Pantabangan,Nueva Ecija
San Pedro,Pantabangan,Nueva Ecija
San Roque,Pantabangan,Nueva Ecija
Santa Cruz,Pantabangan,Nueva Ecija
Santo Cristo,Pantabangan,Nueva Ecija
Santo Niño,Pantabangan,Nueva Ecija
Santo Rosario,Pantabangan,Nueva Ecija
Sinipit,Pantabangan,Nueva Ecija
Tagumpay,Pantabangan,Nueva Ecija
Villa Flores,Pantabangan,Nueva Ecija
Villa Peña,Pantabangan,Nueva Ecija
Agtipalo,Peñaranda,Nueva Ecija
Baluarte,Peñaranda,Nueva Ecija
Bangkalis,Peñaranda,Nueva Ecija
Canaway,Peñaranda,Nueva Ecija
Castañeda,Peñaranda,Nueva Ecija
Natividad,Peñaranda,Nueva Ecija
Poblacion,Peñaranda,Nueva Ecija
San Fernando,Peñaranda,Nueva Ecija
San Isidro,Peñaranda,Nueva Ecija
San Jose,Peñaranda,Nueva Ecija
San Juan,Peñaranda,Nueva Ecija
San Miguel,Peñaranda,Nueva Ecija
San Pedro,Peñaranda,Nueva Ecija
San Roque,Peñaranda,Nueva Ecija
Santa Cruz,Peñaranda,Nueva Ecija
Santo Cristo,Peñaranda,Nueva Ecija
Santo Niño,Peñaranda,Nueva Ecija
Santo Rosario,Peñaranda,Nueva Ecija
Sinipit,Peñaranda,Nueva Ecija
Tagumpay,Peñaranda,Nueva Ecija
Villa Flores,Peñaranda,Nueva Ecija
Villa Peña,Peñaranda,Nueva Ecija
Agtipalo,Quezon,Nueva Ecija
Baluarte,Quezon,Nueva Ecija
Bangkalis,Quezon,Nueva Ecija
Canaway,Quezon,Nueva Ecija
Castañeda,Quezon,Nueva Ecija
Natividad,Quezon,Nueva Ecija
Poblacion,Quezon,Nueva Ecija
San Fernando,Quezon,Nueva Ecija
San Isidro,Quezon,Nueva Ecija
San Jose,Quezon,Nueva Ecija
San Juan,Quezon,Nueva Ecija
San Miguel,Quezon,Nueva Ecija
San Pedro,Quezon,Nueva Ecija
San Roque,Quezon,Nueva Ecija
Santa Cruz,Quezon,Nueva Ecija
Santo Cristo,Quezon,Nueva Ecija
Santo Niño,Quezon,Nueva Ecija
Santo Rosario,Quezon,Nueva Ecija
Sinipit,Quezon,Nueva Ecija
Tagumpay,Quezon,Nueva Ecija
Villa Flores,Quezon,Nueva Ecija
Villa Peña,Quezon,Nueva Ecija
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
Gumabat,Baler,Aurora
Poblacion,Baler,Aurora
Simbahan,Baler,Aurora
Umiray,Baler,Aurora
Yapara,Baler,Aurora
Baguindoc,Anao,Tarlac
Bantog,Anao,Tarlac
Campos,Anao,Tarlac
Carmen,Anao,Tarlac
Casili,Anao,Tarlac
Don Ramon,Anao,Tarlac
Hernando,Anao,Tarlac
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
Mangolago,Victoria,Tarlac
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

    var locationData = parseLocationData(locationCsv);

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

    // Add record form cascading dropdowns
    var addProvince = document.getElementById('province');
    var addMunicipality = document.getElementById('municipality');
    var addBarangay = document.getElementById('barangay');

    if (addProvince && addMunicipality && addBarangay) {
        addProvince.addEventListener('change', function() {
            if (!addProvince.value) {
                populateSelect(addMunicipality, [], 'Select Municipality');
                populateSelect(addBarangay, [], 'Select Barangay');
                addMunicipality.disabled = true;
                addBarangay.disabled = true;
                return;
            }
            var municipalities = Object.keys(locationData[addProvince.value] || {});
            populateSelect(addMunicipality, municipalities, 'Select Municipality');
            addMunicipality.disabled = false;
            populateSelect(addBarangay, [], 'Select Barangay');
            addBarangay.disabled = true;
        });

        addMunicipality.addEventListener('change', function() {
            if (!addProvince.value || !addMunicipality.value) {
                populateSelect(addBarangay, [], 'Select Barangay');
                addBarangay.disabled = true;
                return;
            }
            var barangays = locationData[addProvince.value]?.[addMunicipality.value] || [];
            populateSelect(addBarangay, barangays, 'Select Barangay');
            addBarangay.disabled = false;
        });
    }

    // Restore location values on page load (after successful submission)
    document.addEventListener('DOMContentLoaded', function() {
        var province = document.getElementById('province');
        var municipality = document.getElementById('municipality');
        var barangay = document.getElementById('barangay');
        
        if (province && municipality && barangay) {
            var savedProvince = localStorage.getItem('facebook_province');
            var savedMunicipality = localStorage.getItem('facebook_municipality');
            var savedBarangay = localStorage.getItem('facebook_barangay');
            
            console.log('Restoring location values:', savedProvince, savedMunicipality, savedBarangay);
            
            if (savedProvince) {
                province.value = savedProvince;
                // Enable municipality dropdown
                municipality.disabled = false;
                municipality.classList.remove('bg-gray-50');
                municipality.classList.add('bg-white');
                
                // Trigger change event to populate municipalities
                var event = new Event('change');
                province.dispatchEvent(event);
                
                // After municipalities are loaded, set the saved value
                setTimeout(function() {
                    if (savedMunicipality) {
                        municipality.value = savedMunicipality;
                        // Enable barangay dropdown
                        barangay.disabled = false;
                        barangay.classList.remove('bg-gray-50');
                        barangay.classList.add('bg-white');
                        
                        // Trigger change event to populate barangays
                        var municipalityEvent = new Event('change');
                        municipality.dispatchEvent(municipalityEvent);
                        
                        // After barangays are loaded, set the saved value
                        setTimeout(function() {
                            if (savedBarangay) {
                                barangay.value = savedBarangay;
                            }
                        }, 100);
                    }
                }, 100);
            }
        }
    });

    // Edit record form cascading dropdowns
    var editProvince = document.getElementById('editProvince');
    var editMunicipality = document.getElementById('editMunicipality');
    var editBarangay = document.getElementById('editBarangay');

    if (editProvince && editMunicipality && editBarangay) {
        editProvince.addEventListener('change', function() {
            if (!editProvince.value) {
                populateSelect(editMunicipality, [], 'Select Municipality');
                populateSelect(editBarangay, [], 'Select Barangay');
                editMunicipality.disabled = true;
                editBarangay.disabled = true;
                return;
            }
            var municipalities = Object.keys(locationData[editProvince.value] || {});
            populateSelect(editMunicipality, municipalities, 'Select Municipality');
            editMunicipality.disabled = false;
            populateSelect(editBarangay, [], 'Select Barangay');
            editBarangay.disabled = true;
        });

        editMunicipality.addEventListener('change', function() {
            if (!editProvince.value || !editMunicipality.value) {
                populateSelect(editBarangay, [], 'Select Barangay');
                editBarangay.disabled = true;
                return;
            }
            var barangays = locationData[editProvince.value]?.[editMunicipality.value] || [];
            populateSelect(editBarangay, barangays, 'Select Barangay');
            editBarangay.disabled = false;
        });
    }
});
</script>

<script>
// Add Record Modal Functionality
(function() {
    var addRecordDialog = document.getElementById('addRecordDialog');
    var addRecordBackdrop = document.getElementById('addRecordBackdrop');
    var closeAddRecordModal = document.querySelector('.closeAddRecordModal');
    
    // Function to fetch and populate latest record
    function populateFormWithLatestRecord() {
        fetch('{{ route('records.latest') }}?source=Facebook')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.record) {
                    const form = addRecordDialog ? addRecordDialog.querySelector('form') : null;
                    if (form) {
                        // Clear all fields first
                        if (form.querySelector('#farmerName')) form.querySelector('#farmerName').value = '';
                        if (form.querySelector('#line')) form.querySelector('#line').value = '';
                        if (form.querySelector('#program')) form.querySelector('#program').value = '';
                        if (form.querySelector('#causeOfDamage')) form.querySelector('#causeOfDamage').value = '';
                        if (form.querySelector('#date_occurrence')) form.querySelector('#date_occurrence').value = '';
                        if (form.querySelector('#remarks')) form.querySelector('#remarks').value = '';
                        if (form.querySelector('#controlNumber')) form.querySelector('#controlNumber').value = '';
                        
                        // Only populate location, mode of payment, date received, account, and fb link
                        if (form.querySelector('#province')) {
                            form.querySelector('#province').value = data.record.province || '';
                            // Trigger change to enable municipality
                            form.querySelector('#province').dispatchEvent(new Event('change'));
                        }
                        if (form.querySelector('#modeOfPayment')) form.querySelector('#modeOfPayment').value = data.record.modeOfPayment || '';
                        if (form.querySelector('#date_received')) form.querySelector('#date_received').value = data.record.date_received || '';
                        if (form.querySelector('#accounts')) form.querySelector('#accounts').value = data.record.accounts || '';
                        if (form.querySelector('#facebook_page_url')) form.querySelector('#facebook_page_url').value = data.record.facebook_page_url || '';
                        
                        // Handle municipality and barangay after province change
                        setTimeout(() => {
                            if (form.querySelector('#municipality') && data.record.municipality) {
                                form.querySelector('#municipality').value = data.record.municipality;
                                form.querySelector('#municipality').dispatchEvent(new Event('change'));
                            }
                            setTimeout(() => {
                                if (form.querySelector('#barangay') && data.record.barangay) {
                                    form.querySelector('#barangay').value = data.record.barangay;
                                }
                            }, 100);
                        }, 100);
                    }
                }
            })
            .catch(error => console.error('Error fetching latest record:', error));
    }
    
    // Function to show modal
    function showAddRecordModal() {
        console.log('Opening modal');
        if (addRecordDialog && addRecordBackdrop) {
            // Center the modal
            var viewportWidth = window.innerWidth;
            var viewportHeight = window.innerHeight;
            var dialogWidth = Math.min(640, viewportWidth - 32);
            var dialogHeight = Math.min(500, viewportHeight - 32);
            
            var left = Math.max(16, (viewportWidth - dialogWidth) / 2);
            var top = Math.max(16, (viewportHeight - dialogHeight) / 2);
            
            addRecordDialog.style.left = left + 'px';
            addRecordDialog.style.top = top + 'px';
            addRecordDialog.style.width = dialogWidth + 'px';
            addRecordDialog.style.display = 'block';
            addRecordBackdrop.style.display = 'block';
            document.body.style.overflow = 'hidden';
            document.documentElement.style.overflow = 'hidden';
            
            // Fetch and populate with latest record
            populateFormWithLatestRecord();
        }
    }
    
    // Function to hide modal
    function hideAddRecordModal() {
        if (addRecordDialog && addRecordBackdrop) {
            addRecordDialog.style.display = 'none';
            addRecordBackdrop.style.display = 'none';
            document.body.style.overflow = '';
            document.documentElement.style.overflow = '';
            
            // Clear saved location values when manually closing
            clearLocationValues();
        }
    }
    
    // Save location values to localStorage
    function saveLocationValues() {
        var province = document.getElementById('province');
        var municipality = document.getElementById('municipality');
        var barangay = document.getElementById('barangay');
        
        if (province && municipality && barangay) {
            console.log('Saving location values:', province.value, municipality.value, barangay.value);
            localStorage.setItem('facebook_province', province.value);
            localStorage.setItem('facebook_municipality', municipality.value);
            localStorage.setItem('facebook_barangay', barangay.value);
        }
    }
    
    // Clear location values from localStorage
    function clearLocationValues() {
        localStorage.removeItem('facebook_province');
        localStorage.removeItem('facebook_municipality');
        localStorage.removeItem('facebook_barangay');
    }
    
    // Add form submission handler to save location values
    var addRecordForm = addRecordDialog ? addRecordDialog.querySelector('form[action="{{ route('records') }}"]') : null;
    if (addRecordForm) {
        addRecordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Form submit event triggered');
            
            // Save current form values before submission
            var dateReceivedValue = addRecordForm.querySelector('#date_received') ? addRecordForm.querySelector('#date_received').value : '';
            var modeOfPaymentValue = addRecordForm.querySelector('#modeOfPayment') ? addRecordForm.querySelector('#modeOfPayment').value : '';
            var provinceValue = addRecordForm.querySelector('#province') ? addRecordForm.querySelector('#province').value : '';
            var municipalityValue = addRecordForm.querySelector('#municipality') ? addRecordForm.querySelector('#municipality').value : '';
            var barangayValue = addRecordForm.querySelector('#barangay') ? addRecordForm.querySelector('#barangay').value : '';
            var accountsValue = addRecordForm.querySelector('#accounts') ? addRecordForm.querySelector('#accounts').value : '';
            var facebookPageUrlValue = addRecordForm.querySelector('#facebook_page_url') ? addRecordForm.querySelector('#facebook_page_url').value : '';
            
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
                    // Restore retained values
                    if (addRecordForm.querySelector('#date_received')) addRecordForm.querySelector('#date_received').value = dateReceivedValue;
                    if (addRecordForm.querySelector('#modeOfPayment')) addRecordForm.querySelector('#modeOfPayment').value = modeOfPaymentValue;
                    if (addRecordForm.querySelector('#province')) addRecordForm.querySelector('#province').value = provinceValue;
                    if (addRecordForm.querySelector('#municipality')) addRecordForm.querySelector('#municipality').value = municipalityValue;
                    if (addRecordForm.querySelector('#barangay')) addRecordForm.querySelector('#barangay').value = barangayValue;
                    if (addRecordForm.querySelector('#accounts')) addRecordForm.querySelector('#accounts').value = accountsValue;
                    if (addRecordForm.querySelector('#facebook_page_url')) addRecordForm.querySelector('#facebook_page_url').value = facebookPageUrlValue;
                    
                    // Clear other fields
                    if (addRecordForm.querySelector('#farmerName')) addRecordForm.querySelector('#farmerName').value = '';
                    if (addRecordForm.querySelector('#line')) addRecordForm.querySelector('#line').value = '';
                    if (addRecordForm.querySelector('#program')) addRecordForm.querySelector('#program').value = '';
                    if (addRecordForm.querySelector('#causeOfDamage')) addRecordForm.querySelector('#causeOfDamage').value = '';
                    if (addRecordForm.querySelector('#date_occurrence')) addRecordForm.querySelector('#date_occurrence').value = '';
                    if (addRecordForm.querySelector('#remarks')) addRecordForm.querySelector('#remarks').value = '';
                    if (addRecordForm.querySelector('#controlNumber')) addRecordForm.querySelector('#controlNumber').value = '';
                } else {
                    showModalMessage(data.message || 'Error adding record', 'error');
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
    
    // Close button functionality
    if (closeAddRecordModal) {
        closeAddRecordModal.addEventListener('click', hideAddRecordModal);
    }
    
    // Close on backdrop click
    if (addRecordBackdrop) {
        addRecordBackdrop.addEventListener('click', hideAddRecordModal);
    }
    
    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && addRecordDialog && addRecordDialog.style.display === 'block') {
            hideAddRecordModal();
        }
    });
    
    // Make showAddRecordModal available globally
    window.showAddRecordModal = showAddRecordModal;
    
    // Add event listener to the add record button
    var addRecordButton = document.querySelector('.addRecordButton');
    if (addRecordButton) {
        addRecordButton.addEventListener('click', showAddRecordModal);
    }
})();

// Make the DIV element draggagle (W3Schools approach)
dragElement(document.getElementById("addRecordDialog"));

function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id + "header")) {
    document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
  } else {
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
  }

  function closeDragElement() {
    document.onmouseup = null;
    document.onmousemove = null;
  }
}
</script>
@endpush

@endsection