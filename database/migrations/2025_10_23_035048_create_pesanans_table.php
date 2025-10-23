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
            $table->uuid('id')->primary();
            $table->uuid('user_id');
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

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
