<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('record_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('record_id')->constrained()->cascadeOnDelete();
            $table->string('type', 16);
            $table->string('path');
            $table->string('original_name');
            $table->timestamps();
        });

        DB::table('records')
            ->select(['id', 'notice_image_path', 'notice_pdf_path'])
            ->orderBy('id')
            ->chunkById(500, function ($records): void {
                $attachments = [];
                $now = now();

                foreach ($records as $record) {
                    foreach ([
                        'image' => $record->notice_image_path,
                        'pdf' => $record->notice_pdf_path,
                    ] as $type => $path) {
                        if (! $path) {
                            continue;
                        }

                        $attachments[] = [
                            'record_id' => $record->id,
                            'type' => $type,
                            'path' => $path,
                            'original_name' => basename($path),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                }

                if ($attachments !== []) {
                    DB::table('record_attachments')->insert($attachments);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('record_attachments');
    }
};
