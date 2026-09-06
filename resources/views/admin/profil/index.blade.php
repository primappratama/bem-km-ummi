@extends('layouts.admin')
@section('title', 'Profil Publik')
@section('page-title', 'Profil Publik')

@section('content')

<div class="max-w-2xl">

    <p class="text-sm text-slate-400 mb-6">
        Konten di bawah ini ditampilkan pada halaman utama
        <a href="{{ url('/') }}" target="_blank" class="text-navy underline">beranda publik</a>.
    </p>

    <form method="POST" action="{{ route('admin.profil.update') }}" class="space-y-6">
        @csrf @method('PUT')

        {{-- Visi --}}
        <div class="glass-card p-6 space-y-4">
            <h3 class="text-sm font-bold text-navy">Visi Organisasi</h3>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Visi <span class="text-red">*</span>
                </label>
                <textarea name="visi" rows="3" required
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm resize-none
                                 focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                                 @error('visi') border-red @enderror">{{ old('visi', $visi) }}</textarea>
                @error('visi') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Deskripsi Singkat (tagline hero)
                </label>
                <textarea name="deskripsi" rows="2"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm resize-none
                                 focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">{{ old('deskripsi', $deskripsi) }}</textarea>
            </div>
        </div>

        {{-- Misi --}}
        <div class="glass-card p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-bold text-navy">Misi Organisasi</h3>
                <button type="button" id="add-misi"
                        class="text-xs font-semibold text-navy hover:text-navy/70 transition-colors">
                    + Tambah poin
                </button>
            </div>

            <div id="misi-list" class="space-y-2.5">
                @forelse ($misi as $i => $m)
                <div class="flex items-start gap-2 misi-row">
                    <span class="text-xs font-mono-data text-slate-300 mt-3 w-5 shrink-0">{{ $i + 1 }}</span>
                    <input type="text" name="misi[]" value="{{ $m }}"
                           placeholder="Poin misi..."
                           class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                                  focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
                    <button type="button" onclick="removeMisi(this)"
                            class="mt-2 p-1.5 rounded-lg text-slate-300 hover:text-red hover:bg-red/8 transition-colors shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                @empty
                <p class="text-xs text-slate-400">Belum ada poin misi. Klik "+ Tambah poin".</p>
                @endforelse
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ url('/') }}" target="_blank"
               class="px-5 py-2.5 rounded-full text-sm font-semibold text-slate-500
                      border border-slate-200 hover:bg-slate-50 transition-colors">
                Lihat Halaman Publik ↗
            </a>
        </div>
    </form>
</div>

<script>
let misiCount = {{ count($misi) }};

document.getElementById('add-misi').addEventListener('click', function () {
    misiCount++;
    const row = document.createElement('div');
    row.className = 'flex items-start gap-2 misi-row';
    row.innerHTML = `
        <span class="text-xs font-mono-data text-slate-300 mt-3 w-5 shrink-0">${misiCount}</span>
        <input type="text" name="misi[]" placeholder="Poin misi..."
               class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                      focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all" autofocus>
        <button type="button" onclick="removeMisi(this)"
                class="mt-2 p-1.5 rounded-lg text-slate-300 hover:text-red hover:bg-red/8 transition-colors shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>`;
    document.getElementById('misi-list').appendChild(row);
    row.querySelector('input').focus();
    updateNumbers();
});

function removeMisi(btn) {
    btn.closest('.misi-row').remove();
    updateNumbers();
}

function updateNumbers() {
    document.querySelectorAll('#misi-list .misi-row').forEach((row, i) => {
        row.querySelector('span').textContent = i + 1;
    });
    misiCount = document.querySelectorAll('#misi-list .misi-row').length;
}
</script>

@endsection
