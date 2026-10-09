<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\RecordAttachment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RecordsController extends Controller
{
    public function storeRecord(Request $request)
    {
        // Always return JSON for this endpoint since it's used by AJAX forms
        $isAjax = true;

        // Validate the incoming request data
        $source = $request->input('source', 'OD');

        $validatedData = $request->validate([
            'farmerName' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'line' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'causeOfDamage' => 'required|string|max:255',
            'modeOfPayment' => 'required|string|max:255',
            'accounts' => ['required_if:source,Facebook', 'string', 'max:255'],
            'facebook_page_url' => [
                'nullable',
                'string',
                'max:5000',
                Rule::when($request->filled('facebook_page_url'), ['regex:/^https?:\/\/.+/i']),
            ],
            'notice_images' => 'nullable|array',
            'notice_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:30720',
            'notice_pdfs' => 'nullable|array',
            'notice_pdfs.*' => 'file|mimes:pdf|max:30720',
            'notice_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:30720',
            'notice_pdf' => 'nullable|file|mimes:pdf|max:30720',
            'date_occurrence' => 'nullable|string|max:500',
            'date_received' => 'nullable|date',
            'remarks' => 'nullable|string|max:255',
            'control_number' => 'nullable|string|max:255',
            'source' => 'nullable|string|in:OD,Email,Facebook',
        ]);

        foreach (['line', 'province', 'municipality', 'barangay'] as $locationField) {
            $validatedData[$locationField] = mb_strtoupper(trim($validatedData[$locationField]), 'UTF-8');
        }

        if ($source !== 'Facebook') {
            $validatedData['facebook_page_url'] = null;
        }

        $noticeImages = $this->uploadedFiles($request, 'notice_images', 'notice_image');
        $noticePdfs = $this->uploadedFiles($request, 'notice_pdfs', 'notice_pdf');
        unset($validatedData['notice_images'], $validatedData['notice_pdfs'], $validatedData['notice_image'], $validatedData['notice_pdf']);

        // Check authentication based on source
        if ($source === 'OD') {
            if (! $request->session()->has('officer_name')) {
                $message = 'Please log in as Officer of the Day first.';

                return $isAjax ? response()->json(['success' => false, 'message' => $message], 401)
                              : redirect()->back()->with('error', $message);
            }
        } elseif ($source === 'Email') {
            if (! $request->session()->has('email_logged_in') || ! $request->session()->has('email_user_name')) {
                $message = 'Please log in to Email handler first.';

                return $isAjax ? response()->json(['success' => false, 'message' => $message], 401)
                              : redirect()->back()->with('error', $message);
            }
        } elseif ($source === 'Facebook') {
            if (! $request->session()->has('facebook_logged_in')) {
                $message = 'Please log in to Facebook handler first.';

                return $isAjax ? response()->json(['success' => false, 'message' => $message], 401)
                              : redirect()->back()->with('error', $message);
            }
        }

        $encoderName = null;
        $encoderId = null;

        if ($source === 'Email') {
            $encoderName = $request->session()->get('email_user_name');
            $encoderId = $request->session()->get('email_user_id');
            if (! $encoderName || ! $encoderId) {
                $message = 'Unauthorized access. Please log in again.';

                return $isAjax ? response()->json(['success' => false, 'message' => $message], 401)
                              : redirect()->back()->with('error', $message);
            }
        } elseif ($source === 'Facebook') {
            $encoderName = $request->session()->get('facebook_user');
            $encoderId = $request->session()->get('facebook_user_id');
            if (! $encoderName || ! $encoderId) {
                $message = 'Unauthorized access. Please log in again.';

                return $isAjax ? response()->json(['success' => false, 'message' => $message], 401)
                              : redirect()->back()->with('error', $message);
            }
        } else {
            // For OD
            $encoderName = $request->session()->get('officer_name');
            $encoderId = $request->session()->get('officer_id');
            if (! $encoderName || ! $encoderId) {
                $message = 'Unauthorized access. Please log in again.';

                return $isAjax ? response()->json(['success' => false, 'message' => $message], 401)
                              : redirect()->back()->with('error', $message);
            }
        }

        $address = trim(implode(', ', array_filter([
            $validatedData['barangay'],
            $validatedData['municipality'],
            $validatedData['province'],
        ])));

        $noticeImagePaths = [];
        $noticePdfPaths = [];
        $storedAttachmentPaths = [];
        $recordCreated = false;

        try {
            // Validate address before proceeding
            if (empty(trim($address))) {
                throw new \Exception('Address cannot be empty. Please select valid municipality and barangay.');
            }

            // Use database transaction to ensure data consistency
            DB::beginTransaction();

            foreach ($noticeImages as $noticeImage) {
                $noticeImagePath = $noticeImage->store('claim-notices', 'local');
                if (! $noticeImagePath) {
                    throw new \RuntimeException('Unable to store the notice image.');
                }

                $noticeImagePaths[] = $noticeImagePath;
                $storedAttachmentPaths[] = $noticeImagePath;
            }

            foreach ($noticePdfs as $noticePdf) {
                $noticePdfPath = $noticePdf->store('claim-pdfs', 'local');
                if (! $noticePdfPath) {
                    throw new \RuntimeException('Unable to store the notice PDF.');
                }

                $noticePdfPaths[] = $noticePdfPath;
                $storedAttachmentPaths[] = $noticePdfPath;
            }

            // Prepare record data
            $recordData = array_merge($validatedData, [
                'address' => $address,
                'encoderName' => $encoderName,
                'source' => $request->source ?? 'OD',
                'approved' => true,
                'approved_at' => now(),
                'notice_image_path' => $noticeImagePaths[0] ?? null,
                'notice_pdf_path' => $noticePdfPaths[0] ?? null,
            ]);

            // Add encoder_id if available
            if ($encoderId) {
                $recordData['encoder_id'] = $encoderId;
            }

            // Set date_received to today if not provided (especially for Email records)
            if (! isset($recordData['date_received']) || empty($recordData['date_received'])) {
                $recordData['date_received'] = now()->format('Y-m-d');
            }

            $record = Record::create($recordData);

            foreach ($noticeImages as $index => $noticeImage) {
                $record->attachments()->create([
                    'type' => 'image',
                    'path' => $noticeImagePaths[$index],
                    'original_name' => $noticeImage->getClientOriginalName(),
                ]);
            }

            foreach ($noticePdfs as $index => $noticePdf) {
                $record->attachments()->create([
                    'type' => 'pdf',
                    'path' => $noticePdfPaths[$index],
                    'original_name' => $noticePdf->getClientOriginalName(),
                ]);
            }

            // Store last used location in session for auto-population
            $sessionKey = 'last_location_'.$recordData['source'];
            $request->session()->put($sessionKey, [
                'province' => $recordData['province'],
                'municipality' => $recordData['municipality'],
                'barangay' => $recordData['barangay'],
            ]);

            DB::commit();
            $recordCreated = true;

            Log::info('Record created successfully', ['record_id' => $record->id, 'isAjax' => $isAjax]);

            // Return success response
            $successMessage = 'Record stored successfully.';
            if ($isAjax) {
                $response = response()->json([
                    'success' => true,
                    'message' => $successMessage,
                    'record' => $record,
                ]);
                Log::info('Returning JSON response', ['response' => $response->getContent()]);

                return $response;
            }

            return redirect()->back()->with('success', $successMessage);

        } catch (ValidationException $e) {
            // Handle validation exceptions specifically
            DB::rollBack();
            Log::error('Validation failed during record creation', [
                'error' => $e->getMessage(),
                'errors' => $e->errors(),
                'user' => $encoderName,
                'source' => $request->source ?? 'OD',
                'data' => $request->all(),
            ]);

            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed. Please check your input.',
                    'errors' => $e->errors(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (QueryException $e) {
            // Handle database query exceptions specifically
            DB::rollBack();
            Log::error('Database error during record creation', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'user' => $encoderName,
                'source' => $request->source ?? 'OD',
                'data' => $validatedData,
            ]);

            $errorMessage = 'Database error occurred. Please try again. If the problem persists, contact an administrator.';
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ], 500);
            }

            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();

        } catch (\Exception $e) {
            // Handle all other exceptions
            DB::rollBack();

            // Log the error for debugging
            Log::error('Record creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user' => $encoderName,
                'source' => $request->source ?? 'OD',
                'data' => $validatedData,
            ]);

            // Return user-friendly error message
            $errorMessage = 'Unable to save record. Please try again. If the problem persists, contact an administrator.';
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ], 500);
            }

            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        } finally {
            if (! $recordCreated) {
                foreach ($storedAttachmentPaths as $storedAttachmentPath) {
                    if (! Storage::disk('local')->delete($storedAttachmentPath)) {
                        Log::warning('Unable to remove attachment after failed record creation', [
                            'path' => $storedAttachmentPath,
                        ]);
                    }
                }
            }
        }
    }

    public function updateRecord(Request $request, $id)
    {
        Log::info('=== UPDATE RECORD METHOD STARTED ===', [
            'id' => $id,
            'data' => $request->all(),
            'clear_admin_transmittal_number' => $request->input('clear_admin_transmittal_number'),
            'has_clear_checkbox' => $request->has('clear_admin_transmittal_number'),
            'admin_transmittal_number' => $request->input('admin_transmittal_number'),
            'request_method' => $request->method(),
            'request_url' => $request->fullUrl(),
        ]);

        try {
            $record = Record::findOrFail($id);
            Log::info('Record found', ['id' => $id, 'current_admin_transmittal' => $record->admin_transmittal_number]);
        } catch (ModelNotFoundException $e) {
            Log::error('Record not found for update', ['id' => $id, 'error' => $e->getMessage()]);

            // Return JSON response for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found. It may have been deleted by another user. Please refresh the page and try again.',
                ], 404);
            }

            return redirect()->back()->with('error', 'Record not found. It may have been deleted by another user. Please refresh the page and try again.');
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'farmerName' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'line' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'causeOfDamage' => 'required|string|max:255',
            'modeOfPayment' => 'required|string|max:255',
            'accounts' => ['required_if:source,Facebook', 'nullable', 'string', 'max:255'],
            'facebook_page_url' => [
                'nullable',
                'string',
                'max:5000',
                Rule::requiredIf(function () use ($request) {
                    return $request->input('source') === 'Facebook' && ! empty($request->input('facebook_page_url'));
                }),
                Rule::when(! empty($request->input('facebook_page_url')), ['regex:/^https?:\/\/.+/i']),
            ],
            'date_occurrence' => 'nullable|string|max:500',
            'date_received' => 'nullable|date',
            'remarks' => 'nullable|string|max:255',
            'control_number' => 'nullable|string|max:255',
            'transmittal_number' => 'nullable|string|max:255',
            'admin_transmittal_number' => 'nullable|string|max:255',
            'notice_images' => 'nullable|array',
            'notice_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:30720',
            'notice_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:30720',
            'remove_notice_image' => 'nullable|boolean',
            'notice_pdfs' => 'nullable|array',
            'notice_pdfs.*' => 'file|mimes:pdf|max:30720',
            'notice_pdf' => 'nullable|file|mimes:pdf|max:30720',
            'remove_notice_pdf' => 'nullable|boolean',
            'remove_attachment_ids' => 'nullable|array',
            'remove_attachment_ids.*' => 'integer',
        ]);
        unset(
            $validatedData['notice_images'],
            $validatedData['notice_image'],
            $validatedData['remove_notice_image'],
            $validatedData['notice_pdfs'],
            $validatedData['notice_pdf'],
            $validatedData['remove_notice_pdf'],
            $validatedData['remove_attachment_ids']
        );

        $noticeImages = $this->uploadedFiles($request, 'notice_images', 'notice_image');
        $noticePdfs = $this->uploadedFiles($request, 'notice_pdfs', 'notice_pdf');
        $removeNoticeImage = $request->boolean('remove_notice_image') && $noticeImages === [];
        $removeNoticePdf = $request->boolean('remove_notice_pdf') && $noticePdfs === [];
        $replaceLegacyNoticeImage = $request->hasFile('notice_image') && ! $request->hasFile('notice_images');
        $replaceLegacyNoticePdf = $request->hasFile('notice_pdf') && ! $request->hasFile('notice_pdfs');
        $removeAttachmentIds = array_unique(array_map('intval', $request->input('remove_attachment_ids', [])));

        if ($removeNoticeImage || $removeNoticePdf || $replaceLegacyNoticeImage || $replaceLegacyNoticePdf || $removeAttachmentIds !== []) {
            $isAdmin = (bool) $request->session()->get('admin_logged_in', false);
            $emailEncoderId = $request->session()->get('email_user_id');
            $isEmailEncoder = $record->source === 'Email'
                && (bool) $request->session()->get('email_logged_in', false)
                && filled($emailEncoderId)
                && (string) $emailEncoderId === (string) $record->encoder_id;
            $facebookEncoderId = $request->session()->get('facebook_user_id');
            $isFacebookEncoder = $record->source === 'Facebook'
                && (bool) $request->session()->get('facebook_logged_in', false)
                && filled($facebookEncoderId)
                && (string) $facebookEncoderId === (string) $record->encoder_id;
            $officerId = $request->session()->get('officer_id');
            $isOfficerEncoder = $record->source === 'OD'
                && filled($request->session()->get('officer_name'))
                && filled($officerId)
                && (string) $officerId === (string) $record->encoder_id;

            abort_unless($isAdmin || $isEmailEncoder || $isFacebookEncoder || $isOfficerEncoder, 403);
        }

        if ($removeAttachmentIds !== []) {
            $matchingAttachmentCount = $record->attachments()->whereIn('id', $removeAttachmentIds)->count();
            abort_unless($matchingAttachmentCount === count($removeAttachmentIds), 404);
        }

        if (($validatedData['source'] ?? '') !== 'Facebook') {
            $validatedData['facebook_page_url'] = null;
        } elseif (! $request->has('facebook_page_url')) {
            unset($validatedData['facebook_page_url']);
        }

        $address = trim(implode(', ', array_filter([
            $request->barangay,
            $request->municipality,
            $request->province,
        ])));

        $updateData = array_merge($validatedData, ['address' => $address]);

        if (! $request->filled('transmittal_number')) {
            unset($updateData['transmittal_number']);
        }

        // Handle admin transmittal number clearing or setting
        if ($request->has('clear_admin_transmittal_number') && $request->input('clear_admin_transmittal_number') == '1') {
            $updateData['admin_transmittal_number'] = null;
            $updateData['admin_transmittal_assigned_at'] = null;
            Log::info('Clearing admin transmittal number', ['record_id' => $id]);
        } elseif ($request->filled('admin_transmittal_number')) {
            $updateData['admin_transmittal_number'] = $request->input('admin_transmittal_number');
            $updateData['admin_transmittal_assigned_at'] = now();
            Log::info('Setting admin transmittal number', ['record_id' => $id, 'transmittal_number' => $request->input('admin_transmittal_number')]);
        } else {
            // Don't change admin transmittal number if not specified
            unset($updateData['admin_transmittal_number']);
            unset($updateData['admin_transmittal_assigned_at']);
        }

        $newAttachmentPaths = [];
        $removedAttachments = collect();

        try {
            // Use database transaction to ensure data consistency
            DB::beginTransaction();

            $this->syncLegacyAttachments($record);
            $existingAttachments = $record->attachments()->get();
            $removeAttachmentIds = array_unique(array_merge(
                $removeAttachmentIds,
                $removeNoticeImage || $replaceLegacyNoticeImage ? $existingAttachments->where('type', 'image')->pluck('id')->all() : [],
                $removeNoticePdf || $replaceLegacyNoticePdf ? $existingAttachments->where('type', 'pdf')->pluck('id')->all() : []
            ));
            $removedAttachments = $existingAttachments->whereIn('id', $removeAttachmentIds);
            $record->attachments()->whereIn('id', $removedAttachments->pluck('id'))->delete();

            foreach ($noticeImages as $noticeImage) {
                $newNoticeImagePath = $noticeImage->store('claim-notices', 'local');
                if (! $newNoticeImagePath) {
                    throw new \RuntimeException('Unable to store the notice image.');
                }

                $newAttachmentPaths[] = $newNoticeImagePath;
                $record->attachments()->create([
                    'type' => 'image',
                    'path' => $newNoticeImagePath,
                    'original_name' => $noticeImage->getClientOriginalName(),
                ]);
            }

            foreach ($noticePdfs as $noticePdf) {
                $newNoticePdfPath = $noticePdf->store('claim-pdfs', 'local');
                if (! $newNoticePdfPath) {
                    throw new \RuntimeException('Unable to store the notice PDF.');
                }

                $newAttachmentPaths[] = $newNoticePdfPath;
                $record->attachments()->create([
                    'type' => 'pdf',
                    'path' => $newNoticePdfPath,
                    'original_name' => $noticePdf->getClientOriginalName(),
                ]);
            }

            $attachmentsToKeep = $record->attachments()->get();
            $updateData['notice_image_path'] = $attachmentsToKeep->firstWhere('type', 'image')?->path;
            $updateData['notice_pdf_path'] = $attachmentsToKeep->firstWhere('type', 'pdf')?->path;

            Log::info('About to update record', ['id' => $id, 'updateData' => $updateData]);

            $record->update($updateData);

            Log::info('Record updated successfully', ['id' => $id, 'updated_record' => $record->fresh()]);

            DB::commit();

            foreach ($removedAttachments as $removedAttachment) {
                if (! Storage::disk('local')->delete($removedAttachment->path)) {
                    Log::warning('Unable to remove deleted record attachment', [
                        'record_id' => $record->id,
                        'path' => $removedAttachment->path,
                    ]);
                }
            }

            Log::info('Transaction committed, returning success');

            // Return JSON response for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Record updated successfully!',
                ]);
            }

            return redirect()->back()->with('success', 'Record updated successfully!');

        } catch (\Exception $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            foreach ($newAttachmentPaths as $newAttachmentPath) {
                if (! Storage::disk('local')->delete($newAttachmentPath)) {
                    Log::warning('Unable to remove attachment after failed record update', [
                        'record_id' => $record->id,
                        'path' => $newAttachmentPath,
                    ]);
                }
            }

            // Log the error for debugging
            Log::error('Record update failed', [
                'error' => $e->getMessage(),
                'record_id' => $id,
                'user' => $request->session()->get('email_user_name') ?? $request->session()->get('facebook_user_name') ?? $request->session()->get('officer_name') ?? 'admin',
                'data' => $updateData,
            ]);

            // Return JSON response for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => config('app.debug') ? $e->getMessage() : 'Unable to update record. Please try again.',
                ], 500);
            }

            // Return user-friendly error message
            return redirect()->back()
                ->with('error', 'Unable to update record. Please try again. If the problem persists, contact an administrator.')
                ->withInput();
        }
    }

    public function destroyRecord($id)
    {
        $record = Record::findOrFail($id);
        $attachmentPaths = $record->attachments()->pluck('path')
            ->push($record->notice_image_path, $record->notice_pdf_path)
            ->filter()
            ->unique();
        $record->delete();

        foreach ($attachmentPaths as $attachmentPath) {
            if (! Storage::disk('local')->delete($attachmentPath)) {
                Log::warning('Unable to remove attachment after record deletion', [
                    'record_id' => $record->id,
                    'path' => $attachmentPath,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Record deleted successfully!');
    }

    public function showAttachment(Request $request, Record $record, RecordAttachment $attachment)
    {
        abort_unless((int) $attachment->record_id === (int) $record->id, 404);

        $isAdmin = (bool) $request->session()->get('admin_logged_in', false);
        $emailEncoderId = $request->session()->get('email_user_id');
        $isEmailEncoder = $record->source === 'Email'
            && (bool) $request->session()->get('email_logged_in', false)
            && filled($emailEncoderId)
            && (string) $emailEncoderId === (string) $record->encoder_id;
        $facebookEncoderId = $request->session()->get('facebook_user_id');
        $isFacebookEncoder = $record->source === 'Facebook'
            && (bool) $request->session()->get('facebook_logged_in', false)
            && filled($facebookEncoderId)
            && (string) $facebookEncoderId === (string) $record->encoder_id;
        $officerId = $request->session()->get('officer_id');
        $isOfficerEncoder = $record->source === 'OD'
            && filled($request->session()->get('officer_name'))
            && filled($officerId)
            && (string) $officerId === (string) $record->encoder_id;

        abort_unless($isAdmin || $isEmailEncoder || $isFacebookEncoder || $isOfficerEncoder, 403);

        return $this->attachmentResponse($record, $attachment);
    }

    public function showAllRecordsAttachment(Record $record, RecordAttachment $attachment)
    {
        return $this->attachmentResponse($record, $attachment);
    }

    private function attachmentResponse(Record $record, RecordAttachment $attachment)
    {
        abort_unless((int) $attachment->record_id === (int) $record->id, 404);

        $directory = $attachment->type === 'image' ? 'claim-notices' : 'claim-pdfs';
        abort_unless(
            in_array($attachment->type, ['image', 'pdf'], true)
                && preg_match('#\A'.preg_quote($directory, '#').'/[A-Za-z0-9._-]+\z#', $attachment->path)
                && Storage::disk('local')->exists($attachment->path),
            404
        );

        $mimeType = Storage::disk('local')->mimeType($attachment->path);
        $allowedMimeTypes = $attachment->type === 'image'
            ? ['image/jpeg', 'image/png', 'image/webp']
            : ['application/pdf'];

        abort_unless($mimeType && in_array($mimeType, $allowedMimeTypes, true), 404);

        return Storage::disk('local')->response(
            $attachment->path,
            $attachment->original_name,
            [
                'Content-Type' => $mimeType,
                'X-Content-Type-Options' => 'nosniff',
            ],
            'inline'
        );
    }

    public function showNoticeImage(Request $request, Record $record)
    {
        $isAdmin = (bool) $request->session()->get('admin_logged_in', false);
        $isEmailEncoder = $record->source === 'Email'
            && (bool) $request->session()->get('email_logged_in', false)
            && (string) $request->session()->get('email_user_id') === (string) $record->encoder_id;
        $isFacebookEncoder = $record->source === 'Facebook'
            && (bool) $request->session()->get('facebook_logged_in', false)
            && (string) $request->session()->get('facebook_user_id') === (string) $record->encoder_id;

        abort_unless($isAdmin || $isEmailEncoder || $isFacebookEncoder, 403);
        abort_unless(
            $record->notice_image_path
                && preg_match('#\Aclaim-notices/[A-Za-z0-9._-]+\z#', $record->notice_image_path)
                && Storage::disk('local')->exists($record->notice_image_path),
            404
        );

        $mimeType = Storage::disk('local')->mimeType($record->notice_image_path);

        abort_unless($mimeType && str_starts_with($mimeType, 'image/'), 404);

        return Storage::disk('local')->response(
            $record->notice_image_path,
            basename($record->notice_image_path),
            [
                'Content-Type' => $mimeType,
                'X-Content-Type-Options' => 'nosniff',
            ],
            'inline'
        );
    }

    private function uploadedFiles(Request $request, string $multipleField, string $singleField): array
    {
        $files = $request->file($multipleField, []);
        $files = is_array($files) ? $files : [$files];

        if ($singleFile = $request->file($singleField)) {
            $files[] = $singleFile;
        }

        return array_values(array_filter($files));
    }

    private function syncLegacyAttachments(Record $record): void
    {
        foreach ([
            'image' => $record->notice_image_path,
            'pdf' => $record->notice_pdf_path,
        ] as $type => $path) {
            if (! $path || $record->attachments()->where('path', $path)->exists()) {
                continue;
            }

            $record->attachments()->create([
                'type' => $type,
                'path' => $path,
                'original_name' => basename($path),
            ]);
        }
    }

    public function checkDuplicates(Request $request)
    {
        $validatedData = $request->validate([
            'farmerName' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'causeOfDamage' => 'required|string|max:255',
            'line' => 'required|string|max:255',
            'date_occurrence' => 'nullable|string|max:500',
        ]);

        // Check for potential duplicate records
        $potentialDuplicates = Record::where('farmerName', 'LIKE', '%'.$request->farmerName.'%')
            ->where('municipality', $request->municipality)
            ->where('barangay', $request->barangay)
            ->where('causeOfDamage', $request->causeOfDamage)
            ->where('line', $request->line)
            ->when($request->date_occurrence, function ($query) use ($request) {
                return $query->where('date_occurrence', $request->date_occurrence);
            })
            ->get();

        if ($potentialDuplicates->isEmpty()) {
            return response()->json([
                'success' => true,
                'duplicates' => [],
            ]);
        }

        // Format duplicate records for display
        $duplicateRecords = [];
        foreach ($potentialDuplicates as $duplicate) {
            $duplicateRecords[] = [
                'id' => $duplicate->id,
                'farmerName' => $duplicate->farmerName,
                'address' => $duplicate->address,
                'causeOfDamage' => $duplicate->causeOfDamage,
                'line' => $duplicate->line,
                'date_occurrence' => $duplicate->date_occurrence ?: 'Not specified',
                'program' => $duplicate->program,
                'source' => $duplicate->source,
                'created_at' => $duplicate->created_at->format('M d, Y'),
            ];
        }

        return response()->json([
            'success' => true,
            'duplicates' => $duplicateRecords,
            'message' => 'Potential duplicate records found',
        ]);
    }

    public function getLatestRecord(Request $request)
    {
        $source = $request->input('source');
        $encoderName = null;
        $encoderId = null;

        // Get encoder name based on source
        if ($source === 'OD') {
            $encoderName = $request->session()->get('officer_name');
            $encoderId = $request->session()->get('officer_id');
        } elseif ($source === 'Email') {
            $encoderName = $request->session()->get('email_user_name');
            $encoderId = $request->session()->get('email_user_id');
        } elseif ($source === 'Facebook') {
            $encoderName = $request->session()->get('facebook_user');
            $encoderId = $request->session()->get('facebook_user_id');
        }

        if (! $encoderName) {
            return response()->json(['success' => false, 'message' => 'Not logged in'], 401);
        }

        // Prefer the authenticated encoder ID, retaining name matching for legacy records.
        $latestRecord = Record::query()
            ->where('source', $source)
            ->when($encoderId, function ($query) use ($encoderId, $encoderName) {
                $query->where(function ($query) use ($encoderId, $encoderName) {
                    $query->where('encoder_id', $encoderId)
                        ->orWhere(function ($query) use ($encoderName) {
                            $query->whereNull('encoder_id')
                                ->where('encoderName', $encoderName);
                        });
                });
            }, function ($query) use ($encoderName) {
                $query->where('encoderName', $encoderName);
            })
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->first();

        if (! $latestRecord) {
            return response()->json(['success' => false, 'message' => 'No records found']);
        }

        return response()->json([
            'success' => true,
            'record' => [
                'farmerName' => $latestRecord->farmerName,
                'province' => $latestRecord->province,
                'municipality' => $latestRecord->municipality,
                'barangay' => $latestRecord->barangay,
                'line' => $latestRecord->line,
                'program' => $latestRecord->program,
                'causeOfDamage' => $latestRecord->causeOfDamage,
                'modeOfPayment' => $latestRecord->modeOfPayment,
                'accounts' => $latestRecord->accounts,
                'facebook_page_url' => $latestRecord->facebook_page_url,
                'date_occurrence' => $latestRecord->date_occurrence,
                'date_received' => $latestRecord->date_received ? $latestRecord->date_received->format('Y-m-d') : '',
                'remarks' => $latestRecord->remarks,
                'control_number' => $latestRecord->control_number,
            ],
        ]);
    }
}
