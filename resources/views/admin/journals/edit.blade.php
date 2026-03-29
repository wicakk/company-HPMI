@extends('layouts.admin')
@section('title', 'Edit Jurnal')
@section('content')

<div class="space-y-6" x-data="{
  newFile: null, newFileName: '', newFileSize: '', newFileType: '', dragging: false,
  handleFile(f) {
    if (!f) return;
    const allowed = ['application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    if (!allowed.includes(f.type)) { alert('Format file tidak didukung. Gunakan PDF, DOC, atau DOCX.'); return; }
    if (f.size > 20 * 1024 * 1024) { alert('Ukuran file terlalu besar. Maksimal 20 MB.'); return; }
    this.newFile = f;
    this.newFileName = f.name;
    this.newFileSize = f.size >= 1048576 ? (f.size/1048576).toFixed(1)+' MB' : (f.size/1024).toFixed(1)+' KB';
    this.newFileType = f.name.split('.').pop().toUpperCase();
  }
}">

  {{-- Header --}}
  <div class="flex items-center gap-3">
    <a href="{{ route('admin.journals.show', $journal) }}"
       class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
    </a>
    <div>
      <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Edit Jurnal</h2>
      <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5 truncate max-w-md">{{ $journal->title }}</p>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.journals.update', $journal) }}" enctype="multipart/form-data" class="space-y-5">
    @csrf @method('PUT')

    @if($errors->any())
    <div class="px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/50 text-red-600 dark:text-red-400 rounded-xl text-sm">
      <p class="font-semibold mb-1">Ada kesalahan:</p>
      <ul class="ml-4 list-disc space-y-0.5 text-xs">
        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
      </ul>
    </div>
    @endif

    {{--
      FIX ROOT CAUSE:
      Kode lama: old('access', $journal->access ?? 'free') === 'premium'
      - Jika tidak ada old input → pakai $journal->access (misal 'premium') → benar
      - Tapi fallback '?? free' tidak masalah karena $journal->access sudah ada

      Masalah SEBENARNYA ada di JS toggleAccessJournal lama:
      - Fungsi itu hanya mengubah CSS, tidak mengubah checked state radio button
      - Radio button pakai class sr-only (hidden dari DOM tapi tetap submit)
      - TAPI karena sr-only bukan display:none, seharusnya tetap submit

      Setelah ditelusuri: masalah utama adalah radio button duplicate ID di create vs edit
      (kedua halaman pakai id="access-radio-free" dan "access-dot-free" yang sama)
      dan fungsi JS gagal karena querySelector tidak menemukan elemen yang benar.

      FIX: Gunakan pendekatan yang lebih sederhana dan reliable:
      - Hilangkan sr-only, ganti dengan opacity-0 absolute (tetap di DOM, tetap submit)
      - Pindahkan styling ke Blade (server-side) berdasarkan nilai DB
      - JS hanya update tampilan, checked state dihandle browser native
    --}}
    @php $selectedAccess = old('access', $journal->access ?? 'free'); @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- ── LEFT ── --}}
      <div class="lg:col-span-2 space-y-5">

        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-rose-500"></div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Jurnal</h3>
          </div>
          <div class="p-6 space-y-5">

            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Judul Jurnal <span class="text-red-400">*</span></label>
              <input type="text" name="title" value="{{ old('title', $journal->title) }}" required
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 transition">
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Author / Penulis <span class="text-red-400">*</span></label>
              <div class="relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <input type="text" name="author" value="{{ old('author', $journal->author) }}" required
                  class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 transition">
              </div>
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Abstrak</label>
              <textarea name="abstract" rows="4"
                class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 transition resize-none">{{ old('abstract', $journal->abstract) }}</textarea>
            </div>

          </div>
        </div>

        {{-- File section --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-sky-500"></div>
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">File Jurnal</h3>
          </div>
          <div class="p-6 space-y-4">

            {{-- File saat ini --}}
            <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-700/40 rounded-xl border border-slate-200 dark:border-slate-600">
              @php $ext = strtolower($journal->file_type ?? 'pdf'); @endphp
              <div class="w-11 h-11 rounded-xl {{ $ext === 'pdf' ? 'bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400' : 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400' }} flex items-center justify-center font-bold text-[11px] uppercase flex-shrink-0">
                {{ $ext }}
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-800 dark:text-white truncate">{{ $journal->file_name }}</p>
                <p class="text-xs text-slate-400 mt-0.5">File saat ini{{ $journal->file_size ? ' · '.$journal->file_size : '' }}</p>
              </div>
              <span class="inline-flex items-center gap-1 text-xs text-slate-400 flex-shrink-0">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Tersimpan
              </span>
            </div>

            {{-- Ganti file (opsional) --}}
            <div>
              <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-2">Ganti File (Opsional)</p>
              <label class="block cursor-pointer"
                @dragover.prevent="dragging = true"
                @dragleave.prevent="dragging = false"
                @drop.prevent="dragging = false; handleFile($event.dataTransfer.files[0]); $refs.fi.files = $event.dataTransfer.files">

                <template x-if="newFile">
                  <div class="border-2 border-emerald-300 dark:border-emerald-700 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 p-4">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-xs flex-shrink-0"
                           :class="newFileType === 'PDF' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600'"
                           x-text="newFileType"></div>
                      <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 dark:text-white truncate" x-text="newFileName"></p>
                        <p class="text-xs text-slate-400 mt-0.5" x-text="newFileSize"></p>
                      </div>
                      <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">✓ Siap ganti</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-2.5 text-center">Klik untuk pilih file lain</p>
                  </div>
                </template>

                <template x-if="!newFile">
                  <div class="border-2 border-dashed rounded-xl py-7 px-5 text-center transition-all"
                       :class="dragging ? 'border-rose-400 bg-rose-50 dark:bg-rose-900/10' : 'border-slate-200 dark:border-slate-600 hover:border-rose-400 hover:bg-rose-50/30'">
                    <svg class="w-8 h-8 text-slate-300 dark:text-slate-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                      Drag & drop atau <span class="text-rose-600 dark:text-rose-400">pilih file baru</span>
                    </p>
                    <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX — Maks 20 MB</p>
                  </div>
                </template>

                <input type="file" name="file" accept=".pdf,.doc,.docx" x-ref="fi" class="sr-only"
                       @change="handleFile($event.target.files[0])">
              </label>
            </div>

          </div>
        </div>

      </div>

      {{-- ── RIGHT ── --}}
      <div class="space-y-5">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden sticky top-5">
          <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-2 h-2 rounded-full bg-violet-500"></div>
            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Metadata Jurnal</h4>
          </div>
          <div class="p-5 space-y-4">

            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Kategori</label>
              <input type="text" name="category" value="{{ old('category', $journal->category) }}"
                     list="categoryList" placeholder="Cth: Keperawatan, Manajerial..."
                     class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-500 transition">
              @if($categories->count())
              <datalist id="categoryList">
                @foreach($categories as $cat)<option value="{{ $cat }}">@endforeach
              </datalist>
              @endif
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Volume</label>
                <input type="text" name="volume" value="{{ old('volume', $journal->volume) }}" placeholder="cth: 12"
                  class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 transition">
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tahun</label>
                <input type="number" name="year" value="{{ old('year', $journal->year) }}"
                       min="1900" max="{{ date('Y') + 1 }}"
                       class="w-full px-4 py-2.5 text-sm border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-violet-500 transition">
              </div>
            </div>

            {{-- ══ TIPE AKSES — FIXED ══ --}}
            <div>
              <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide mb-2">
                Tipe Akses <span class="text-red-400">*</span>
              </label>
              <div class="space-y-2" id="accessGroup">

                @foreach([
                  ['free',    '✅ Gratis',  'Semua member bisa download', 'emerald'],
                  ['premium', '⭐ Premium', 'Hanya member premium',       'amber'],
                ] as [$val, $label, $desc, $color])
                <label class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all access-option
                               {{ $selectedAccess === $val
                                  ? ($val === 'free' ? 'border-emerald-400 bg-emerald-50 dark:bg-emerald-900/20' : 'border-amber-400 bg-amber-50 dark:bg-amber-900/20')
                                  : 'border-slate-200 dark:border-slate-600 hover:border-slate-300' }}"
                       data-value="{{ $val }}" data-color="{{ $color }}">
                  <input type="radio" name="access" value="{{ $val }}"
                         {{ $selectedAccess === $val ? 'checked' : '' }}
                         class="absolute opacity-0 w-0 h-0"
                         onchange="highlightAccess('{{ $val }}')">
                  <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all
                               {{ $selectedAccess === $val
                                  ? ($val === 'free' ? 'border-emerald-500 bg-emerald-500' : 'border-amber-500 bg-amber-500')
                                  : 'border-slate-300 dark:border-slate-500' }}"
                       id="dot-{{ $val }}">
                    <div class="w-2 h-2 rounded-full bg-white {{ $selectedAccess !== $val ? 'hidden' : '' }}"
                         id="inner-{{ $val }}"></div>
                  </div>
                  <div class="flex-1">
                    <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $label }}</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500">{{ $desc }}</p>
                  </div>
                </label>
                @endforeach

              </div>
            </div>

            {{-- Status Publish --}}
            <div class="pt-1">
              <div class="flex items-center justify-between py-3 border-b border-slate-50 dark:border-slate-700/50">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Status Publish</span>
                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                  <input type="hidden" name="is_published" value="0">
                  <input type="checkbox" name="is_published" value="1"
                         {{ old('is_published', $journal->is_published) ? 'checked' : '' }}
                         class="sr-only peer">
                  <div class="w-10 h-[22px] bg-slate-200 dark:bg-slate-600 peer-checked:bg-rose-500 rounded-full transition-colors"></div>
                  <div class="absolute left-0.5 top-0.5 w-[18px] h-[18px] bg-white rounded-full shadow-sm transition-transform peer-checked:translate-x-[18px]"></div>
                </label>
              </div>
            </div>

          </div>

          <div class="px-5 pb-5 flex gap-3">
            <button type="submit"
              class="flex-1 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl transition shadow-sm active:scale-95">
              Simpan Perubahan
            </button>
            <a href="{{ route('admin.journals.show', $journal) }}"
              class="flex-1 py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl transition text-center">
              Batal
            </a>
          </div>
        </div>
      </div>

    </div>
  </form>
</div>

@push('scripts')
<script>
const colorMap = {
  free:    { border: 'border-emerald-400', bg: ['bg-emerald-50', 'dark:bg-emerald-900/20'], dot: ['border-emerald-500', 'bg-emerald-500'] },
  premium: { border: 'border-amber-400',   bg: ['bg-amber-50',   'dark:bg-amber-900/20'],   dot: ['border-amber-500',   'bg-amber-500']   },
};

function highlightAccess(selected) {
  document.querySelectorAll('.access-option').forEach(label => {
    const val   = label.dataset.value;
    const c     = colorMap[val];
    const dot   = document.getElementById('dot-' + val);
    const inner = document.getElementById('inner-' + val);
    const input = label.querySelector('input[type=radio]');

    if (val === selected) {
      label.classList.remove('border-slate-200', 'dark:border-slate-600', 'hover:border-slate-300');
      label.classList.add(c.border, ...c.bg);
      dot.classList.remove('border-slate-300', 'dark:border-slate-500');
      dot.classList.add(...c.dot);
      inner.classList.remove('hidden');
      input.checked = true;
    } else {
      label.classList.remove(colorMap[val].border, ...colorMap[val].bg);
      label.classList.add('border-slate-200', 'dark:border-slate-600', 'hover:border-slate-300');
      dot.classList.remove(...colorMap[val].dot);
      dot.classList.add('border-slate-300', 'dark:border-slate-500');
      inner.classList.add('hidden');
    }
  });
}
</script>
@endpush
@endsection
