<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingAdminController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $settings = SiteSetting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        try {
            foreach ($request->except(['_token', '_method']) as $key => $value) {
                SiteSetting::set($key, $value);
            }
            return back()->with('success', 'Pengaturan berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan pengaturan: ' . $e->getMessage());
        }
    }
}