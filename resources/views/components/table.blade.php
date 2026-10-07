@props(['records', 'showDelete' => true, 'showEncoder' => false, 'showApproval' => false, 'showAction' => false, 'showCheckbox' => true, 'showFilters' => false, 'showSortableHeaders' => true, 'showAdminTransmittal' => false, 'showNoticeImage' => false, 'hideAccountsColumn' => false, 'hideSourceColumn' => false, 'hideProvinceColumn' => false, 'hideDateReceivedColumn' => false, 'useDateEncodedAsDateReceived' => false, 'allPrograms' => [], 'allLines' => [], 'allSources' => [], 'allModes' => []])

@vite('resources/css/pages/records-table.css')

@vite('resources/js/pages/records-table.js')

@php
$currentSort = request('sort_by', 'id');
$currentOrder = request('sort_order', 'desc');
$oppositeOrder = $currentOrder === 'asc' ? 'desc' : 'asc';

// Helper to generate sort URL
if (! function_exists('getSortUrl')) {
    function getSortUrl($column, $currentSort, $currentOrder, $oppositeOrder) {
        $newOrder = $currentSort === $column ? $oppositeOrder : 'asc';
        return url()->current() . '?' . http_build_query(array_merge(request()->query(), ['sort_by' => $column, 'sort_order' => $newOrder]));
    }
}

// Helper to get sort indicator
if (! function_exists('getSortIndicator')) {
    function getSortIndicator($column, $currentSort, $currentOrder) {
        if ($currentSort === $column) {
            return $currentOrder === 'asc' ? ' ▲' : ' ▼';
        }
        return '';
    }
}
@endphp

@if($showFilters)
<div class="table-filters" style="margin-bottom: 15px; padding: 15px; background: #f0fdf4; border: 1px solid rgba(0, 108, 53, 0.18); border-radius: 16px;">
    <form method="GET" style="display: contents;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">

            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Control Number</label>
                <input type="text" placeholder="Control Number" name="transmittal_number" value="{{ request('transmittal_number') }}" style="width: 100%; padding: 5px;">
            </div>


            @if($showEncoder)
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Encoder</label>
                <input type="text" placeholder="Search Encoder" name="encoderName" value="{{ request('encoderName') }}" style="width: 100%; padding: 5px;">
            </div>
            @endif


            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Farmer Name</label>
                <input type="text" placeholder="Search Farmer" name="farmerName" value="{{ request('farmerName') }}" style="width: 100%; padding: 5px;">
            </div>


            @if(!$hideProvinceColumn)
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Municipality</label>
                <input type="text" placeholder="Municipality" name="municipality" value="{{ request('municipality') }}" style="width: 100%; padding: 5px;">
            </div>
            @endif


            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Barangay</label>
                <input type="text" placeholder="Barangay" name="barangay" value="{{ request('barangay') }}" style="width: 100%; padding: 5px;">
            </div>


            @if(!$hideProvinceColumn)
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Province</label>
                <input type="text" placeholder="Province" name="province" value="{{ request('province') }}" style="width: 100%; padding: 5px;">
            </div>
            @endif


            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Line</label>
                <select name="line" style="width: 100%; padding: 5px;">
                    <option value="">All Lines</option>
                    @foreach($allLines as $line)
                    <option value="{{ $line }}" {{ request('line') == $line ? 'selected' : '' }}>{{ $line }}</option>
                    @endforeach
                </select>
            </div>


            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Program</label>
                <select name="program" style="width: 100%; padding: 5px;">
                    <option value="">All Programs</option>
                    @foreach($allPrograms as $program)
                    <option value="{{ $program }}" {{ request('program') == $program ? 'selected' : '' }}>{{ $program }}</option>
                    @endforeach
                </select>
            </div>


            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Date of Occurrence</label>
                <select name="date_occurrence_filter_type" style="width: 100%; padding: 5px; margin-bottom: 5px;">
                    <option value="">Filter Type</option>
                    <option value="single" {{ request('date_occurrence_filter_type') == 'single' ? 'selected' : '' }}>Single Date</option>
                    <option value="range" {{ request('date_occurrence_filter_type') == 'range' ? 'selected' : '' }}>Date Range</option>
                </select>
                <div id="date_occurrence_single" style="display: {{ request('date_occurrence_filter_type') == 'single' ? 'block' : 'none' }};">
                    <input type="date" name="date_occurrence" value="{{ request('date_occurrence') }}" style="width: 100%; padding: 5px;">
                </div>
                <div id="date_occurrence_range" style="display: {{ request('date_occurrence_filter_type') == 'range' ? 'block' : 'none' }};">
                    <input type="date" name="date_occurrence_from" value="{{ request('date_occurrence_from') }}" placeholder="From" style="width: 100%; padding: 5px; margin-bottom: 5px;">
                    <input type="date" name="date_occurrence_to" value="{{ request('date_occurrence_to') }}" placeholder="To" style="width: 100%; padding: 5px;">
                </div>
            </div>


            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Cause of Damage</label>
                <input type="text" placeholder="Damage" name="causeOfDamage" value="{{ request('causeOfDamage') }}" style="width: 100%; padding: 5px;">
            </div>


            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Date Received</label>
                <select name="date_received_filter_type" style="width: 100%; padding: 5px; margin-bottom: 5px;">
                    <option value="">Filter Type</option>
                    <option value="single" {{ request('date_received_filter_type') == 'single' ? 'selected' : '' }}>Single Date</option>
                    <option value="range" {{ request('date_received_filter_type') == 'range' ? 'selected' : '' }}>Date Range</option>
                </select>
                <div id="date_received_single" style="display: {{ request('date_received_filter_type') == 'single' ? 'block' : 'none' }};">
                    <input type="date" name="date_received" value="{{ request('date_received') }}" style="width: 100%; padding: 5px;">
                </div>
                <div id="date_received_range" style="display: {{ request('date_received_filter_type') == 'range' ? 'block' : 'none' }};">
                    <input type="date" name="date_received_from" value="{{ request('date_received_from') }}" placeholder="From" style="width: 100%; padding: 5px; margin-bottom: 5px;">
                    <input type="date" name="date_received_to" value="{{ request('date_received_to') }}" placeholder="To" style="width: 100%; padding: 5px;">
                </div>
            </div>


            @if(!$hideAccountsColumn)
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Account</label>
                <input type="text" placeholder="Account" name="accounts" value="{{ request('accounts') }}" style="width: 100%; padding: 5px;">
            </div>
            @endif


            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Mode of Payment</label>
                <select name="modeOfPayment" style="width: 100%; padding: 5px;">
                    <option value="">All Modes</option>
                    @foreach($allModes as $mode)
                    <option value="{{ $mode }}" {{ request('modeOfPayment') == $mode ? 'selected' : '' }}>{{ $mode }}</option>
                    @endforeach
                </select>
            </div>


            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Remarks</label>
                <input type="text" placeholder="Remarks" name="remarks" value="{{ request('remarks') }}" style="width: 100%; padding: 5px;">
            </div>

            @if($showAdminTransmittal)
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Admin Transmittal</label>
                <input type="text" placeholder="Admin Transmittal" name="admin_transmittal_number" value="{{ request('admin_transmittal_number') }}" style="width: 100%; padding: 5px;">
            </div>
            @endif

            @if($showApproval)
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Status</label>
                <select name="approved" style="width: 100%; padding: 5px;">
                    <option value="">All Status</option>
                    <option value="1" {{ request('approved') == '1' ? 'selected' : '' }}>Approved</option>
                    <option value="0" {{ request('approved') == '0' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            @endif


            <div style="display: flex; gap: 10px;">
                <button type="submit" style="padding: 8px 16px; background: #006c35; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 800; font-size: 13px; letter-spacing: 0.2px; transition: background 0.15s ease;">Apply Filters</button>
                <a href="{{ request()->url() }}" style="padding: 8px 16px; background: #64748b; color: white; text-decoration: none; border-radius: 10px; font-weight: 800; font-size: 13px; letter-spacing: 0.2px;">Clear</a>
            </div>
        </div>
    </form>
</div>
@endif


<div class="table-scroll-sync-top" id="table-scroll-top-{{ $showCheckbox ? '1' : '0' }}-{{ $showAdminTransmittal ? '1' : '0' }}">
    <div class="table-scroll-spacer" id="table-scroll-spacer-{{ $showCheckbox ? '1' : '0' }}-{{ $showAdminTransmittal ? '1' : '0' }}"></div>
</div>

<div class="table-wrapper" id="table-wrapper-{{ $showCheckbox ? '1' : '0' }}-{{ $showAdminTransmittal ? '1' : '0' }}">
<table class="records-table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
    <thead>
        <tr>
            @if($showCheckbox)
            <th class="no-print col-checkbox" style="display: none;">
                <input type="checkbox" id="select-all">
            </th>
            @endif
            @if(!$hideAccountsColumn && $showAdminTransmittal)
            <th class="no-print col-checkbox-transmit" style="display: none;">
                <input type="checkbox" id="select-all-transmit" style="display: none;">
            </th>
            @endif
            <th class="no-print col-edit">Edit</th>
            @if($showDelete)
            <th class="no-print col-delete">Delete</th>
            <th class="no-print col-view">View</th>
            @endif
            @if($showNoticeImage)
            <th class="no-print col-notice-image">Notice Image</th>
            @endif

            @if(!$hideDateReceivedColumn)
            <th class="col-date-received">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('date_received', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Date Received{{ getSortIndicator('date_received', $currentSort, $currentOrder) }}</a>
                @else
                Date Received
                @endif
            </th>
            @endif


            @if($showEncoder)
            <th class="col-encoder">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('encoderName', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Encoder{{ getSortIndicator('encoderName', $currentSort, $currentOrder) }}</a>
                @else
                Encoder
                @endif
            </th>
            @endif


            <th class="col-farmer-name">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('farmerName', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Farmer Name{{ getSortIndicator('farmerName', $currentSort, $currentOrder) }}</a>
                @else
                Farmer Name
                @endif
            </th>


            @if(!$hideProvinceColumn)
            <th class="col-municipality">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('municipality', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Municipality{{ getSortIndicator('municipality', $currentSort, $currentOrder) }}</a>
                @else
                Municipality
                @endif
            </th>
            @endif


            <th class="col-barangay">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('barangay', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">{{ $hideProvinceColumn ? 'Address' : 'Barangay' }}{{ getSortIndicator('barangay', $currentSort, $currentOrder) }}</a>
                @else
                {{ $hideProvinceColumn ? 'Address' : 'Barangay' }}
                @endif
            </th>


            @if(!$hideProvinceColumn)
            <th class="col-province">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('province', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Province{{ getSortIndicator('province', $currentSort, $currentOrder) }}</a>
                @else
                Province
                @endif
            </th>
            @endif


            <th class="col-line">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('line', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Line{{ getSortIndicator('line', $currentSort, $currentOrder) }}</a>
                @else
                Line
                @endif
            </th>


            <th class="col-program">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('program', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Program{{ getSortIndicator('program', $currentSort, $currentOrder) }}</a>
                @else
                Program
                @endif
            </th>


            <th class="col-date-occurrence">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('date_occurrence', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Date of Occurrence{{ getSortIndicator('date_occurrence', $currentSort, $currentOrder) }}</a>
                @else
                Date of Occurrence
                @endif
            </th>


            <th class="col-causeOfDamage">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('causeOfDamage', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Cause of Damage{{ getSortIndicator('causeOfDamage', $currentSort, $currentOrder) }}</a>
                @else
                Cause of Damage
                @endif
            </th>


            <th class="col-control-number">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('transmittal_number', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Control Number{{ getSortIndicator('transmittal_number', $currentSort, $currentOrder) }}</a>
                @else
                Control Number
                @endif
            </th>



            @if(!$hideAccountsColumn)
            <th class="col-accounts">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('accounts', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Account{{ getSortIndicator('accounts', $currentSort, $currentOrder) }}</a>
                @else
                Account
                @endif
            </th>
            @endif


            <th class="col-modeOfPayment">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('modeOfPayment', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Mode of Payment{{ getSortIndicator('modeOfPayment', $currentSort, $currentOrder) }}</a>
                @else
                Mode of Payment
                @endif
            </th>


            <th class="col-remarks">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('remarks', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Remarks{{ getSortIndicator('remarks', $currentSort, $currentOrder) }}</a>
                @else
                Remarks
                @endif
            </th>


            <th class="col-date-encoded">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('created_at', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Date Encoded{{ getSortIndicator('created_at', $currentSort, $currentOrder) }}</a>
                @else
                Date Encoded
                @endif
            </th>
            @if($showAdminTransmittal)
            <th class="col-admin-transmittal-number">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('admin_transmittal_number', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Transmittal Num{{ getSortIndicator('admin_transmittal_number', $currentSort, $currentOrder) }}</a>
                @else
                Transmittal Num
                @endif
            </th>
            @endif
            @if($showApproval)
            <th class="col-status">
                @if($showSortableHeaders)
                <a href="{{ getSortUrl('approved', $currentSort, $currentOrder, $oppositeOrder) }}" style="color: inherit; text-decoration: none; cursor: pointer;">Status{{ getSortIndicator('approved', $currentSort, $currentOrder) }}</a>
                @else
                Status
                @endif
            </th>
            @endif
            @if($showAction)
            <th class="no-print">Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
    @foreach($records as $record)
        <tr class="{{ !$record->approved ? 'pending' : '' }} record-row" data-record-id="{{ $record->id }}">
            @if($showCheckbox)
            <td class="no-print col-checkbox" style="display: none;">
                <input type="checkbox" name="record_ids[]" value="{{ $record->id }}" class="record-checkbox">
            </td>
            @endif
            @if(!$hideAccountsColumn && $showAdminTransmittal)
            <td class="no-print col-checkbox-transmit" style="display: none;">
                <input type="checkbox" name="record_ids_transmit[]" value="{{ $record->id }}" class="record-checkbox-transmit" data-source="{{ $record->source }}" style="display: none;">
            </td>
            @endif
            <td class="no-print col-edit">
                <button type="button" class="editButton"
                data-id="{{ $record->id }}"
                data-farmer-name="{{ e($record->farmerName) }}"
                data-province="{{ e($record->province) }}"
                data-municipality="{{ e($record->municipality) }}"
                data-barangay="{{ e($record->barangay) }}"
                data-address="{{ e($record->address) }}"
                data-program="{{ e($record->program) }}"
                data-line="{{ e($record->line) }}"
                data-cause-of-damage="{{ e($record->causeOfDamage) }}"
                data-mode-of-payment="{{ e($record->modeOfPayment) }}"
                data-accounts="{{ e($record->accounts) }}"
                data-fb-page-url="{{ e($record->facebook_page_url ?? '') }}"
                data-date-occurrence="{{ e($record->date_occurrence ?? '') }}"
                data-date-received="{{ e($record->date_received ? $record->date_received->format('Y-m-d') : '') }}"
                data-created-at="{{ e($record->created_at ? $record->created_at->format('M d, Y') : '') }}"
                data-remarks="{{ e($record->remarks) }}"
                data-control-number="{{ e($record->control_number ?? '') }}"
                data-source="{{ e($record->source) }}"
                data-transmittal-number="{{ e($record->transmittal_number) }}"
                data-admin-transmittal-number="{{ e($record->admin_transmittal_number) }}"
                data-admin-transmittal-assigned-at="{{ $record->admin_transmittal_assigned_at ? e(is_string($record->admin_transmittal_assigned_at) ? date('M d, Y', strtotime($record->admin_transmittal_assigned_at)) : $record->admin_transmittal_assigned_at->format('M d, Y')) : 'N/A' }}"
                data-notice-images="{{ $record->attachments->where('type', 'image')->map(fn ($attachment) => ['id' => $attachment->id, 'name' => $attachment->original_name, 'url' => route('records.attachments.show', [$record, $attachment])])->values()->toJson() }}"
                data-notice-pdfs="{{ $record->attachments->where('type', 'pdf')->map(fn ($attachment) => ['id' => $attachment->id, 'name' => $attachment->original_name, 'url' => route('records.attachments.show', [$record, $attachment])])->values()->toJson() }}"
                >edit</button>
            </td>
            @if($showDelete)
            <td class="no-print col-delete">
                <button type="button" class="deleteButton" data-id="{{ $record->id }}" data-farmer-name="{{ $record->farmerName }}">
                    delete
                </button>
            </td>
            <td class="no-print col-view">
                <button class="view-record-btn" data-record-id="{{ $record->id }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    View
                </button>
            </td>
            @endif
            @if($showNoticeImage)
            <td class="no-print col-notice-image">
                @if($record->attachments->where('type', 'image')->isNotEmpty())
                    <button
                        type="button"
                        class="notice-image-view-btn"
                        data-image-urls="{{ $record->attachments->where('type', 'image')->map(fn ($attachment) => route('records.attachments.show', [$record, $attachment]))->values()->toJson() }}"
                        data-farmer-name="{{ $record->farmerName }}"
                    >View / Print photos</button>
                @else
                    <span class="notice-image-unavailable">—</span>
                @endif
            </td>
            @endif
            @if(!$hideDateReceivedColumn)

            <td class="col-date-received">
                @if($useDateEncodedAsDateReceived)
                    {{ $record->created_at ? $record->created_at->format('M d, Y') : '—' }}
                @else
                    {{ $record->date_received ? (is_string($record->date_received) ? $record->date_received : $record->date_received->format('M d, Y')) : '—' }}
                @endif
            </td>
            @endif


            @if($showEncoder)
            <td class="col-encoder">{{ $record->encoderName ?? 'Unknown' }}</td>
            @endif


            <td class="col-farmer-name">
                <span class="farmer-name-copy cursor-pointer transition-colors" style="color: inherit;" data-farmer-name="{{ e($record->farmerName) }}" title="Click to copy farmer name">{{ $record->farmerName }}</span>
            </td>


            @if(!$hideProvinceColumn)
            <td class="col-municipality">{{ $record->municipality ?? '—' }}</td>
            @endif


            <td class="col-barangay">
                @if($hideProvinceColumn)
                    {{ trim(implode(', ', array_filter([$record->barangay, $record->municipality]))) ?: '—' }}
                @else
                    {{ $record->barangay ?? '—' }}
                @endif
            </td>


            @if(!$hideProvinceColumn)
            <td class="col-province">{{ $record->province ?? '—' }}</td>
            @endif


            <td class="col-line">{{ $record->line }}</td>


            <td class="col-program">{{ $record->program }}</td>


            <td class="col-date-occurrence">{{ $record->date_occurrence ? $record->date_occurrence : '—' }}</td>


            <td class="col-causeOfDamage">{{ $record->causeOfDamage }}</td>


            <td class="col-control-number">{{ $record->control_number ?? '—' }}</td>


            @if(!$hideAccountsColumn)
            <td class="col-accounts">
                @php
                    $accountLabel = $record->accounts;
                    $fbUrl = $record->facebook_page_url ?? '';
                    $isFacebook = ($record->source ?? '') === 'Facebook';
                    $href = $fbUrl && filter_var($fbUrl, FILTER_VALIDATE_URL) ? $fbUrl : null;
                @endphp
                @if($isFacebook && $href && $accountLabel)
                    <a href="{{ e($href) }}" target="_blank" rel="noopener noreferrer" class="account-field">{{ e($accountLabel) }}</a>
                @elseif($accountLabel)
                    <span class="account-field">{{ $accountLabel }}</span>
                @else
                    <span class="account-field">—</span>
                @endif
            </td>
            @endif


            <td class="col-modeOfPayment">{{ $record->modeOfPayment ?: '—' }}</td>


            <td class="col-remarks">{{ $record->remarks }}</td>


            <td class="col-date-encoded">{{ $record->created_at ? $record->created_at->format('M d, Y') : '—' }}</td>
            @if($showAdminTransmittal)
            <td class="col-admin-transmittal-number">{{ empty($record->admin_transmittal_number) ? '—' : $record->admin_transmittal_number }}</td>
            @endif
            @if($showApproval)
            <td class="col-status">{{ $record->approved ? 'Approved' : 'Pending' }}</td>
            @endif
            @if($showAction)
            <td class="no-print">
                @if(!$record->approved)
                    <a href="{{ route('admin.records.approve', $record->id) }}" class="no-print">Approve</a>
                @else
                    &mdash;
                @endif
            </td>
            @endif
        </tr>
            @endforeach
    </tbody>
</table>
</div>


<div class="table-scroll-sync-bottom" id="table-scroll-bottom-{{ $showCheckbox ? '1' : '0' }}-{{ $showAdminTransmittal ? '1' : '0' }}">
    <div class="table-scroll-spacer" id="table-scroll-spacer-bottom-{{ $showCheckbox ? '1' : '0' }}-{{ $showAdminTransmittal ? '1' : '0' }}"></div>
</div>

    @if($records->isEmpty())
<div class="empty-state" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 20px;text-align:center;">
    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-bottom:16px;opacity:0.5;">
        <rect x="18" y="8" width="44" height="56" rx="6" stroke="#006c35" stroke-width="2.5" fill="#f0fdf4"/>
        <rect x="28" y="4" width="24" height="12" rx="4" stroke="#006c35" stroke-width="2.5" fill="#fff"/>
        <line x1="28" y1="28" x2="52" y2="28" stroke="#86efac" stroke-width="2.5" stroke-linecap="round"/>
        <line x1="28" y1="38" x2="48" y2="38" stroke="#86efac" stroke-width="2.5" stroke-linecap="round"/>
        <line x1="28" y1="48" x2="42" y2="48" stroke="#86efac" stroke-width="2.5" stroke-linecap="round"/>
        <circle cx="58" cy="58" r="14" fill="#006c35"/>
        <path d="M51 58l4 4 9-9" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <div style="font-size:16px;color:#475569;font-weight:600;margin-bottom:8px;">No records found</div>
    <div style="font-size:13px;color:#64748b;margin-top:4px;font-weight:600;">Records will appear here once they are added.</div>
</div>
    @endif






<div id="viewRecordModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; padding: 20px; box-sizing: border-box;">
    <div style="background: white; max-width: 800px; margin: 0 auto; border-radius: 12px; max-height: 90vh; overflow: hidden; position: relative; top: 50%; transform: translateY(-50%);">

        <div style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px; font-weight: bold;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                Record Details
            </h3>
            <button type="button" id="closeModalBtn" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 6px; transition: background 0.2s;">
                ×
            </button>
        </div>


        <div style="padding: 20px; max-height: 60vh; overflow-y: auto;">
            <div id="recordDetails">

            </div>
        </div>


        <div style="background: #f8f9fa; padding: 15px 20px; border-top: 1px solid #e9ecef; text-align: right;">
            <button type="button" id="closeModalFooterBtn" style="background: #6c757d; color: white; border: none; padding: 8px 20px; border-radius: 6px; cursor: pointer; font-size: 14px;">Close</button>
        </div>
    </div>
</div>

@include('components.notice-image-print-dialog')
