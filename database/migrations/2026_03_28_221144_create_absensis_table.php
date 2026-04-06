<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::dropIfExists('absensis');

        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id'); 
            $table->time('waktu_absen');
            $table->date('tanggal_absen');
            $table->enum('status', ['HADIR', 'TERLAMBAT', 'IZIN', 'ALPA'])->default('ALPA');
            $table->string('bukti_foto')->nullable();
            $table->timestamps();

            $table->foreign('siswa_id')
                  ->references('id')
                  ->on('siswa') 
                  ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('absensis');
    }
};