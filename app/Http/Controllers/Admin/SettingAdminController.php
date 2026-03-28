<?php
// app/Http/Controllers/Admin/SettingAdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingAdminController extends Controller
{
    // ── Tampilkan halaman pengaturan ──────────────────────────────
    public function index()
    {
        // Ambil semua setting dari DB, index by key
        $settings = SiteSetting::all()->keyBy('key');

        // Siapkan data slides untuk ditampilkan di blade
        // (konversi path relatif → URL publik untuk preview)
        $slides = collect(range(1, 5))->map(function ($i) use ($settings) {
            $path = $settings['banner_slide_'.$i.'_image']?->value ?? '';

            return [
                'index'        => $i,
                'path'         => $path,  // path relatif di DB: "banners/xxx.jpg"
                'preview_url'  => $path && Storage::disk('public')->exists($path)
                                    ? Storage::url($path)
                                    : null,
                'title'        => $settings['banner_slide_'.$i.'_title']?->value    ?? '',
                'subtitle'     => $settings['banner_slide_'.$i.'_subtitle']?->value ?? '',
                'link'         => $settings['banner_slide_'.$i.'_link']?->value     ?? '',
                'color'        => $settings['banner_slide_'.$i.'_color']?->value    ?? '#1a4e8a',
                'active'       => ($settings['banner_slide_'.$i.'_active']?->value  ?? '1') === '1',
            ];


             // Tambahkan ini — siapkan data bank
             });
             $banks = collect(range(1, 5))->map(fn($i) => [
                 'index'  => $i,
                 'name'   => $settings["bank_{$i}_name"]?->value   ?? '',
                 'number' => $settings["bank_{$i}_number"]?->value ?? '',
                 'owner'  => $settings["bank_{$i}_owner"]?->value  ?? '',
                 'active' => ($settings["bank_{$i}_active"]?->value ?? '0') === '1',
             ]);

        return view('admin.settings.index', compact('settings', 'slides', 'banks'));
    }

    // ── Simpan semua pengaturan ke DB ─────────────────────────────
    public function update(Request $request)
    {
        $request->validate([
            'banner_slide_1_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'banner_slide_2_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'banner_slide_3_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'banner_slide_4_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'banner_slide_5_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'banner_slide_*.image' => 'File harus berupa gambar (JPG, PNG, atau WEBP).',
            'banner_slide_*.max'   => 'Ukuran file maksimal 5 MB.',
        ],[
            'bank_1_number' => 'nullable|string|max:30',
            'bank_2_number' => 'nullable|string|max:30',
            'bank_3_number' => 'nullable|string|max:30',
            'bank_4_number' => 'nullable|string|max:30',
            'bank_5_number' => 'nullable|string|max:30',
        ]);

        for ($i = 1; $i <= 5; $i++) {
            if (!$request->has("bank_{$i}_active")) {
                SiteSetting::set("bank_{$i}_active", '0');
            }
        }

        // ── 1. Proses upload gambar banner (slide 1–5) ────────────
        for ($i = 1; $i <= 5; $i++) {
            $fileKey    = "banner_slide_{$i}_image_file";
            $settingKey = "banner_slide_{$i}_image";
            

            if ($request->hasFile($fileKey) && $request->file($fileKey)->isValid()) {
                // Hapus file lama jika ada
                $old = SiteSetting::where('key', $settingKey)->value('value');
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }

                // Simpan file baru → hasilnya path relatif: "banners/namafile.jpg"
                $newPath = $request->file($fileKey)->store('banners', 'public');

                // Simpan PATH RELATIF ke DB (bukan full URL!)
                SiteSetting::set($settingKey, $newPath);

            } else {
                // Tidak ada upload baru → pertahankan nilai lama dari DB
                // (tidak perlu update, biarkan saja)
            }
        }

        // ── 2. Simpan semua field teks lainnya ────────────────────
        $skip = array_merge(
            ['_token', '_method'],
            array_map(fn($i) => "banner_slide_{$i}_image_file", range(1, 5)),
        );

        foreach ($request->except($skip) as $key => $value) {
            SiteSetting::set($key, $value ?? '');
        }

        // ── 3. Handle fitur toggle yg tidak disubmit = nilai '0' ─
        $featureKeys = [
            'feature_registration',
            'feature_virtual_payment',
            'feature_maintenance',
            'feature_email_notification',
            'feature_article_comment',
            'feature_dark_mode',
        ];
        foreach ($featureKeys as $key) {
            if (!$request->has($key)) {
                SiteSetting::set($key, '0');
            }
        }

        // ── 4. Handle banner_active yang tidak disubmit = '0' ────
        for ($i = 1; $i <= 5; $i++) {
            if (!$request->has("banner_slide_{$i}_active")) {
                SiteSetting::set("banner_slide_{$i}_active", '0');
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
