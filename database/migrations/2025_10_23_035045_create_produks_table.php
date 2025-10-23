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
        Schema::create('produk', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kategori_id');
            $table->uuid('merk_id');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->integer('harga');
            $table->integer('stok');
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategori_produk')->onDelete('cascade');
            $table->foreign('merk_id')->references('id')->on('merk_produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
