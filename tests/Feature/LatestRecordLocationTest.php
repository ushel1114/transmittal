<?php

use App\Models\Record;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        $table->string('source')->nullable();
        $table->string('encoderName')->nullable();
        $table->unsignedBigInteger('encoder_id')->nullable();
        $table->date('date_received')->nullable();
        $table->string('facebook_page_url')->nullable();
        $table->string('remarks')->nullable();
        $table->timestamps();
    });
});

afterEach(function () {
    Schema::dropIfExists('records');
});

it('uses the latest location encoded by the logged in user', function () {
    $attributes = [
        'farmerName' => 'Test Farmer',
        'address' => 'Test Barangay, Test Municipality, Nueva Ecija',
        'province' => 'Nueva Ecija',
        'municipality' => 'Test Municipality',
        'barangay' => 'Test Barangay',
        'line' => 'rice',
        'program' => 'RSBSA',
        'causeOfDamage' => 'Flood',
        'modeOfPayment' => 'check',
        'source' => 'OD',
        'encoderName' => 'Same Name',
    ];

    Record::create(array_merge($attributes, [
        'municipality' => 'Older Municipality',
        'encoder_id' => 7,
    ]));
    Record::create(array_merge($attributes, [
        'municipality' => 'Talugtug',
        'encoder_id' => 8,
    ]));
    Record::create(array_merge($attributes, [
        'municipality' => 'Latest Municipality',
        'encoder_id' => 7,
    ]));

    $response = $this->withSession([
        'officer_name' => 'Same Name',
        'officer_id' => 7,
    ])->get('/records/latest?source=OD');

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('record.municipality', 'Latest Municipality');
});

it('uses matching legacy records without an encoder id', function () {
    Record::create([
        'farmerName' => 'Test Farmer',
        'address' => 'Legacy Barangay, Legacy Municipality, Nueva Ecija',
        'province' => 'Nueva Ecija',
        'municipality' => 'Legacy Municipality',
        'barangay' => 'Legacy Barangay',
        'line' => 'rice',
        'program' => 'RSBSA',
        'causeOfDamage' => 'Flood',
        'modeOfPayment' => 'check',
        'source' => 'OD',
        'encoderName' => 'Legacy Officer',
        'encoder_id' => null,
    ]);

    $response = $this->withSession([
        'officer_name' => 'Legacy Officer',
        'officer_id' => 7,
    ])->get('/records/latest?source=OD');

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('record.municipality', 'Legacy Municipality');
});
