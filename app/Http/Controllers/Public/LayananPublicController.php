<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\View\View;

class LayananPublicController extends Controller
{
    // ── Halaman daftar semua layanan ──────────────────────────────────────────
    public function index(): View
    {
        $layanans = Layanan::aktif()->urut()->get();

        $grouped = $layanans->groupBy('kategori');

        return view('public.layanan.index', compact('layanans', 'grouped'));
    }

    // ── Detail satu layanan ───────────────────────────────────────────────────
    public function show(string $slug): View
    {
        $layanan = Layanan::aktif()->where('slug', $slug)->firstOrFail();

        $related = Layanan::aktif()
            ->urut()
            ->where('id', '!=', $layanan->id)
            ->where('kategori', $layanan->kategori)
            ->limit(3)
            ->get();

        return view('public.layanan.show', compact('layanan', 'related'));
    }
}
