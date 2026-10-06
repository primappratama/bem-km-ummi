@extends('layouts.admin')
@section('title', 'Keuangan')
@section('page-title', 'Keuangan')

@section('content')

{{-- Summary Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    {{-- Saldo --}}
    <div class="glass-card p-5 col-span-2 lg:col-span-1">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Saldo Saat Ini</p>
        <p class="text-2xl font-extrabold {{ $saldo >= 0 ? 'text-navy' : 'text-red' }}">
            Rp {{ number_format(abs($saldo), 0, ',', '.') }}
        </p>
        @if ($saldo < 0)
        <p class="text-xs text-red mt-1">Defisit</p>
        @endif
    </div>

    {{-- Total Masuk --}}
    <div class="glass-card p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Total Pemasukan</p>
        <p class="text-xl font-extrabold text-green-600">
            Rp {{ number_format($totalMasuk, 0, ',', '.') }}
        </p>
    </div>

    {{-- Total Keluar --}}
    <div class="glass-card p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Total Pengeluaran</p>
        <p class="text-xl font-extrabold text-red">
            Rp {{ number_format($totalKeluar, 0, ',', '.') }}
        </p>
    </div>

    {{-- Bulan ini --}}
    <div class="glass-card p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
            Bulan {{ now()->translatedFormat('F Y') }}
        </p>
        <p class="text-sm font-semibold text-green-600">
            + Rp {{ number_format($masukBulanIni, 0, ',', '.') }}
        </p>
        <p class="text-sm font-semibold text-red mt-0.5">
            - Rp {{ number_format($keluarBulanIni, 0, ',', '.') }}
        </p>
    </div>
</div>

{{-- Toolbar --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
    <form method="GET" action="{{ route('admin.keuangan.index') }}"
          class="flex flex-col sm:flex-row gap-2 flex-1">

        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari keterangan..."
               class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                      focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">

        <select name="jenis"
                class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
            <option value="">Semua Jenis</option>
            <option value="masuk"  {{ request('jenis') === 'masuk'  ? 'selected' : '' }}>Pemasukan</option>
            <option value="keluar" {{ request('jenis') === 'keluar' ? 'selected' : '' }}>Pengeluaran</option>
        </select>

        <select name="program_kerja_id"
                class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
            <option value="">Semua Program</option>
            @foreach ($programKerja as $p)
            <option value="{{ $p->id }}" {{ request('program_kerja_id') == $p->id ? 'selected' : '' }}>
                {{ Str::limit($p->nama_kegiatan, 35) }}
            </option>
            @endforeach
        </select>

        <select name="bulan"
                class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
            <option value="">Semua Bulan</option>
            @foreach(range(1,12) as $m)
            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
            </option>
            @endforeach
        </select>

        <button type="submit"
                class="px-5 py-2.5 rounded-xl bg-navy text-white text-sm font-semibold
                       hover:bg-navy/90 transition-colors">
            Filter
        </button>
        @if (request()->hasAny(['search','jenis','program_kerja_id','bulan','tahun']))
        <a href="{{ route('admin.keuangan.index') }}"
           class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-500
                  hover:bg-slate-50 transition-colors text-center">
            Reset
        </a>
        @endif
    </form>

    <a href="{{ route('admin.keuangan.export') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-sm font-semibold
              border border-slate-200 text-slate-600 hover:bg-slate-50 transition-colors shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Export PDF
    </a>
    <a href="{{ route('admin.keuangan.create') }}" class="btn-primary shrink-0">
        + Catat Transaksi
    </a>
</div>

{{-- Table --}}
<div class="glass-card overflow-hidden">
    @if ($transaksi->isEmpty())
    <div class="py-16 text-center">
        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm text-slate-400 font-medium">Belum ada transaksi</p>
        <p class="text-xs text-slate-300 mt-1">Catat transaksi pertama menggunakan tombol di atas.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Keterangan</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider hidden md:table-cell">Program Kerja</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Jenis</th>
                    <th class="px-5 py-3.5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Jumlah</th>
                    <th class="px-5 py-3.5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach ($transaksi as $t)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-4 text-xs text-slate-500 whitespace-nowrap">
                        {{ $t->tanggal_transaksi->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-5 py-4">
                        <p class="text-sm text-navy font-medium">{{ $t->keterangan ?? '—' }}</p>
                        <p class="text-xs text-slate-400 mt-0.5 hidden sm:block">
                            Dicatat oleh {{ $t->user->name ?? '—' }}
                        </p>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        @if ($t->programKerja)
                        <span class="text-xs text-slate-600">
                            {{ Str::limit($t->programKerja->nama_kegiatan, 30) }}
                        </span>
                        @else
                        <span class="text-xs text-slate-300">Umum</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold {{ $t->jenis_color }}">
                            {{ $t->jenis_label }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-right font-mono-data text-sm font-bold
                               {{ $t->jenis === 'masuk' ? 'text-green-600' : 'text-red' }}">
                        {{ $t->jenis_prefix }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.keuangan.edit', $t) }}"
                               class="p-1.5 rounded-lg text-slate-400 hover:text-navy hover:bg-navy/8 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <button type="button"
                                    onclick="confirmDelete('{{ route('admin.keuangan.destroy', $t) }}', '{{ addslashes($t->keterangan ?: 'Transaksi ' . ucfirst($t->jenis)) }}')"
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-red hover:bg-red/8 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-red hover:bg-red/8 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>

            {{-- Footer total dari data yang difilter --}}
            @php
                $filteredMasuk  = $transaksi->getCollection()->where('jenis','masuk')->sum('jumlah');
                $filteredKeluar = $transaksi->getCollection()->where('jenis','keluar')->sum('jumlah');
            @endphp
            <tfoot class="border-t-2 border-slate-200 bg-slate-50/50">
                <tr>
                    <td colspan="4" class="px-5 py-3 text-xs font-semibold text-slate-500">
                        Total halaman ini
                    </td>
                    <td class="px-5 py-3 text-right">
                        <p class="text-xs font-bold text-green-600">+ Rp {{ number_format($filteredMasuk, 0, ',', '.') }}</p>
                        <p class="text-xs font-bold text-red">- Rp {{ number_format($filteredKeluar, 0, ',', '.') }}</p>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if ($transaksi->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $transaksi->links() }}
    </div>
    @endif
    @endif
</div>

<p class="text-xs text-slate-400 mt-3">
    Menampilkan {{ $transaksi->count() }} dari {{ $transaksi->total() }} transaksi
</p>

@endsection
