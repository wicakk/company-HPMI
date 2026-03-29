<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanans = [
            [
                'nama'              => 'Instalasi Gawat Darurat',
                'ikon'              => '🚑',
                'deskripsi_singkat' => 'Layanan darurat 24 jam dengan tim medis siap siaga untuk penanganan kondisi kritis.',
                'deskripsi_lengkap' => '<p>Instalasi Gawat Darurat (IGD) HPMI beroperasi 24 jam sehari, 7 hari seminggu, diperkuat oleh tim dokter dan perawat terlatih yang siap menangani berbagai kondisi darurat medis.</p><p>Fasilitas IGD kami dilengkapi dengan peralatan medis modern dan sistem triage yang memastikan pasien mendapatkan penanganan sesuai tingkat kegawatdaruratan.</p>',
                'kategori'          => 'Darurat',
                'urutan'            => 1,
                'status'            => 'aktif',
            ],
            [
                'nama'              => 'Rawat Inap',
                'ikon'              => '🛏️',
                'deskripsi_singkat' => 'Fasilitas rawat inap nyaman dengan kamar berbagai kelas, dilengkapi perawat berpengalaman.',
                'deskripsi_lengkap' => '<p>Fasilitas rawat inap HPMI menyediakan kamar dari kelas VIP hingga kelas III yang nyaman dan bersih. Setiap ruang rawat inap dilengkapi dengan fasilitas modern dan perawat yang berpengalaman siaga 24 jam.</p>',
                'kategori'          => 'Rawat Inap',
                'urutan'            => 2,
                'status'            => 'aktif',
            ],
            [
                'nama'              => 'Poli Umum',
                'ikon'              => '🩺',
                'deskripsi_singkat' => 'Konsultasi kesehatan umum dengan dokter umum berpengalaman setiap hari kerja.',
                'deskripsi_lengkap' => '<p>Poli Umum melayani konsultasi kesehatan untuk berbagai keluhan medis umum. Dokter umum kami yang berpengalaman siap memberikan pemeriksaan, diagnosis, dan penanganan yang tepat.</p>',
                'kategori'          => 'Poliklinik',
                'urutan'            => 3,
                'status'            => 'aktif',
            ],
            [
                'nama'              => 'Poli Jantung',
                'ikon'              => '❤️',
                'deskripsi_singkat' => 'Penanganan komprehensif penyakit kardiovaskular oleh spesialis jantung bersertifikat.',
                'deskripsi_lengkap' => '<p>Poli Jantung HPMI memberikan pelayanan diagnosis dan penanganan menyeluruh untuk berbagai penyakit kardiovaskular. Didukung oleh dokter spesialis jantung bersertifikat dan peralatan kardiologi terkini.</p>',
                'kategori'          => 'Poliklinik',
                'urutan'            => 4,
                'status'            => 'aktif',
            ],
            [
                'nama'              => 'Poli Anak',
                'ikon'              => '👶',
                'deskripsi_singkat' => 'Layanan kesehatan anak dari bayi hingga remaja oleh dokter spesialis anak.',
                'deskripsi_lengkap' => '<p>Poli Anak HPMI memberikan pelayanan kesehatan yang komprehensif untuk anak dari usia bayi hingga remaja. Dengan pendekatan yang ramah anak dan dokter spesialis anak berpengalaman, kami memastikan tumbuh kembang si kecil terpantau dengan baik.</p>',
                'kategori'          => 'Poliklinik',
                'urutan'            => 5,
                'status'            => 'aktif',
            ],
            [
                'nama'              => 'Poli Kandungan',
                'ikon'              => '🤰',
                'deskripsi_singkat' => 'Perawatan lengkap ibu hamil dan kesehatan reproduksi wanita oleh dokter spesialis.',
                'deskripsi_lengkap' => '<p>Poli Kandungan & Kebidanan HPMI menyediakan pelayanan kesehatan reproduksi wanita secara menyeluruh, mulai dari pemeriksaan kehamilan, persalinan, hingga penanganan gangguan reproduksi.</p>',
                'kategori'          => 'Poliklinik',
                'urutan'            => 6,
                'status'            => 'aktif',
            ],
        ];

        foreach ($layanans as $data) {
            Layanan::updateOrCreate(['nama' => $data['nama']], $data);
        }
    }
}
