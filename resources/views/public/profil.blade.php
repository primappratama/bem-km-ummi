@extends('layouts.public')
@section('title', 'Profil BEM KM UMMI')

@section('content')

@php
    $kementerianList = \App\Models\Kementerian::with([
        'pengurus' => fn($q) => $q->orderBy('jabatan'),
        'programKerja' => fn($q) => $q->orderBy('tanggal_pelaksanaan', 'desc')
    ])->withCount(['pengurus','programKerja'])->orderBy('kode')->get();

    $kemData = $kementerianList->map(fn($k) => [
        'id'           => $k->id,
        'kode'         => $k->kode,
        'nama'         => $k->nama_kementerian,
        'deskripsi'    => $k->deskripsi,
        'pengurus'     => $k->pengurus->map(fn($p) => [
            'nama'    => $p->nama,
            'jabatan' => $p->jabatan,
            'inisial' => strtoupper(substr($p->nama, 0, 1)),
        ]),
        'programKerja' => $k->programKerja->map(fn($pk) => [
            'nama'    => $pk->nama_kegiatan,
            'tanggal' => $pk->tanggal_pelaksanaan
                         ? \Carbon\Carbon::parse($pk->tanggal_pelaksanaan)->translatedFormat('d M Y')
                         : '—',
            'status'  => $pk->status,
            'anggaran'=> $pk->anggaran ? 'Rp '.number_format($pk->anggaran, 0, ',', '.') : null,
        ]),
    ]);
@endphp

{{-- ═══ MODAL ═══ --}}
<div id="kem-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     role="dialog" aria-modal="true">

    {{-- Backdrop --}}
    <div id="kem-backdrop"
         class="absolute inset-0 bg-navy/40"
         onclick="closeModal()"></div>

    {{-- Card --}}
    <div id="kem-card"
         class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh]
                flex flex-col overflow-hidden z-10
                translate-y-6 opacity-0 transition-all duration-250 ease-out">

        {{-- Header --}}
        <div class="bg-navy text-white px-6 py-5 flex items-start justify-between gap-4 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                    <span class="text-sm font-black text-white" id="m-kode"></span>
                </div>
                <div>
                    <p class="text-blue-300 text-xs mb-0.5">Kementerian</p>
                    <h2 class="font-bold text-lg leading-snug" id="m-nama"></h2>
                </div>
            </div>
            <button onclick="closeModal()"
                    class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/25 flex items-center justify-center
                           transition-colors shrink-0 mt-0.5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Scrollable body --}}
        <div class="overflow-y-auto flex-1 px-6 py-5 space-y-6">

            <p id="m-deskripsi" class="text-sm text-slate-500 leading-relaxed hidden"></p>

            {{-- Pengurus --}}
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Pengurus</h3>
                <div id="m-pengurus" class="grid grid-cols-2 sm:grid-cols-3 gap-2.5"></div>
                <p id="m-pengurus-empty" class="text-xs text-slate-400 hidden">Belum ada data pengurus.</p>
            </div>

            {{-- Program Kerja --}}
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Program Kerja</h3>
                <div id="m-proker" class="space-y-2"></div>
                <p id="m-proker-empty" class="text-xs text-slate-400 hidden">Belum ada program kerja.</p>
            </div>
        </div>
    </div>
</div>

{{-- ═══ PAGE CONTENT (akan di-blur saat modal terbuka) ═══ --}}
<div id="page-content" class="min-h-screen bg-gradient-to-br from-slate-50 to-navy/5
                               transition-all duration-250">

    {{-- Hero --}}
    <div class="bg-navy text-white py-16 px-4 text-center">
        <div class="max-w-3xl mx-auto">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold mb-3">Badan Eksekutif Mahasiswa</h1>
            <p class="text-xl text-blue-200 mb-2">Keluarga Mahasiswa</p>
            <p class="text-blue-300">Universitas Muhammadiyah Sukabumi</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-12 space-y-10">

        {{-- Visi Misi --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-navy mb-3">Visi</h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Mewujudkan BEM KM UMMI sebagai organisasi kemahasiswaan yang profesional, inovatif, dan berdampak nyata bagi mahasiswa Universitas Muhammadiyah Sukabumi.
                </p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-navy mb-3">Misi</h2>
                <ul class="text-slate-600 text-sm leading-relaxed space-y-1.5">
                    <li class="flex gap-2"><span class="text-navy font-bold shrink-0">1.</span>Mewadahi aspirasi dan pengembangan potensi mahasiswa</li>
                    <li class="flex gap-2"><span class="text-navy font-bold shrink-0">2.</span>Menyelenggarakan kegiatan yang bermanfaat bagi mahasiswa</li>
                    <li class="flex gap-2"><span class="text-navy font-bold shrink-0">3.</span>Membangun sinergi antara mahasiswa dan civitas akademika</li>
                    <li class="flex gap-2"><span class="text-navy font-bold shrink-0">4.</span>Meningkatkan kualitas organisasi yang transparan dan akuntabel</li>
                </ul>
            </div>
        </div>

        {{-- Kementerian cards --}}
        <div>
            <h2 class="text-xl font-bold text-navy mb-2">Kementerian</h2>
            <p class="text-sm text-slate-400 mb-5">Klik kartu untuk melihat pengurus dan program kerja.</p>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($kementerianList as $k)
                <button onclick="openModal({{ $k->id }})"
                        class="bg-white rounded-2xl border border-slate-200 p-5 text-left w-full
                               hover:border-navy/40 hover:shadow-lg active:scale-[.97]
                               transition-all duration-200 group cursor-pointer">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-navy/10 group-hover:bg-navy group-hover:text-white
                                    flex items-center justify-center shrink-0 transition-colors duration-200">
                            <span class="text-xs font-black text-navy group-hover:text-white transition-colors">{{ $k->kode }}</span>
                        </div>
                        <p class="font-semibold text-navy text-sm leading-snug">
                            {{ $k->nama_kementerian }}
                        </p>
                    </div>
                    @if ($k->deskripsi)
                    <p class="text-xs text-slate-400 mb-3 line-clamp-2">{{ $k->deskripsi }}</p>
                    @endif
                    <div class="flex items-center justify-between">
                        <div class="flex gap-3 text-xs text-slate-400">
                            <span>{{ $k->pengurus_count }} pengurus</span>
                            <span>·</span>
                            <span>{{ $k->program_kerja_count }} proker</span>
                        </div>
                        <span class="text-xs text-navy font-semibold flex items-center gap-1
                                     group-hover:gap-2 transition-all">
                            Detail
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </button>
                @empty
                <p class="text-slate-400 text-sm col-span-3">Belum ada data kementerian.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- ═══ JS ═══ --}}
<script>
const KEM_DATA = @json($kemData);
const statusLabel = { rencana:'Rencana', berjalan:'Berjalan', selesai:'Selesai' };
const statusClass  = {
    rencana: 'bg-slate-100 text-slate-500',
    berjalan:'bg-blue-50 text-blue-700 border border-blue-200',
    selesai: 'bg-green-50 text-green-700 border border-green-200',
};

function openModal(id) {
    const k = KEM_DATA.find(x => x.id === id);
    if (!k) return;

    document.getElementById('m-kode').textContent = k.kode;
    document.getElementById('m-nama').textContent = k.nama;

    const desc = document.getElementById('m-deskripsi');
    if (k.deskripsi) { desc.textContent = k.deskripsi; desc.classList.remove('hidden'); }
    else desc.classList.add('hidden');

    // Pengurus
    const pg = document.getElementById('m-pengurus');
    const pgE = document.getElementById('m-pengurus-empty');
    pg.innerHTML = '';
    if (!k.pengurus.length) {
        pg.classList.add('hidden'); pgE.classList.remove('hidden');
    } else {
        pg.classList.remove('hidden'); pgE.classList.add('hidden');
        k.pengurus.forEach(p => pg.insertAdjacentHTML('beforeend', `
            <div class="flex items-center gap-2.5 bg-slate-50 rounded-xl px-3 py-2.5 border border-slate-100">
                <div class="w-8 h-8 rounded-full bg-navy/10 flex items-center justify-center shrink-0">
                    <span class="text-xs font-bold text-navy">${p.inisial}</span>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-navy truncate">${p.nama}</p>
                    <p class="text-[10px] text-slate-400 truncate">${p.jabatan}</p>
                </div>
            </div>`));
    }

    // Program Kerja
    const pk = document.getElementById('m-proker');
    const pkE = document.getElementById('m-proker-empty');
    pk.innerHTML = '';
    if (!k.programKerja.length) {
        pk.classList.add('hidden'); pkE.classList.remove('hidden');
    } else {
        pk.classList.remove('hidden'); pkE.classList.add('hidden');
        k.programKerja.forEach(p => {
            const cls = statusClass[p.status] || 'bg-slate-100 text-slate-500';
            const lbl = statusLabel[p.status] || p.status;
            pk.insertAdjacentHTML('beforeend', `
                <div class="flex items-center justify-between gap-3 bg-slate-50 rounded-xl px-4 py-3 border border-slate-100">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-navy truncate">${p.nama}</p>
                        <p class="text-xs text-slate-400 mt-0.5">${p.tanggal}${p.anggaran ? ' · ' + p.anggaran : ''}</p>
                    </div>
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold shrink-0 ${cls}">${lbl}</span>
                </div>`);
        });
    }

    // Show modal + blur page
    const modal   = document.getElementById('kem-modal');
    const card    = document.getElementById('kem-card');
    const content = document.getElementById('page-content');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';

    requestAnimationFrame(() => {
        content.style.filter = 'blur(6px)';
        content.style.transform = 'scale(0.98)';
        card.classList.remove('translate-y-6', 'opacity-0');
        card.classList.add('translate-y-0', 'opacity-100');
    });
}

function closeModal() {
    const modal   = document.getElementById('kem-modal');
    const card    = document.getElementById('kem-card');
    const content = document.getElementById('page-content');

    card.classList.add('translate-y-6', 'opacity-0');
    card.classList.remove('translate-y-0', 'opacity-100');
    content.style.filter = '';
    content.style.transform = '';

    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }, 250);
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
</script>

@endsection
