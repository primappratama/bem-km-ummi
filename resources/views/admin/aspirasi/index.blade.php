@extends('layouts.admin')
@section('title', 'Kelola Aspirasi')
@section('page-title', 'Aspirasi Mahasiswa')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
  <div class="glass-card p-5">
    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Total Masuk</p>
    <p class="text-2xl font-extrabold text-navy">{{ $stats['total'] }}</p>
  </div>
  <div class="glass-card p-5">
    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Belum Ditindaklanjuti</p>
    <p class="text-2xl font-extrabold text-amber-600">{{ $stats['belum'] }}</p>
  </div>
  <div class="glass-card p-5">
    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Sedang Diproses</p>
    <p class="text-2xl font-extrabold text-blue-600">{{ $stats['proses'] }}</p>
  </div>
  <div class="glass-card p-5">
    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Selesai</p>
    <p class="text-2xl font-extrabold text-green-600">{{ $stats['selesai'] }}</p>
  </div>
</div>

{{-- Toolbar --}}
<div class="flex flex-col sm:flex-row gap-3 mb-5">
  <form method="GET" action="{{ route('admin.aspirasi.index') }}"
        class="flex flex-col sm:flex-row gap-2 flex-1">

    <input type="text" name="search" value="{{ request('search') }}"
      placeholder="Cari nama, fakultas, atau isi aspirasi..."
      class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
             focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">

    <select name="status"
      class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
             focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
      <option value="">Semua Status</option>
      <option value="belum_ditindaklanjuti" {{ request('status') === 'belum_ditindaklanjuti' ? 'selected' : '' }}>
        Belum Ditindaklanjuti
      </option>
      <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>
        Diproses
      </option>
      <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>
        Selesai
      </option>
    </select>

    <button type="submit"
      class="px-5 py-2.5 rounded-xl bg-navy text-white text-sm font-semibold
             hover:bg-navy/90 transition-colors">
      Filter
    </button>

    @if (request()->hasAny(['search','status']))
    <a href="{{ route('admin.aspirasi.index') }}"
       class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-500
              hover:bg-slate-50 transition-colors text-center">
      Reset
    </a>
    @endif
  </form>
</div>

{{-- Table --}}
<div class="glass-card overflow-hidden">
  @if ($aspirasi->isEmpty())
  <div class="py-16 text-center">
    <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round"
        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
    </svg>
    <p class="text-sm text-slate-400 font-medium">Belum ada aspirasi masuk</p>
  </div>
  @else
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-slate-100">
          <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-8">No</th>
          <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Pengirim</th>
          <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Isi Aspirasi</th>
          <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider hidden md:table-cell">Tanggal</th>
          <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
          <th class="px-5 py-3.5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-50">
        @foreach ($aspirasi as $i => $item)
        <tr class="hover:bg-slate-50/60 transition-colors">

          <td class="px-5 py-4 text-xs text-slate-400">
            {{ $aspirasi->firstItem() + $i }}
          </td>

          <td class="px-5 py-4">
            <p class="text-sm font-medium text-navy">
              {{ $item->nama ?: 'Anonim' }}
            </p>
            <p class="text-xs text-slate-400 mt-0.5">
              {{ $item->fakultas ?: '—' }}
            </p>
          </td>

          <td class="px-5 py-4 max-w-xs">
            <p class="text-sm text-slate-700 line-clamp-2">
              {{ $item->isi_aspirasi }}
            </p>
          </td>

          <td class="px-5 py-4 hidden md:table-cell">
            <span class="text-xs text-slate-500">
              {{ $item->tanggal->translatedFormat('d M Y') }}
            </span>
          </td>

          <td class="px-5 py-4">
            <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold {{ $item->status_color }}">
              {{ $item->status_label }}
            </span>
          </td>

          <td class="px-5 py-4">
            <div class="flex items-center justify-end gap-2">

              {{-- Dropdown ubah status --}}
              <form method="POST" action="{{ route('admin.aspirasi.status', $item) }}">
                @csrf @method('PATCH')
                <select name="status_tindak_lanjut" onchange="this.form.submit()"
                  class="text-xs px-2 py-1.5 rounded-lg border border-slate-200 bg-white
                         text-slate-600 focus:outline-none focus:ring-2 focus:ring-navy/20
                         cursor-pointer transition-all">
                  @foreach (\App\Models\Aspirasi::STATUS as $val => $label)
                  <option value="{{ $val }}" {{ $item->status_tindak_lanjut === $val ? 'selected' : '' }}>
                    {{ $label }}
                  </option>
                  @endforeach
                </select>
              </form>

              {{-- Hapus --}}
              <form method="POST" action="{{ route('admin.aspirasi.destroy', $item) }}"
                class="hidden">
                @csrf @method('DELETE')
                <button type="submit"
                  class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors">
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
    </table>
  </div>

  @if ($aspirasi->hasPages())
  <div class="px-5 py-4 border-t border-slate-100">
    {{ $aspirasi->links() }}
  </div>
  @endif
  @endif
</div>

<p class="text-xs text-slate-400 mt-3">
  Menampilkan {{ $aspirasi->count() }} dari {{ $aspirasi->total() }} aspirasi
</p>

@endsection
