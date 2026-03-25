<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Member, Category, Article, Event, LearningMaterial, OrganizationStructure, SiteSetting};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Administrator HPMI',
            'email' => 'admin@hpmi.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Member gratis (free)
        $memberUser = User::create([
            'name' => 'Budi Santoso',
            'email' => 'member@hpmi.id',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);
        Member::create([
            'user_id'   => $memberUser->id,
            'phone'     => '08123456789',
            'institution' => 'RSUP Dr. Sardjito',
            'specialty' => 'Manajemen Keperawatan',
            'status'    => 'free',
            'joined_at' => now(),
        ]);

        // Member premium
        $premiumUser = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'premium@hpmi.id',
            'password' => Hash::make('password'),
            'role' => 'premium',
        ]);
        Member::create([
            'user_id'    => $premiumUser->id,
            'phone'      => '08987654321',
            'institution'=> 'RS Cipto Mangunkusumo',
            'specialty'  => 'Keperawatan ICU',
            'status'     => 'premium',
            'joined_at'  => now()->subYear(),
            'expired_at' => now()->addYear(),
        ]);

        // Categories
        $cats = [
            ['name'=>'Manajemen Keperawatan','slug'=>'manajemen-keperawatan','type'=>'article','color'=>'blue'],
            ['name'=>'Kebijakan Kesehatan',  'slug'=>'kebijakan-kesehatan',  'type'=>'article','color'=>'green'],
            ['name'=>'Keperawatan Klinis',   'slug'=>'keperawatan-klinis',   'type'=>'material','color'=>'purple'],
            ['name'=>'Kepemimpinan',         'slug'=>'kepemimpinan',         'type'=>'material','color'=>'orange'],
        ];
        foreach ($cats as $c) Category::create($c);

        $cat1 = Category::first();

        // Sample articles
        for ($i = 1; $i <= 6; $i++) {
            Article::create([
                'user_id'      => $admin->id,
                'category_id'  => $cat1->id,
                'title'        => 'Artikel Keperawatan Manajer #'.$i,
                'slug'         => 'artikel-keperawatan-'.$i.'-'.time().$i,
                'excerpt'      => 'Ringkasan artikel tentang keperawatan manajer ke-'.$i,
                'content'      => 'Konten lengkap artikel tentang perkembangan keperawatan manajer di Indonesia. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'status'       => 'published',
                'published_at' => now()->subDays($i),
            ]);
        }

        // Sample events
        Event::create([
            'user_id'     => $admin->id,
            'title'       => 'Seminar Nasional Keperawatan Manajer 2025',
            'slug'        => 'seminar-nasional-2025-'.time(),
            'description' => 'Seminar nasional untuk para perawat manajer di seluruh Indonesia. Menghadirkan pembicara terkemuka dari berbagai institusi kesehatan.',
            'location'    => 'Jakarta Convention Center',
            'start_date'  => now()->addMonth(),
            'end_date'    => now()->addMonth()->addDays(2),
            'price'       => 250000,
            'is_free'     => false,
            'quota'       => 200,
            'status'      => 'open',
        ]);

        Event::create([
            'user_id'     => $admin->id,
            'title'       => 'Webinar: Kepemimpinan dalam Keperawatan Modern',
            'slug'        => 'webinar-kepemimpinan-'.time(),
            'description' => 'Webinar eksklusif tentang kepemimpinan transformatif dalam keperawatan.',
            'location'    => 'Online via Zoom',
            'meeting_url' => 'https://zoom.us/j/example',
            'start_date'  => now()->addWeeks(2),
            'end_date'    => now()->addWeeks(2)->addHours(3),
            'price'       => 0,
            'is_free'     => true,
            'quota'       => 500,
            'status'      => 'open',
        ]);

        // Sample learning materials - sebagian gratis, sebagian premium
        $matCat = Category::where('type','material')->first();
        LearningMaterial::create([
            'user_id'      => $admin->id,
            'category_id'  => $matCat?->id,
            'title'        => '[GRATIS] Panduan Dasar Manajemen Keperawatan',
            'description'  => 'Modul pengantar untuk memahami dasar-dasar manajemen keperawatan.',
            'type'         => 'pdf',
            'file_url'     => 'https://example.com/materi-dasar.pdf',
            'is_member_only' => false, // GRATIS untuk semua member
        ]);
        LearningMaterial::create([
            'user_id'      => $admin->id,
            'category_id'  => $matCat?->id,
            'title'        => '[PREMIUM] Strategi Kepemimpinan Keperawatan Lanjutan',
            'description'  => 'Modul lanjutan khusus anggota premium tentang strategi kepemimpinan.',
            'type'         => 'module',
            'file_url'     => 'https://example.com/materi-premium.pdf',
            'is_member_only' => true, // PREMIUM only
        ]);
        LearningMaterial::create([
            'user_id'      => $admin->id,
            'category_id'  => $matCat?->id,
            'title'        => '[PREMIUM] Video: Manajemen Konflik di Rumah Sakit',
            'description'  => 'Video pembelajaran eksklusif tentang manajemen konflik.',
            'type'         => 'video',
            'video_url'    => 'https://youtube.com/watch?v=example',
            'is_member_only' => true, // PREMIUM only
        ]);

        // Org structures
        $pengurus = [
            ['Ns. Dr. Rina Hastuti, S.Kep., M.Kep.', 'Ketua Umum'],
            ['Ns. Ahmad Fauzi, S.Kep., M.M.', 'Sekretaris Jenderal'],
            ['Ns. Dewi Kusumawati, S.Kep., M.Kes.', 'Bendahara Umum'],
            ['Ns. Bambang Wibowo, S.Kep., Sp.KMB', 'Ketua Bidang Pendidikan'],
            ['Ns. Sri Mulyani, S.Kep., M.M.', 'Ketua Bidang Organisasi'],
        ];
        foreach ($pengurus as $i => [$name, $position]) {
            OrganizationStructure::create([
                'name'        => $name,
                'position'    => $position,
                'period'      => '2022-2026',
                'order_index' => $i,
                'is_active'   => true,
            ]);
        }

        // Site settings
        $settings = [
            ['site_name',  'HPMI - Himpunan Perawat Manajer Indonesia', 'general'],
            ['site_email', 'sekretariat@hpmi.id', 'general'],
            ['site_phone', '021-12345678', 'contact'],
            ['site_address','Jl. Kesehatan No. 1, Jakarta Pusat 10110', 'contact'],
        ];
        foreach ($settings as [$k,$v,$g]) {
            SiteSetting::create(['key'=>$k,'value'=>$v,'group'=>$g,'type'=>'text']);
        }
    }
}
