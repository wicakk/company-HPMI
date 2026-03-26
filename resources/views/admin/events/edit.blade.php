@extends('layouts.admin')
@section('title', isset($event) ? 'Edit Kegiatan' : 'Tambah Kegiatan')
@section('content')

<style>
    /* @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap'); */

    /* .form-root { font-family: 'Plus Jakarta Sans', sans-serif; } */

    .back-btn {
        width: 38px; height: 38px; border-radius: 11px; display: grid; place-items: center;
        background: #fff; border: 1.5px solid #e2e8f0; color: #64748b;
        transition: all .15s; text-decoration: none;
    }
    .back-btn:hover { border-color: #a78bfa; color: #7c3aed; background: #f5f3ff; }
    .dark .back-btn { background: #1f2937; border-color: #374151; color: #9ca3af; }
    .dark .back-btn:hover { border-color: #7c3aed; color: #a78bfa; }

    .page-title { font-family: 'Syne', sans-serif; font-size: 1.5rem; font-weight: 800; color: #0f172a; }
    .dark .page-title { color: #f8fafc; }

    /* Section card */
    .form-card {
        background: #fff; border-radius: 20px; border: 1.5px solid #f1f5f9;
        overflow: hidden;
    }
    .dark .form-card { background: #1f2937; border-color: #374151; }

    .form-card-header {
        padding: 18px 24px; border-bottom: 1.5px solid #f1f5f9;
        display: flex; align-items: center; gap: 10px;
    }
    .dark .form-card-header { border-color: #374151; }
    .card-header-icon {
        width: 34px; height: 34px; border-radius: 10px;
        display: grid; place-items: center; flex-shrink: 0;
    }
    .form-card-title { font-weight: 800; font-size: 14px; color: #0f172a; }
    .dark .form-card-title { color: #f8fafc; }

    .form-card-body { padding: 24px; display: flex; flex-direction: column; gap: 20px; }

    /* Field */
    .field-label {
        display: block; font-size: 12px; font-weight: 700; color: #374151;
        letter-spacing: .04em; text-transform: uppercase; margin-bottom: 8px;
    }
    .dark .field-label { color: #9ca3af; }
    .req { color: #e11d48; }

    .field-input {
        width: 100%; padding: 11px 16px; border-radius: 12px;
        border: 1.5px solid #e2e8f0; font-size: 13.5px; font-family: inherit;
        background: #fafafa; color: #0f172a; outline: none; transition: border-color .15s;
        box-sizing: border-box;
    }
    .field-input:focus { border-color: #7c3aed; background: #fff; box-shadow: 0 0 0 3px rgba(124,58,237,.08); }
    .dark .field-input { background: #111827; border-color: #374151; color: #f8fafc; }
    .dark .field-input:focus { border-color: #7c3aed; background: #1a1a2e; }

    textarea.field-input { resize: vertical; min-height: 140px; line-height: 1.6; }

    /* Upload zone */
    .upload-zone {
        border: 2px dashed #e2e8f0; border-radius: 16px;
        padding: 32px 20px; text-align: center; cursor: pointer;
        transition: all .2s; background: #fafafa; position: relative;
    }
    .upload-zone:hover, .upload-zone.drag-over {
        border-color: #7c3aed; background: #f5f3ff;
    }
    .dark .upload-zone { background: #111827; border-color: #374151; }
    .dark .upload-zone:hover, .dark .upload-zone.drag-over { border-color: #7c3aed; background: rgba(109,40,217,.08); }
    .upload-zone input[type=file] {
        position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;
    }
    .upload-icon {
        width: 52px; height: 52px; border-radius: 16px; background: #ede9fe;
        display: grid; place-items: center; margin: 0 auto 12px;
    }
    .dark .upload-icon { background: rgba(109,40,217,.2); }
    .upload-title { font-weight: 700; font-size: 14px; color: #374151; margin-bottom: 4px; }
    .dark .upload-title { color: #d1d5db; }
    .upload-sub { font-size: 12px; color: #94a3b8; }
    .upload-formats { 
        display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 12px;
        flex-wrap: wrap;
    }
    .format-badge {
        padding: 2px 10px; border-radius: 999px; font-size: 11px; font-weight: 700;
        background: #f1f5f9; color: #64748b;
    }
    .dark .format-badge { background: #374151; color: #94a3b8; }

    /* Preview */
    .thumb-preview {
        border-radius: 16px; overflow: hidden; position: relative; display: none;
    }
    .thumb-preview img { width: 100%; height: 180px; object-fit: cover; display: block; }
    .thumb-remove {
        position: absolute; top: 10px; right: 10px; width: 30px; height: 30px;
        border-radius: 50%; background: rgba(0,0,0,.5); color: #fff;
        display: grid; place-items: center; cursor: pointer; border: none;
        backdrop-filter: blur(4px); transition: background .15s;
    }
    .thumb-remove:hover { background: rgba(225,29,72,.8); }

    /* URL Tab */
    .tab-switcher {
        display: flex; border-radius: 12px; padding: 4px; background: #f1f5f9; gap: 2px;
    }
    .dark .tab-switcher { background: #111827; }
    .tab-btn {
        flex: 1; padding: 8px; border-radius: 9px; border: none; cursor: pointer;
        font-size: 12px; font-weight: 700; font-family: inherit; transition: all .15s;
        background: transparent; color: #94a3b8;
    }
    .tab-btn.active { background: #fff; color: #7c3aed; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
    .dark .tab-btn.active { background: #1f2937; }

    /* Checkbox toggle */
    .toggle-group { display: flex; flex-direction: column; gap: 10px; }
    .toggle-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 16px; border-radius: 12px; border: 1.5px solid #f1f5f9;
        cursor: pointer; transition: border-color .15s;
    }
    .dark .toggle-item { border-color: #374151; }
    .toggle-item:has(input:checked) { border-color: #a78bfa; background: #f5f3ff; }
    .dark .toggle-item:has(input:checked) { background: rgba(109,40,217,.08); }
    .toggle-label { font-size: 13px; font-weight: 600; color: #374151; }
    .dark .toggle-label { color: #d1d5db; }
    .toggle-desc { font-size: 11px; color: #94a3b8; margin-top: 1px; }

    /* Switch */
    .switch { position: relative; width: 40px; height: 22px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .switch-track {
        position: absolute; inset: 0; border-radius: 999px;
        background: #e2e8f0; transition: background .2s; cursor: pointer;
    }
    .switch-track::after {
        content: ''; position: absolute; width: 16px; height: 16px;
        border-radius: 50%; background: #fff; top: 3px; left: 3px;
        transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2);
    }
    .switch input:checked + .switch-track { background: #7c3aed; }
    .switch input:checked + .switch-track::after { transform: translateX(18px); }

    /* Submit buttons */
    .btn-primary {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        height: 46px; border-radius: 13px; font-weight: 800; font-size: 14px;
        background: linear-gradient(135deg, #7c3aed, #4f46e5); color: #fff;
        border: none; cursor: pointer; font-family: inherit; width: 100%;
        transition: all .2s; box-shadow: 0 4px 14px rgba(109,40,217,.35);
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(109,40,217,.4); }

    .btn-secondary {
        display: flex; align-items: center; justify-content: center; height: 46px;
        border-radius: 13px; font-weight: 700; font-size: 14px;
        background: #f1f5f9; color: #475569; border: none; cursor: pointer;
        font-family: inherit; width: 100%; text-decoration: none; transition: background .15s;
    }
    .btn-secondary:hover { background: #e2e8f0; }
    .dark .btn-secondary { background: #374151; color: #9ca3af; }

    /* Progress bar */
    .upload-progress { display: none; margin-top: 12px; }
    .progress-bar-track { height: 4px; background: #e2e8f0; border-radius: 999px; overflow: hidden; }
    .progress-bar-fill { height: 100%; background: linear-gradient(90deg,#7c3aed,#4f46e5); border-radius: 999px; width: 0; transition: width .3s; }
    .progress-label { font-size: 11px; color: #7c3aed; font-weight: 600; margin-top: 6px; }

    /* Existing thumbnail chip */
    .existing-thumb {
        display: flex; align-items: center; gap: 10px; padding: 10px 14px;
        background: #f5f3ff; border-radius: 12px; border: 1.5px solid #ede9fe;
        font-size: 12px; color: #6d28d9; font-weight: 600; margin-bottom: 10px;
    }
    .dark .existing-thumb { background: rgba(109,40,217,.1); border-color: rgba(109,40,217,.2); color: #a78bfa; }

    @media (max-width: 1024px) {
        .layout-grid { grid-template-columns: 1fr !important; }
    }
</style>

<div class="form-root space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.events.index') }}" class="back-btn">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <p style="font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#7c3aed;margin-bottom:2px">
                {{ isset($event) ? 'Edit' : 'Baru' }}
            </p>
            <h2 class="page-title">{{ isset($event) ? 'Edit Kegiatan' : 'Tambah Kegiatan' }}</h2>
        </div>
    </div>

    @if($errors->any())
    <div style="padding:16px 20px;background:#fff1f2;border:1.5px solid #fecdd3;border-radius:14px">
        <p style="font-weight:700;font-size:13px;color:#be123c;margin-bottom:6px">Ada kesalahan input:</p>
        <ul style="list-style:disc;padding-left:20px;margin:0">
            @foreach($errors->all() as $err)
            <li style="font-size:12px;color:#e11d48">{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST"
          action="{{ isset($event) ? route('admin.events.update', $event) : route('admin.events.store') }}"
          enctype="multipart/form-data"
          id="eventForm">
        @csrf
        @if(isset($event)) @method('PUT') @endif

        <div class="layout-grid" style="display:grid;grid-template-columns:1fr 360px;gap:20px;align-items:start">

            {{-- LEFT COLUMN --}}
            <div style="display:flex;flex-direction:column;gap:20px">

                {{-- Info Dasar --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="card-header-icon" style="background:#f5f3ff">
                            <svg class="w-4 h-4" style="color:#7c3aed" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="form-card-title">Informasi Utama</span>
                    </div>
                    <div class="form-card-body">
                        <div>
                            <label class="field-label">Judul Kegiatan <span class="req">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}"
                                   required placeholder="Nama kegiatan yang menarik..." class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Deskripsi</label>
                            <textarea name="description" placeholder="Jelaskan detail kegiatan, tujuan, dan manfaatnya..." class="field-input">{{ old('description', $event->description ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Waktu & Tempat --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="card-header-icon" style="background:#f0fdf4">
                            <svg class="w-4 h-4" style="color:#059669" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="form-card-title">Waktu & Tempat</span>
                    </div>
                    <div class="form-card-body">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                            <div>
                                <label class="field-label">Tanggal Mulai <span class="req">*</span></label>
                                <input type="datetime-local" name="start_date" required class="field-input"
                                       value="{{ old('start_date', isset($event->start_date) ? \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i') : '') }}">
                            </div>
                            <div>
                                <label class="field-label">Tanggal Selesai</label>
                                <input type="datetime-local" name="end_date" class="field-input"
                                       value="{{ old('end_date', isset($event->end_date) ? \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i') : '') }}">
                            </div>
                        </div>
                        <div>
                            <label class="field-label">Lokasi / Tempat</label>
                            <input type="text" name="location" class="field-input"
                                   value="{{ old('location', $event->location ?? '') }}"
                                   placeholder="Nama tempat atau 'Online via Zoom'">
                        </div>
                        <div>
                            <label class="field-label">Link Meeting (Online)</label>
                            <input type="url" name="meeting_url" class="field-input"
                                   value="{{ old('meeting_url', $event->meeting_url ?? '') }}"
                                   placeholder="https://zoom.us/j/...">
                        </div>
                    </div>
                </div>

                {{-- Thumbnail --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="card-header-icon" style="background:#fff7ed">
                            <svg class="w-4 h-4" style="color:#ea580c" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="form-card-title">Thumbnail / Gambar</span>
                    </div>
                    <div class="form-card-body">
                        {{-- Tab switch --}}
                        <div class="tab-switcher" id="thumbTabSwitch">
                            <button type="button" class="tab-btn active" onclick="switchThumbTab('upload')">Upload File</button>
                            <button type="button" class="tab-btn" onclick="switchThumbTab('url')">URL Gambar</button>
                        </div>

                        {{-- Upload Tab --}}
                        <div id="tabUpload">
                            @if(isset($event) && $event->thumbnail && !filter_var($event->thumbnail, FILTER_VALIDATE_URL) === false)
                            <div class="existing-thumb" id="existingThumbChip">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Thumbnail saat ini tersimpan</span>
                                <a href="{{ $event->thumbnail }}" target="_blank" style="color:inherit;text-decoration:underline;font-size:11px">Lihat</a>
                            </div>
                            @endif

                            {{-- Preview --}}
                            <div class="thumb-preview" id="thumbPreview">
                                <img id="thumbPreviewImg" src="" alt="Preview">
                                <button type="button" class="thumb-remove" onclick="removeThumbnail()">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            {{-- Drop Zone --}}
                            <div class="upload-zone" id="uploadZone">
                                <input type="file" name="thumbnail_file" id="thumbnailFile"
                                       accept="image/jpeg,image/png,image/webp,image/gif"
                                       onchange="handleFileSelect(this)">
                                <div class="upload-icon">
                                    <svg class="w-7 h-7" style="color:#7c3aed" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                </div>
                                <div class="upload-title">Drag & drop atau klik untuk upload</div>
                                <div class="upload-sub">Kualitas terbaik: rasio 16:9, min 800×450px</div>
                                <div class="upload-formats">
                                    <span class="format-badge">JPG</span>
                                    <span class="format-badge">PNG</span>
                                    <span class="format-badge">WebP</span>
                                    <span class="format-badge">GIF</span>
                                    <span class="format-badge">Max 5MB</span>
                                </div>
                            </div>

                            <div class="upload-progress" id="uploadProgress">
                                <div class="progress-bar-track"><div class="progress-bar-fill" id="progressFill"></div></div>
                                <div class="progress-label" id="progressLabel">Mengupload...</div>
                            </div>
                        </div>

                        {{-- URL Tab --}}
                        <div id="tabUrl" style="display:none">
                            <label class="field-label">URL Gambar</label>
                            <input type="text" name="thumbnail" id="thumbnailUrl" class="field-input"
                                   value="{{ old('thumbnail', $event->thumbnail ?? '') }}"
                                   placeholder="https://example.com/gambar.jpg"
                                   oninput="previewUrl(this.value)">
                            <div class="thumb-preview" id="urlPreview" style="margin-top:12px">
                                <img id="urlPreviewImg" src="" alt="URL Preview">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div style="display:flex;flex-direction:column;gap:20px;position:sticky;top:20px">

                {{-- Pengaturan --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="card-header-icon" style="background:#eff6ff">
                            <svg class="w-4 h-4" style="color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="form-card-title">Pengaturan</span>
                    </div>
                    <div class="form-card-body">
                        <div>
                            <label class="field-label">Status Pendaftaran</label>
                            <select name="status" class="field-input">
                                @foreach(['draft'=>'📝 Draft','open'=>'✅ Buka Pendaftaran','closed'=>'🔒 Tutup Pendaftaran','completed'=>'🎉 Selesai'] as $val=>$lbl)
                                <option value="{{ $val }}" {{ old('status', $event->status ?? 'draft')===$val ? 'selected' : '' }}>{{ $lbl }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                            <div>
                                <label class="field-label">Harga (Rp)</label>
                                <input type="number" name="price" min="0" class="field-input"
                                       value="{{ old('price', $event->price ?? 0) }}" placeholder="0">
                            </div>
                            <div>
                                <label class="field-label">Kuota</label>
                                <input type="number" name="quota" min="0" class="field-input"
                                       value="{{ old('quota', $event->quota ?? '') }}"
                                       placeholder="∞ tak terbatas">
                            </div>
                        </div>

                        <div class="toggle-group">
                            <label class="toggle-item">
                                <div>
                                    <div class="toggle-label">Gratis</div>
                                    <div class="toggle-desc">Peserta tidak perlu membayar</div>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" name="is_free" value="1" {{ old('is_free', $event->is_free ?? false) ? 'checked' : '' }}>
                                    <span class="switch-track"></span>
                                </label>
                            </label>
                            <label class="toggle-item">
                                <div>
                                    <div class="toggle-label">Khusus Anggota</div>
                                    <div class="toggle-desc">Hanya member yang bisa daftar</div>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" name="is_member_only" value="1" {{ old('is_member_only', $event->is_member_only ?? false) ? 'checked' : '' }}>
                                    <span class="switch-track"></span>
                                </label>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="form-card">
                    <div class="form-card-body">
                        <button type="submit" class="btn-primary" id="submitBtn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            {{ isset($event) ? 'Simpan Perubahan' : 'Buat Kegiatan' }}
                        </button>
                        <a href="{{ route('admin.events.index') }}" class="btn-secondary">Batal</a>

                        @if(isset($event))
                        <div style="padding-top:4px;border-top:1.5px solid #f1f5f9;margin-top:4px" class="dark:border-gray-700">
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Yakin hapus kegiatan ini? Tindakan ini tidak bisa dibatalkan.')">
                                @csrf @method('DELETE')
                                <button type="submit" style="width:100%;height:40px;border-radius:12px;font-size:13px;font-weight:700;background:transparent;border:1.5px solid #fecdd3;color:#e11d48;cursor:pointer;font-family:inherit;transition:all .15s"
                                        onmouseover="this.style.background='#fff1f2'" onmouseout="this.style.background='transparent'">
                                    Hapus Kegiatan
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Meta info (edit only) --}}
                @if(isset($event))
                <div class="form-card">
                    <div class="form-card-body" style="gap:8px">
                        <p style="font-size:11px;font-weight:700;color:#94a3b8;letter-spacing:.06em;text-transform:uppercase">Info</p>
                        <div style="font-size:12px;color:#64748b;display:flex;flex-direction:column;gap:6px">
                            <div>Dibuat: <strong style="color:#374151">{{ $event->created_at->format('d M Y, H:i') }}</strong></div>
                            <div>Diupdate: <strong style="color:#374151">{{ $event->updated_at->format('d M Y, H:i') }}</strong></div>
                            <div>Slug: <code style="background:#f1f5f9;padding:2px 6px;border-radius:6px;font-size:11px">{{ $event->slug }}</code></div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </form>
</div>

<script>
// Tab switching
function switchThumbTab(tab) {
    document.querySelectorAll('#thumbTabSwitch .tab-btn').forEach((b,i) => {
        b.classList.toggle('active', (tab==='upload'&&i===0)||(tab==='url'&&i===1));
    });
    document.getElementById('tabUpload').style.display = tab==='upload' ? '' : 'none';
    document.getElementById('tabUrl').style.display    = tab==='url'    ? '' : 'none';
}

// File select handler
function handleFileSelect(input) {
    const file = input.files[0];
    if (!file) return;

    // Validate size (5MB)
    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran file maksimal 5MB. File yang dipilih: ' + (file.size/1024/1024).toFixed(1) + 'MB');
        input.value = '';
        return;
    }

    // Show preview
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('thumbPreviewImg').src = e.target.result;
        document.getElementById('thumbPreview').style.display = '';
        document.getElementById('uploadZone').style.display = 'none';
    };
    reader.readAsDataURL(file);

    // Simulate progress (replace with real AJAX if needed)
    simulateProgress();
}

function simulateProgress() {
    const prog = document.getElementById('uploadProgress');
    const fill = document.getElementById('progressFill');
    const lbl  = document.getElementById('progressLabel');
    prog.style.display = '';
    let w = 0;
    const iv = setInterval(() => {
        w = Math.min(w + Math.random()*15, 95);
        fill.style.width = w + '%';
        lbl.textContent = 'Memproses... ' + Math.floor(w) + '%';
        if (w >= 95) {
            clearInterval(iv);
            fill.style.width = '100%';
            lbl.textContent = '✓ File siap diupload';
        }
    }, 80);
}

function removeThumbnail() {
    document.getElementById('thumbnailFile').value = '';
    document.getElementById('thumbPreview').style.display = 'none';
    document.getElementById('uploadZone').style.display = '';
    document.getElementById('uploadProgress').style.display = 'none';
}

// URL Preview
function previewUrl(url) {
    const prev = document.getElementById('urlPreview');
    const img  = document.getElementById('urlPreviewImg');
    if (!url) { prev.style.display='none'; return; }
    img.src = url;
    img.onload = () => prev.style.display='';
    img.onerror = () => prev.style.display='none';
}

// Check existing URL to show URL tab
@if(isset($event) && $event->thumbnail)
    @php $thumb = $event->thumbnail; @endphp
    const existingThumb = @json($thumb);
    if (existingThumb && existingThumb.startsWith('http')) {
        switchThumbTab('url');
        previewUrl(existingThumb);
    }
@endif

// Drag & Drop
const zone = document.getElementById('uploadZone');
if (zone) {
    zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
    zone.addEventListener('drop', e => {
        e.preventDefault(); zone.classList.remove('drag-over');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const input = document.getElementById('thumbnailFile');
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            handleFileSelect(input);
        }
    });
}

// Submit loading state
document.getElementById('eventForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Menyimpan...';
});
</script>
@endsection