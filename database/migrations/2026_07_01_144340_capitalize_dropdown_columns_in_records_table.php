<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Capitalize existing records in dropdown columns
        DB::statement("UPDATE records SET province = UPPER(province) WHERE province IS NOT NULL");
        DB::statement("UPDATE records SET municipality = UPPER(municipality) WHERE municipality IS NOT NULL");
        DB::statement("UPDATE records SET barangay = UPPER(barangay) WHERE barangay IS NOT NULL");
        DB::statement("UPDATE records SET line = UPPER(line) WHERE line IS NOT NULL");
        DB::statement("UPDATE records SET program = UPPER(program) WHERE program IS NOT NULL");
        DB::statement("UPDATE records SET modeOfPayment = UPPER(modeOfPayment) WHERE modeOfPayment IS NOT NULL");
        DB::statement("UPDATE records SET source = UPPER(source) WHERE source IS NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse action needed as this is a data migration
    }
};
