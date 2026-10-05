<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('officers', 'password')) {
            Schema::table('officers', function (Blueprint $table) {
                $table->string('password')->nullable()->after('username');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // The earlier officer authentication migration also owns this column.
    }
};
