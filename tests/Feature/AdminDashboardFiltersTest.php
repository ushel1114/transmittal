<?php

use App\Models\Record;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

beforeEach(function () {
    Schema::dropIfExists('records');
    Schema::dropIfExists('officers');
    Schema::dropIfExists('admins');

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
        $table->timestamps();
    });

    Schema::create('officers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });

    Schema::create('admins', function (Blueprint $table) {
        $table->id();
        $table->string('username');
        $table->timestamps();
    });
});

afterEach(function () {
    Schema::dropIfExists('records');
    Schema::dropIfExists('officers');
    Schema::dropIfExists('admins');
});

test('dashboard summary charts respect dashboard filters', function () {
    $this->withSession([
        'admin_logged_in' => true,
        'admin_username' => 'admin',
    ]);

    $riceRecord = Record::create([
        'farmerName' => 'Juan Dela Cruz',
        'address' => 'Test Address',
        'province' => 'Nueva Ecija',
        'municipality' => 'Gapan',
        'barangay' => 'San Vicente',
        'line' => 'rice',
        'program' => 'RSBSA',
        'causeOfDamage' => 'Flood',
        'modeOfPayment' => 'check',
        'source' => 'OD',
    ]);
    $riceRecord->forceFill(['created_at' => '2026-01-15 10:00:00', 'updated_at' => '2026-01-15 10:00:00'])->save();

    $cornRecord = Record::create([
        'farmerName' => 'Maria Santos',
        'address' => 'Other Address',
        'province' => 'Aurora',
        'municipality' => 'Baler',
        'barangay' => 'Barangay 1',
        'line' => 'corn',
        'program' => 'ACEF',
        'causeOfDamage' => 'Drought',
        'modeOfPayment' => 'gcash',
        'source' => 'Email',
    ]);
    $cornRecord->forceFill(['created_at' => '2026-01-16 10:00:00', 'updated_at' => '2026-01-16 10:00:00'])->save();

    $response = $this->get('/admin?tab=dashboard&dash_program=RSBSA&dash_line=rice');

    $response->assertOk();
    $response->assertViewHas('recordsByLine', function ($recordsByLine) {
        return $recordsByLine->get('rice') === 1 && !$recordsByLine->has('corn');
    });
    $response->assertViewHas('recordsBySource', function ($recordsBySource) {
        return $recordsBySource->get('OD') === 1 && !$recordsBySource->has('Email');
    });
});

test('dashboard province cards respect dashboard date filters', function () {
    $this->withSession([
        'admin_logged_in' => true,
        'admin_username' => 'admin',
    ]);

    Record::create([
        'farmerName' => 'Juan Dela Cruz',
        'address' => 'Test Address',
        'province' => 'Nueva Ecija',
        'municipality' => 'Gapan',
        'barangay' => 'San Vicente',
        'line' => 'rice',
        'program' => 'RSBSA',
        'causeOfDamage' => 'Flood',
        'modeOfPayment' => 'check',
        'source' => 'OD',
    ])->forceFill(['created_at' => '2026-01-15 10:00:00', 'updated_at' => '2026-01-15 10:00:00'])->save();

    Record::create([
        'farmerName' => 'Maria Santos',
        'address' => 'Other Address',
        'province' => 'Nueva Ecija',
        'municipality' => 'Cabanatuan',
        'barangay' => 'Barangay 2',
        'line' => 'rice',
        'program' => 'RSBSA',
        'causeOfDamage' => 'Drought',
        'modeOfPayment' => 'gcash',
        'source' => 'OD',
    ])->forceFill(['created_at' => '2026-01-16 10:00:00', 'updated_at' => '2026-01-16 10:00:00'])->save();

    $response = $this->get('/admin?tab=dashboard&dash_date_type=single&dash_date_single=2026-01-15');

    $response->assertOk();
    $response->assertViewHas('dashCountsByProvince', function ($dashCountsByProvince) {
        return isset($dashCountsByProvince['NUEVA ECIJA'])
            && count($dashCountsByProvince['NUEVA ECIJA']) === 1
            && $dashCountsByProvince['NUEVA ECIJA'][0]['municipality'] === 'Gapan'
            && $dashCountsByProvince['NUEVA ECIJA'][0]['count'] === 1;
    });
});
