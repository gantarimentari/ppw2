<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan model Buku ada dan property $fillable-nya sudah diatur
        Buku::create([
            'judul' => 'Sherlock Holmes: The Sign of Four',
            'penulis' => 'Sir Arthur Conan Doyle',
            'harga' => 120000.00,
            'tgl_terbit' => '1976-06-22',
            // created_at dan updated_at akan diisi oleh timestamps()
        ]);
        Buku::create([
            'judul' => 'Sherlock Holmes: The Hound of Baskervilles',
            'penulis' => 'Sir Arthur Conan Doyle',
            'harga' => 150000.00,
            'tgl_terbit' => '1902-03-25',
        ]);
        // Tambahkan minimal 3 data lagi (total 5) agar pagination terlihat
        Buku::create(['judul' => 'Sherlock Holmes: A Study in Scarlet', 'penulis' => 'Sir Arthur Conan Doyle', 'harga' => 110000.00, 'tgl_terbit' => '1887-12-01']);
        Buku::create(['judul' => 'A Dance with Dragons', 'penulis' => 'George R.R. Martin', 'harga' => 200000.00, 'tgl_terbit' => '2011-07-12']);
        Buku::create(['judul' => 'A Song of Ice and Fire', 'penulis' => 'George R.R. Martin', 'harga' => 250000.00, 'tgl_terbit' => '1996-08-01']);
    }
}