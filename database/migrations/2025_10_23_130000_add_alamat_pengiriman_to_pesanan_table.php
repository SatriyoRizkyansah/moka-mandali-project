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
        Schema::table('pesanan', function (Blueprint $table) {
            $table->string('alamat_lengkap')->after('user_id');
            $table->string('kota')->after('alamat_lengkap');
            $table->string('kode_pos')->after('kota');
            $table->string('nomor_telepon')->after('kode_pos');
            $table->text('catatan_pengiriman')->nullable()->after('nomor_telepon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['alamat_lengkap', 'kota', 'kode_pos', 'nomor_telepon', 'catatan_pengiriman']);
        });
    }
};