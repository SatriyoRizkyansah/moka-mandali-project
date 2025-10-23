<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\{
    User,
    KategoriProduk,
    MerkProduk,
    Produk,
    Pesanan,
    DetailPesanan,
    Pembayaran,
    Ulasan,
    Voucher,
    Notifikasi
};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===============================
        // 1️⃣ User (Customer, Admin, Owner)
        // ===============================
        $admin = User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@velgku.com',
            'password' => Hash::make('devByPass'),
            'role' => 'admin',
            'alamat' => 'Jl. Raya Industri No. 12, Tangerang',
            'telepon' => '08123456789',
        ]);

        $owner = User::create([
            'name' => 'Owner Toko',
            'email' => 'owner@velgku.com',
            'password' => Hash::make('devByPass'),
            'role' => 'owner',
            'alamat' => 'Jl. Veteran No. 45, Tangerang',
            'telepon' => '08123456780',
        ]);

        $customer = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('devByPass'),
            'role' => 'customer',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'telepon' => '082134567890',
        ]);

        // ===============================
        // 2️⃣ Kategori & Merk
        // ===============================
        $kategori1 = KategoriProduk::create(['nama' => 'Velg Racing']);
        $kategori2 = KategoriProduk::create(['nama' => 'Velg Jari-jari']);

        $merk1 = MerkProduk::create(['nama_merk' => 'TK Racing']);
        $merk2 = MerkProduk::create(['nama_merk' => 'Comet']);
        $merk3 = MerkProduk::create(['nama_merk' => 'Rossi']);

        // ===============================
        // 3️⃣ Produk
        // ===============================
        $produk1 = Produk::create([
            'kategori_id' => $kategori1->id,
            'merk_id' => $merk1->id,
            'nama' => 'Velg TK Racing 17 Inch',
            'deskripsi' => 'Velg racing berkualitas tinggi untuk motor bebek ukuran 17 inch.',
            'harga' => 550000,
            'stok' => 25,
            'foto' => 'velg-tk-racing-17.jpg',
        ]);

        $produk2 = Produk::create([
            'kategori_id' => $kategori2->id,
            'merk_id' => $merk2->id,
            'nama' => 'Velg Comet Jari-jari 17 Inch',
            'deskripsi' => 'Velg jari-jari kuat dan ringan cocok untuk motor matic.',
            'harga' => 450000,
            'stok' => 40,
            'foto' => 'velg-comet-17.jpg',
        ]);

        // ===============================
        // 4️⃣ Pesanan & DetailPesanan
        // ===============================
        $pesanan = Pesanan::create([
            'user_id' => $customer->id,
            'total_harga' => 550000,
            'biaya_ongkir' => null,
            'bukti_transfer' => null,
            'bukti_ongkir' => null,
            'resi' => null,
            'status' => 'menunggu_pembayaran',
        ]);

        DetailPesanan::create([
            'pesanan_id' => $pesanan->id,
            'produk_id' => $produk1->id,
            'jumlah' => 1,
            'harga_satuan' => 550000,
            'subtotal' => 550000,
        ]);

        // ===============================
        // 5️⃣ Pembayaran
        // ===============================
        Pembayaran::create([
            'pesanan_id' => $pesanan->id,
            'bukti_transfer' => 'bukti-transfer-1.jpg',
            'jumlah' => 550000,
            'jenis' => 'produk',
            'status' => 'diterima',
        ]);

        // ===============================
        // 6️⃣ Ulasan
        // ===============================
        Ulasan::create([
            'produk_id' => $produk1->id,
            'user_id' => $customer->id,
            'isi_ulasan' => 'Velgnya bagus banget, kuat dan ringan!',
            'rating' => 5,
        ]);

        // ===============================
        // 7️⃣ Voucher
        // ===============================
        Voucher::create([
            'user_id' => $customer->id,
            'kode_voucher' => 'PROMO20RB-' . Str::upper(Str::random(4)),
            'nominal' => 20000,
            'status' => 'belum_digunakan',
            'tanggal_kadaluarsa' => now()->addDays(30),
        ]);

        // ===============================
        // 8️⃣ Notifikasi
        // ===============================
        Notifikasi::create([
            'user_id' => $customer->id,
            'judul' => 'Selamat Datang di VelgKu!',
            'pesan' => 'Kamu mendapatkan voucher 20rb untuk pembelian pertama. Gunakan sebelum 30 hari!',
            'dibaca' => false,
        ]);

        Notifikasi::create([
            'user_id' => $customer->id,
            'judul' => 'Ulasan Diterima!',
            'pesan' => 'Terima kasih sudah memberi ulasan. Kamu dapat voucher 20rb tambahan.',
            'dibaca' => false,
        ]);
    }
}
