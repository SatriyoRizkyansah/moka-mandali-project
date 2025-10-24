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
        Schema::create('pesan_chat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengguna_id')->nullable(); // Null jika admin yang mengirim
            $table->text('isi_pesan');
            $table->boolean('dari_admin')->default(false);
            $table->timestamp('dibaca_admin_pada')->nullable(); // Kapan admin membaca pesan
            $table->timestamp('dibaca_customer_pada')->nullable(); // Kapan customer membaca pesan
            $table->timestamps();

            $table->foreign('pengguna_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['pengguna_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesan_chat');
    }
};
