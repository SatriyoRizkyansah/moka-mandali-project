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
        Schema::table('pesan_chat', function (Blueprint $table) {
            // Drop foreign key dan kolom pesanan_id
            $table->dropForeign(['pesanan_id']);
            $table->dropColumn('pesanan_id');
            
            // Tambah kolom baru untuk tracking read status
            $table->timestamp('dibaca_admin_pada')->nullable()->after('dari_admin');
            $table->timestamp('dibaca_customer_pada')->nullable()->after('dibaca_admin_pada');
            
            // Update index
            $table->dropIndex(['pesanan_id', 'created_at']);
            $table->index(['pengguna_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesan_chat', function (Blueprint $table) {
            // Kembalikan pesanan_id
            $table->uuid('pesanan_id')->after('id');
            $table->foreign('pesanan_id')->references('id')->on('pesanan')->onDelete('cascade');
            
            // Hapus kolom read status
            $table->dropColumn(['dibaca_admin_pada', 'dibaca_customer_pada']);
            
            // Kembalikan index
            $table->dropIndex(['pengguna_id', 'created_at']);
            $table->index(['pesanan_id', 'created_at']);
        });
    }
};
