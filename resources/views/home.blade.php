@extends('layouts.public')
@section('title', 'Beranda')
@section('content')

@php
    $dots = ['bg-red', 'bg-orange', 'bg-navy'];
    $kementerianList = \App\Models\Kementerian::with([
        'pengurus'     => fn($q) => $q->orderBy('jabatan'),
        'programKerja' => fn($q) => $q->orderBy('tanggal_pelaksanaan', 'desc'),
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
    <div id="kem-backdrop"
         class="absolute inset-0 bg-navy/40"
         onclick="closeModal()"></div>

    <div id="kem-card"
         class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh]
                flex flex-col overflow-hidden z-10
                translate-y-6 opacity-0 transition-all duration-250 ease-out">

        <div class="bg-navy text-white px-6 py-5 flex items-start justify-between gap-4 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                    <span class="text-xs font-black text-white" id="m-kode"></span>
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

        <div class="overflow-y-auto flex-1 px-6 py-5 space-y-6">
            <p id="m-deskripsi" class="text-sm text-slate-500 leading-relaxed hidden"></p>

            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Pengurus</h3>
                <div id="m-pengurus" class="grid grid-cols-2 sm:grid-cols-3 gap-2.5"></div>
                <p id="m-pengurus-empty" class="text-xs text-slate-400 hidden">Belum ada data pengurus.</p>
            </div>

            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Program Kerja</h3>
                <div id="m-proker" class="space-y-2"></div>
                <p id="m-proker-empty" class="text-xs text-slate-400 hidden">Belum ada program kerja.</p>
            </div>
        </div>
    </div>
</div>

{{-- ═══ PAGE CONTENT (diblur saat modal terbuka) ═══ --}}
<div id="page-content" class="transition-all duration-250">

{{-- HERO --}}
<section class="relative overflow-hidden min-h-[92vh] flex items-center"
         style="background: linear-gradient(135deg, #06101E 0%, #102A52 55%, #0D1433 100%);">
    <div class="js-orb-1 pointer-events-none absolute -top-20 -left-32 w-[520px] h-[520px] rounded-full animate-float-a"
         style="background: radial-gradient(circle, rgba(227,30,48,0.22) 0%, transparent 70%); filter: blur(60px);"></div>
    <div class="js-orb-2 pointer-events-none absolute bottom-0 right-0 w-[420px] h-[420px] rounded-full animate-float-b"
         style="background: radial-gradient(circle, rgba(80,110,200,0.18) 0%, transparent 70%); filter: blur(70px);"></div>
    <div class="js-orb-3 pointer-events-none absolute top-2/3 left-1/3 w-[260px] h-[260px] rounded-full animate-float-c"
         style="background: radial-gradient(circle, rgba(240,135,30,0.14) 0%, transparent 70%); filter: blur(50px);"></div>
    <div class="dot-grid js-hero-dots pointer-events-none absolute top-16 right-10 opacity-60 hidden sm:grid">
        <span></span><span></span><span></span>
        <span></span><span></span><span></span>
        <span></span><span></span><span></span>
    </div>

    <div class="relative max-w-6xl mx-auto px-6 pt-12 pb-36 sm:pb-48">
        <div class="max-w-2xl">
            <div class="js-hero-eyebrow inline-flex items-center gap-2.5 mb-7 glass-dark rounded-full px-4 py-2">
                <span class="w-1.5 h-1.5 rounded-full bg-red"></span>
                <span class="text-[10px] font-mono-data uppercase tracking-[0.14em] text-white/65">Periode 2025&ndash;2026</span>
            </div>
            <h1 class="js-hero-title font-extrabold text-white leading-[1.04] text-5xl sm:text-6xl lg:text-7xl mb-6">
                BEM KM<br>
                <span class="js-gradient-text"
                      style="background: linear-gradient(90deg, #E31E30 0%, #F0871E 100%);
                             -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">UMMI</span>
            </h1>
            <p class="js-hero-desc text-white/55 text-base sm:text-lg leading-relaxed max-w-lg mb-10">
                Menghidupkan tradisi intelektual, advokasi, dan gerakan mahasiswa yang kritis,
                kolaboratif, dan progresif di Universitas Muhammadiyah Sukabumi.
            </p>
            <div class="flex flex-wrap gap-3 js-hero-cta">
                <a href="{{ url('/program-kerja') }}" class="btn-primary">Lihat Program Kerja</a>
                <a href="{{ url('/aspirasi') }}"      class="btn-ghost-dark">Sampaikan Aspirasi</a>
            </div>
        </div>

        <div class="js-hero-stats hidden md:flex absolute bottom-20 right-6 gap-3">
            @php $stats = [
                    ['value' => \App\Models\Kementerian::count(), 'label' => 'Kementerian'],
                    ['value' => \App\Models\Pengurus::count(), 'label' => 'Pengurus Aktif'],
                    ['value' => \App\Models\Aspirasi::count(), 'label' => 'Aspirasi'],
                ]; @endphp
            @foreach($stats as $s)
            <div class="glass-dark rounded-2xl px-5 py-4 text-center min-w-[80px]">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $s['value'] }}</p>
                <p class="text-[10px] font-mono-data text-white/50 mt-1 uppercase tracking-wider">{{ $s['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0 pointer-events-none" style="line-height:0;">
        <svg viewBox="0 0 1440 90" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full" style="display:block;">
            <path d="M0 45 C360 90 720 0 1080 50 C1260 75 1380 30 1440 45 L1440 90 L0 90 Z" fill="#F5F7FF"/>
        </svg>
    </div>
</section>

{{-- VISI MISI --}}
<section class="bg-white">
    <div class="max-w-6xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-12 items-start">
        <div class="js-reveal">
            <p class="eyebrow mb-3">Visi</p>
            <blockquote class="text-xl sm:text-2xl font-bold text-navy leading-snug text-balance">
                &ldquo;{{ \App\Models\Profil::get('visi',
                    'Mewujudkan BEM KM UMMI sebagai garda gerakan mahasiswa yang kritis, progresif, dan kolaboratif.') }}&rdquo;
            </blockquote>
        </div>
        <div class="js-reveal">
            <p class="eyebrow mb-3">Misi</p>
            <ul class="space-y-3">
                @php $misiList = \App\Models\Profil::getMisi(); if (empty($misiList)) $misiList = [
                    'Mengadvokasi dan memperjuangkan hak serta kesejahteraan mahasiswa.',
                    'Membangun sistem komunikasi dan informasi yang transparan dan akuntabel.',
                    'Mengembangkan kapasitas mahasiswa melalui program pemberdayaan SDM.',
                    'Memperkuat diplomasi internal dan eksternal kampus.',
                    'Menciptakan ruang akademik yang kritis dan produktif.',
                    'Mengelola keuangan organisasi secara transparan dan bertanggung jawab.',
                    'Membangun sistem tata kelola organisasi yang adaptif dan berkelanjutan.',
                ]; @endphp
                @foreach($misiList as $idx => $item)
                <li class="flex items-start gap-3 text-sm text-ink/70 leading-relaxed">
                    <span class="font-mono-data text-red/70 mt-0.5 shrink-0 text-xs">0{{ $idx+1 }}</span>
                    {{ $item }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

{{-- KEMENTERIAN — dynamic DB, clickable modal --}}
<section class="bg-mist py-20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="js-reveal flex items-end justify-between mb-10">
            <div>
                <p class="eyebrow mb-2">Struktur Kabinet</p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-navy">Kementerian</h2>
            </div>
            <p class="text-sm text-ink/40 hidden sm:inline">Klik kartu untuk detail</p>
        </div>

        <div class="js-reveal-group grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($kementerianList as $idx => $k)
            <button onclick="openModal({{ $k->id }})"
                    class="js-reveal glass-card p-6 text-left w-full group cursor-pointer
                           hover:shadow-lg hover:-translate-y-1 active:scale-[.97]
                           transition-all duration-200">
                <div class="flex items-center gap-2.5 mb-4">
                    <span class="w-2 h-2 rounded-full {{ $dots[$idx % 3] }} shrink-0
                                 group-hover:scale-125 transition-transform duration-300"></span>
                    <p class="font-extrabold text-navy text-sm tracking-tight">{{ $k->kode }}</p>
                </div>
                <p class="text-xs text-ink/40 font-medium mb-2 font-mono-data uppercase tracking-wide">
                    {{ $k->nama_kementerian }}
                </p>
                @if($k->deskripsi)
                <p class="text-sm text-ink/65 leading-relaxed line-clamp-2">{{ $k->deskripsi }}</p>
                @endif
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-xs text-ink/30">
                        {{ $k->pengurus_count }} pengurus · {{ $k->program_kerja_count }} proker
                    </span>
                    <span class="text-xs font-bold text-red flex items-center gap-1
                                 group-hover:gap-2 transition-all">
                        Detail
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>
            </button>
            @empty
            <p class="text-sm text-ink/40 col-span-3">Belum ada data kementerian.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- PROGRAM UNGGULAN --}}
<section class="bg-white py-20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="js-reveal mb-10">
            <p class="eyebrow mb-2">Program Unggulan</p>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-navy">Yang Sedang Kami Jalankan</h2>
        </div>
        <div class="js-reveal-group grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $prokerDB = \App\Models\ProgramKerja::with('kementerian')
                    ->whereIn('status', ['berjalan', 'rencana'])
                    ->orderByRaw("FIELD(status, 'berjalan', 'rencana')")
                    ->orderBy('tanggal_pelaksanaan')
                    ->limit(6)
                    ->get();
            @endphp
            @forelse($prokerDB as $p)
            <div class="js-reveal group rounded-xl border border-slate-100 bg-white p-6
                        hover:border-red/20 hover:shadow-md hover:shadow-red/5 hover:-translate-y-1
                        transition-all duration-300 relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-0.5 bg-gradient-to-b from-red to-orange
                            scale-y-0 group-hover:scale-y-100 origin-top transition-transform duration-400 rounded"></div>
                <p class="font-extrabold text-navy text-base mb-1">{{ $p->nama_kegiatan }}</p>
                <p class="text-sm text-ink/60 mb-3 leading-relaxed">
                    {{ $p->tanggal_pelaksanaan ? \Carbon\Carbon::parse($p->tanggal_pelaksanaan)->translatedFormat('d M Y') : 'Segera' }}
                </p>
                <div class="flex items-center justify-between">
                    <p class="text-[10px] font-mono-data uppercase tracking-wider text-orange">
                        {{ $p->kementerian->kode ?? '-' }}
                    </p>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full
                        {{ $p->status === 'berjalan' ? 'bg-blue-50 text-blue-600' : 'bg-slate-100 text-slate-500' }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-sm text-ink/40 col-span-3">Belum ada program kerja.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA ASPIRASI --}}
<section class="relative overflow-hidden py-24"
         style="background: linear-gradient(135deg, #06101E 0%, #102A52 60%, #0D1433 100%);">
    <div class="pointer-events-none absolute -bottom-20 -right-20 w-72 h-72 rounded-full animate-float-b"
         style="background: radial-gradient(circle, rgba(227,30,48,0.18) 0%, transparent 70%); filter: blur(50px);"></div>
    <div class="relative max-w-2xl mx-auto px-6 text-center js-reveal">
        <p class="eyebrow text-red mb-4">Suaramu Penting</p>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">Punya Aspirasi atau Keluhan?</h2>
        <p class="text-white/50 max-w-lg mx-auto mb-10 leading-relaxed">
            Sampaikan langsung ke kami melalui Klinik Aspirasi dan Forum Dengar Pendapat (KAFDP)
            &mdash; tanpa perlu login, tanpa birokrasi.
        </p>
        <a href="{{ url('/aspirasi') }}" class="btn-primary text-base px-10 py-4">
            Isi Formulir Aspirasi
        </a>
    </div>
</section>

</div>{{-- end #page-content --}}

{{-- JS Modal --}}
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

    const pg  = document.getElementById('m-pengurus');
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

    const pk  = document.getElementById('m-proker');
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

    const modal   = document.getElementById('kem-modal');
    const card    = document.getElementById('kem-card');
    const content = document.getElementById('page-content');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';

    requestAnimationFrame(() => {
        content.style.filter    = 'blur(6px)';
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
    content.style.filter    = '';
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
