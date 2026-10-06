<?php

use App\Models\Record;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Schema::dropIfExists('records');
    Schema::create('records', function (Blueprint $table) {
        $table->id();
        $table->string('farmerName');
        $table->string('address');
        $table->string('province')->nullable();
        $table->string('municipality')->nullable();
        $table->string('barangay')->nullable();
        $table->string('line');
        $table->string('program');
        $table->string('causeOfDamage');
        $table->string('modeOfPayment')->nullable();
        $table->string('accounts')->nullable();
        $table->string('facebook_page_url')->nullable();
        $table->string('notice_image_path')->nullable();
        $table->string('notice_pdf_path')->nullable();
        $table->string('date_occurrence')->nullable();
        $table->date('date_received')->nullable();
        $table->string('remarks')->nullable();
        $table->string('control_number')->nullable();
        $table->string('source')->nullable();
        $table->string('transmittal_number')->nullable();
        $table->string('admin_transmittal_number')->nullable();
        $table->timestamp('admin_transmittal_assigned_at')->nullable();
        $table->string('encoderName')->nullable();
        $table->unsignedBigInteger('encoder_id')->nullable();
        $table->boolean('approved')->default(false);
        $table->timestamp('approved_at')->nullable();
        $table->timestamps();
    });
});

afterEach(function () {
    Schema::dropIfExists('records');
});

function encoderNoticeImageUpdateData(): array
{
    return [
        'farmerName' => 'Juan Dela Cruz',
        'province' => 'Nueva Ecija',
        'municipality' => 'Gapan',
        'barangay' => 'San Vicente',
        'line' => 'Rice',
        'program' => 'RSBSA',
        'source' => 'Email',
        'causeOfDamage' => 'Flood',
        'modeOfPayment' => 'Check',
    ];
}

function encoderNoticeImageStoreData(UploadedFile $image, string $source = 'Email'): array
{
    $data = [
        'farmerName' => 'Juan Dela Cruz',
        'province' => 'Nueva Ecija',
        'municipality' => 'Gapan',
        'barangay' => 'San Vicente',
        'line' => 'Rice',
        'program' => 'RSBSA',
        'causeOfDamage' => 'Flood',
        'modeOfPayment' => 'Check',
        'source' => $source,
        'notice_image' => $image,
    ];

    if ($source === 'Facebook') {
        $data['accounts'] = 'Facebook page';
    }

    return $data;
}

function fakeNoticeImage(int $sizeInKilobytes): UploadedFile
{
    return UploadedFile::fake()
        ->createWithContent('claim.jpg', file_get_contents(public_path('images/PCIC_RO3A_LOGO.jpg')))
        ->size($sizeInKilobytes);
}

function fakeNoticePdf(string $filename = 'claim.pdf'): UploadedFile
{
    return UploadedFile::fake()->createWithContent($filename, "%PDF-1.4\nTest claim attachment\n%%EOF");
}

function noticePdfSession(string $source): array
{
    return match ($source) {
        'OD' => ['officer_name' => 'OD Encoder', 'officer_id' => 41],
        'Email' => ['email_logged_in' => true, 'email_user_name' => 'Email Encoder', 'email_user_id' => 42],
        'Facebook' => ['facebook_logged_in' => true, 'facebook_user' => 'Facebook Encoder', 'facebook_user_id' => 43],
    };
}

test('email encoder can remove their uploaded notice image', function () {
    Storage::fake('local');
    Storage::disk('local')->put('claim-notices/claim.jpg', 'image-data');

    $record = Record::create([
        ...encoderNoticeImageUpdateData(),
        'address' => 'San Vicente, Gapan, Nueva Ecija',
        'encoderName' => 'Email Encoder',
        'encoder_id' => 42,
        'notice_image_path' => 'claim-notices/claim.jpg',
    ]);

    $response = $this->withSession([
        'email_logged_in' => true,
        'email_user_id' => 42,
    ])->putJson(route('records.update', $record), [
        ...encoderNoticeImageUpdateData(),
        'remove_notice_image' => '1',
    ]);

    $response->assertOk()->assertJson(['success' => true]);
    $this->assertDatabaseHas('records', [
        'id' => $record->id,
        'notice_image_path' => null,
    ]);
    Storage::disk('local')->assertMissing('claim-notices/claim.jpg');
});

test('encoder cannot remove another encoder notice image', function () {
    Storage::fake('local');
    Storage::disk('local')->put('claim-notices/claim.jpg', 'image-data');

    $record = Record::create([
        ...encoderNoticeImageUpdateData(),
        'address' => 'San Vicente, Gapan, Nueva Ecija',
        'encoderName' => 'Another Encoder',
        'encoder_id' => 99,
        'notice_image_path' => 'claim-notices/claim.jpg',
    ]);

    $response = $this->withSession([
        'email_logged_in' => true,
        'email_user_id' => 42,
    ])->putJson(route('records.update', $record), [
        ...encoderNoticeImageUpdateData(),
        'remove_notice_image' => '1',
    ]);

    $response->assertForbidden();
    $this->assertDatabaseHas('records', [
        'id' => $record->id,
        'notice_image_path' => 'claim-notices/claim.jpg',
    ]);
    Storage::disk('local')->assertExists('claim-notices/claim.jpg');
});

test('facebook encoder can remove their uploaded notice image', function () {
    Storage::fake('local');
    Storage::disk('local')->put('claim-notices/claim.jpg', 'image-data');

    $record = Record::create([
        ...encoderNoticeImageUpdateData(),
        'source' => 'Facebook',
        'address' => 'San Vicente, Gapan, Nueva Ecija',
        'encoderName' => 'Facebook Encoder',
        'encoder_id' => 43,
        'notice_image_path' => 'claim-notices/claim.jpg',
    ]);

    $response = $this->withSession([
        'facebook_logged_in' => true,
        'facebook_user_id' => 43,
    ])->putJson(route('records.update', $record), [
        ...encoderNoticeImageUpdateData(),
        'source' => 'Facebook',
        'accounts' => 'Facebook page',
        'remove_notice_image' => '1',
    ]);

    $response->assertOk()->assertJson(['success' => true]);
    $this->assertDatabaseHas('records', [
        'id' => $record->id,
        'notice_image_path' => null,
    ]);
    Storage::disk('local')->assertMissing('claim-notices/claim.jpg');
});

test('email record accepts an image larger than five megabytes within the thirty megabyte limit', function () {
    Storage::fake('local');

    $response = $this->withSession([
        'email_logged_in' => true,
        'email_user_name' => 'Email Encoder',
        'email_user_id' => 42,
    ])->withHeader('Accept', 'application/json')->post(route('records'), encoderNoticeImageStoreData(
        fakeNoticeImage(6 * 1024)
    ));

    $response->assertOk()->assertJson(['success' => true]);
    $this->assertDatabaseCount('records', 1);
    Storage::disk('local')->assertExists(Record::query()->value('notice_image_path'));
});

test('facebook record accepts an image larger than five megabytes within the thirty megabyte limit', function () {
    Storage::fake('local');

    $response = $this->withSession([
        'facebook_logged_in' => true,
        'facebook_user' => 'Facebook Encoder',
        'facebook_user_id' => 43,
    ])->withHeader('Accept', 'application/json')->post(route('records'), encoderNoticeImageStoreData(
        fakeNoticeImage(6 * 1024),
        'Facebook'
    ));

    $response->assertOk()->assertJson(['success' => true]);
    $this->assertDatabaseCount('records', 1);
    Storage::disk('local')->assertExists(Record::query()->value('notice_image_path'));
});

test('email record rejects an image larger than thirty megabytes', function () {
    Storage::fake('local');

    $response = $this->withSession([
        'email_logged_in' => true,
        'email_user_name' => 'Email Encoder',
        'email_user_id' => 42,
    ])->withHeader('Accept', 'application/json')->post(route('records'), encoderNoticeImageStoreData(
        fakeNoticeImage((30 * 1024) + 1)
    ));

    $response->assertUnprocessable()->assertJsonValidationErrors('notice_image');
    $this->assertDatabaseCount('records', 0);
});

test('each receiving channel can upload a PDF with a record', function (string $source) {
    Storage::fake('local');
    $data = encoderNoticeImageStoreData(fakeNoticeImage(1), $source);
    unset($data['notice_image']);
    $data['notice_pdf'] = fakeNoticePdf();

    $response = $this->withSession(noticePdfSession($source))
        ->withHeader('Accept', 'application/json')
        ->post(route('records'), $data);

    $response->assertOk()->assertJson(['success' => true]);
    $pdfPath = Record::query()->value('notice_pdf_path');
    expect($pdfPath)->toStartWith('claim-pdfs/');
    Storage::disk('local')->assertExists($pdfPath);
})->with(['OD', 'Email', 'Facebook']);

test('receiving channels can remove their existing PDF while editing a record', function () {
    Storage::fake('local');
    Storage::disk('local')->put('claim-pdfs/claim.pdf', '%PDF-1.4');
    $record = Record::create([
        ...encoderNoticeImageUpdateData(),
        'address' => 'San Vicente, Gapan, Nueva Ecija',
        'encoderName' => 'Email Encoder',
        'encoder_id' => 42,
        'notice_pdf_path' => 'claim-pdfs/claim.pdf',
    ]);

    $response = $this->withSession(noticePdfSession('Email'))
        ->putJson(route('records.update', $record), [
            ...encoderNoticeImageUpdateData(),
            'remove_notice_pdf' => '1',
        ]);

    $response->assertOk()->assertJson(['success' => true]);
    $this->assertDatabaseHas('records', ['id' => $record->id, 'notice_pdf_path' => null]);
    Storage::disk('local')->assertMissing('claim-pdfs/claim.pdf');
});

test('encoder cannot remove another encoder PDF', function () {
    Storage::fake('local');
    Storage::disk('local')->put('claim-pdfs/claim.pdf', '%PDF-1.4');
    $record = Record::create([
        ...encoderNoticeImageUpdateData(),
        'address' => 'San Vicente, Gapan, Nueva Ecija',
        'encoderName' => 'Another Encoder',
        'encoder_id' => 99,
        'notice_pdf_path' => 'claim-pdfs/claim.pdf',
    ]);

    $response = $this->withSession(noticePdfSession('Email'))
        ->putJson(route('records.update', $record), [
            ...encoderNoticeImageUpdateData(),
            'remove_notice_pdf' => '1',
        ]);

    $response->assertForbidden();
    $this->assertDatabaseHas('records', ['id' => $record->id, 'notice_pdf_path' => 'claim-pdfs/claim.pdf']);
    Storage::disk('local')->assertExists('claim-pdfs/claim.pdf');
});

test('encoder can replace an existing PDF while editing a record', function () {
    Storage::fake('local');
    Storage::disk('local')->put('claim-pdfs/old-claim.pdf', '%PDF-1.4 old');
    $record = Record::create([
        ...encoderNoticeImageUpdateData(),
        'address' => 'San Vicente, Gapan, Nueva Ecija',
        'encoderName' => 'Email Encoder',
        'encoder_id' => 42,
        'notice_pdf_path' => 'claim-pdfs/old-claim.pdf',
    ]);

    $response = $this->withSession(noticePdfSession('Email'))
        ->putJson(route('records.update', $record), [
            ...encoderNoticeImageUpdateData(),
            'notice_pdf' => fakeNoticePdf('replacement.pdf'),
        ]);

    $response->assertOk()->assertJson(['success' => true]);
    $newPath = $record->fresh()->notice_pdf_path;
    expect($newPath)->toStartWith('claim-pdfs/')->not->toBe('claim-pdfs/old-claim.pdf');
    Storage::disk('local')->assertMissing('claim-pdfs/old-claim.pdf');
    Storage::disk('local')->assertExists($newPath);
});

test('record creation rejects non-PDF attachments', function () {
    Storage::fake('local');
    $data = encoderNoticeImageStoreData(fakeNoticeImage(1));
    unset($data['notice_image']);
    $data['notice_pdf'] = UploadedFile::fake()->create('claim.txt', 1, 'text/plain');

    $response = $this->withSession(noticePdfSession('Email'))
        ->withHeader('Accept', 'application/json')
        ->post(route('records'), $data);

    $response->assertUnprocessable()->assertJsonValidationErrors('notice_pdf');
    $this->assertDatabaseCount('records', 0);
});

test('record creation rejects PDFs larger than thirty megabytes', function () {
    Storage::fake('local');
    $data = encoderNoticeImageStoreData(fakeNoticeImage(1));
    unset($data['notice_image']);
    $data['notice_pdf'] = fakeNoticePdf()->size((30 * 1024) + 1);

    $response = $this->withSession(noticePdfSession('Email'))
        ->withHeader('Accept', 'application/json')
        ->post(route('records'), $data);

    $response->assertUnprocessable()->assertJsonValidationErrors('notice_pdf');
    $this->assertDatabaseCount('records', 0);
});

test('landing page filters records by farmer name and address and displays a summary', function () {
    Record::create([
        ...encoderNoticeImageUpdateData(),
        'farmerName' => 'Juan Dela Cruz',
        'address' => 'San Vicente, Gapan, Nueva Ecija',
        'source' => 'Email',
    ]);
    Record::create([
        ...encoderNoticeImageUpdateData(),
        'farmerName' => 'Maria Santos',
        'barangay' => 'Poblacion',
        'municipality' => 'Cabanatuan',
        'address' => 'Poblacion, Cabanatuan, Nueva Ecija',
        'source' => 'Facebook',
    ]);

    $response = $this->get(route('welcome', [
        'name' => 'Juan',
        'province' => 'Nueva Ecija',
        'municipality' => 'Gapan',
        'barangay' => 'San Vicente',
    ]));

    $response->assertOk()
        ->assertSee('All NL Records')
        ->assertSee('Facebook')
        ->assertSee('Officer of the Day')
        ->assertSee('Email')
        ->assertSee('Administrator Login')
        ->assertSee('View full records')
        ->assertSee('Matching records')
        ->assertSee('Juan Dela Cruz')
        ->assertDontSee('Maria Santos')
        ->assertViewHas('landingTotalRecords', 1);
});

test('landing page shows an empty filtered state when no records match', function () {
    $response = $this->get(route('welcome', ['name' => 'No matching farmer']));

    $response->assertOk()
        ->assertSee('No records match the selected filters.')
        ->assertViewHas('landingTotalRecords', 0);
});
