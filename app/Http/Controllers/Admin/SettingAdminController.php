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
        $slides = collect(range(1, 5))->map(function ($i) use ($settings) {
            $path = $settings['banner_slide_'.$i.'_image']?->value ?? '';

            return [
                'index'        => $i,
                'path'         => $path,
                'preview_url'  => $path && Storage::disk('public')->exists($path)
                                    ? Storage::url($path)
                                    : null,
                'title'        => $settings['banner_slide_'.$i.'_title']?->value    ?? '',
                'subtitle'     => $settings['banner_slide_'.$i.'_subtitle']?->value ?? '',
                'link'         => $settings['banner_slide_'.$i.'_link']?->value     ?? '',
                'color'        => $settings['banner_slide_'.$i.'_color']?->value    ?? '#1a4e8a',
                'active'       => ($settings['banner_slide_'.$i.'_active']?->value  ?? '1') === '1',
            ];
        });

        // Siapkan data bank
        $banks = collect(range(1, 5))->map(fn($i) => [
            'index'  => $i,
            'name'   => $settings["bank_{$i}_name"]?->value   ?? '',
            'number' => $settings["bank_{$i}_number"]?->value ?? '',
            'owner'  => $settings["bank_{$i}_owner"]?->value  ?? '',
            'active' => ($settings["bank_{$i}_active"]?->value ?? '0') === '1',
        ]);

        // Siapkan URL logo saat ini untuk preview di form
        $logoPath = $settings['site_logo']?->value ?? '';
        $logoPreviewUrl = $logoPath && Storage::disk('public')->exists($logoPath)
                            ? Storage::url($logoPath)
                            : null;

        return view('admin.settings.index', compact('settings', 'slides', 'banks', 'logoPreviewUrl'));
    }

    // ── Simpan semua pengaturan ke DB ─────────────────────────────
    public function update(Request $request)
    {
        $request->validate([
            'site_logo_file'            => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'banner_slide_1_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'banner_slide_2_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'banner_slide_3_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'banner_slide_4_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'banner_slide_5_image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'site_logo_file.image' => 'File logo harus berupa gambar (JPG, PNG, WEBP, atau SVG).',
            'site_logo_file.max'   => 'Ukuran logo maksimal 2 MB.',
            'banner_slide_*.image' => 'File harus berupa gambar (JPG, PNG, atau WEBP).',
            'banner_slide_*.max'   => 'Ukuran file maksimal 5 MB.',
        ]);

        // ── 1. Hapus logo jika diminta ────────────────────────────
        if ($request->input('remove_logo') === '1') {
            $old = SiteSetting::where('key', 'site_logo')->value('value');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            SiteSetting::set('site_logo', '');
        }

        // ── 2. Proses upload logo baru ────────────────────────────
        if ($request->hasFile('site_logo_file') && $request->file('site_logo_file')->isValid()) {
            $old = SiteSetting::where('key', 'site_logo')->value('value');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $newPath = $request->file('site_logo_file')->store('logos', 'public');
            SiteSetting::set('site_logo', $newPath);
        }

        // ── 3. Proses upload gambar banner (slide 1–5) ────────────
        for ($i = 1; $i <= 5; $i++) {
            $fileKey    = "banner_slide_{$i}_image_file";
            $settingKey = "banner_slide_{$i}_image";

            if ($request->hasFile($fileKey) && $request->file($fileKey)->isValid()) {
                $old = SiteSetting::where('key', $settingKey)->value('value');
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
                $newPath = $request->file($fileKey)->store('banners', 'public');
                SiteSetting::set($settingKey, $newPath);
            }
        }

        // ── 4. Simpan semua field teks ────────────────────────────
        $skip = array_merge(
            ['_token', '_method', 'site_logo_file', 'remove_logo'],
            array_map(fn($i) => "banner_slide_{$i}_image_file", range(1, 5)),
        );

        foreach ($request->except($skip) as $key => $value) {
            SiteSetting::set($key, $value ?? '');
        }

        // ── 5. Handle fitur toggle yang tidak disubmit = '0' ──────
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

        // ── 6. Handle banner_active yang tidak disubmit = '0' ─────
        for ($i = 1; $i <= 5; $i++) {
            if (!$request->has("banner_slide_{$i}_active")) {
                SiteSetting::set("banner_slide_{$i}_active", '0');
            }
        }

        // ── 7. Handle bank_active yang tidak disubmit = '0' ───────
        for ($i = 1; $i <= 5; $i++) {
            if (!$request->has("bank_{$i}_active")) {
                SiteSetting::set("bank_{$i}_active", '0');
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}