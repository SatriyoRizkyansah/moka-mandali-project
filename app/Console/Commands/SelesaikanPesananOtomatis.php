<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pesanan;
use Carbon\Carbon;

class SelesaikanPesananOtomatis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pesanan:selesaikan-otomatis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menyelesaikan pesanan dengan status dikirim yang sudah lebih dari 1 bulan secara otomatis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mencari pesanan yang perlu diselesaikan otomatis...');

        // Ambil pesanan dengan status 'dikirim' yang sudah lebih dari 1 bulan
        $pesananTuaSebulan = Pesanan::where('status', 'dikirim')
            ->where('updated_at', '<=', Carbon::now()->subMonth())
            ->get();

        if ($pesananTuaSebulan->count() === 0) {
            $this->info('Tidak ada pesanan yang perlu diselesaikan otomatis.');
            return;
        }

        $jumlahDiselesaikan = 0;

        foreach ($pesananTuaSebulan as $pesanan) {
            $pesanan->update([
                'status' => 'selesai',
                'tanggal_selesai' => now()
            ]);
            
            $jumlahDiselesaikan++;
            $this->line("Pesanan {$pesanan->id} diselesaikan otomatis.");
        }

        $this->info("Selesai! {$jumlahDiselesaikan} pesanan telah diselesaikan otomatis.");
    }
}
