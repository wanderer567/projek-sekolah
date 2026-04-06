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
    Schema::table('siswa', function (Blueprint $table) {
        $table->string('code_qr_siswa')->nullable();
    });
}

public function down(): void
{
    Schema::table('siswa', function (Blueprint $table) {
        $table->dropColumn('code_qr_siswa');
    });
}
};
