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
       Schema::create('siswa', function (Blueprint $table) {
    $table->id();
    $table->unsignedInteger('nomor_absen');
    $table->string('nama');
    $table->string('nisn');
    $table->string('kelas');

    // $table->foreignId('kelas_id')
    //       ->constrained('kelas')
    //       ->onDelete('cascade');

    $table->timestamps();

    // biar gak ada nomor absen kembar dalam 1 kelas
    // $table->unique(['kelas_id', 'nomor_absen']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
