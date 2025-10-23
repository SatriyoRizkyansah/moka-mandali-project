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
    Schema::create('pesanan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->integer('total_harga');
        $table->integer('biaya_ongkir')->nullable();
        $table->string('bukti_transfer')->nullable();
        $table->string('bukti_ongkir')->nullable();
        $table->string('resi')->nullable();
        $table->enum('status', [
            'menunggu_pembayaran',
            'menunggu_konfirmasi',
            'menunggu_ongkir',
            'menunggu_pembayaran_ongkir',
            'dikirim',
            'selesai',
            'dibatalkan'
        ])->default('menunggu_pembayaran');
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
