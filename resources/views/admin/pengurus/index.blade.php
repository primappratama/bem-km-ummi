@extends('layouts.admin')
@section('title', 'Data Pengurus')
@section('page-title', 'Data Pengurus')

@section('content')

{{-- Toolbar --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
    <form method="GET" action="{{ route('admin.pengurus.index') }}"
          class="flex flex-col sm:flex-row gap-2 flex-1">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama atau jabatan..."
               class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30 transition-all">

        <select name="kementerian_id"
                class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
            <option value="">Semua Kementerian</option>
            @foreach ($kementerian as $k)
            <option value="{{ $k->id }}" {{ request('kementerian_id') == $k->id ? 'selected' : '' }}>
                {{ $k->kode }}
            </option>
            @endforeach
        </select>

        <button type="submit"
                class="px-5 py-2.5 rounded-xl bg-navy text-white text-sm font-semibold
                       hover:bg-navy/90 transition-colors">
            Filter
        </button>
        @if (request()->hasAny(['search','kementerian_id']))
        <a href="{{ route('admin.pengurus.index') }}"
           class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-500
                  hover:bg-slate-50 transition-colors text-center">
            Reset
        </a>
        @endif
    </form>

    @if (auth()->user()->isAdmin())
    <a href="{{ route('admin.pengurus.create') }}" class="btn-primary shrink-0">
        + Tambah Pengurus
    </a>
    @endif
</div>

{{-- Table --}}
<div class="glass-card overflow-hidden">
    @if ($pengurus->isEmpty())
    <div class="py-16 text-center">
        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <p class="text-sm text-slate-400 font-medium">Belum ada data pengurus</p>
        <p class="text-xs text-slate-300 mt-1">Tambahkan pengurus pertama menggunakan tombol di atas.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Nama</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Jabatan</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider hidden md:table-cell">Kementerian</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider hidden lg:table-cell">Kontak</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider hidden lg:table-cell">Role Login</th>
                    <th class="px-5 py-3.5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach ($pengurus as $p)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-navy/10 flex items-center justify-center shrink-0">
                                <span class="text-xs font-bold text-navy">
                                    {{ strtoupper(substr($p->nama, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-semibold text-navy text-sm">{{ $p->nama }}</p>
                                <p class="text-xs text-slate-400">{{ $p->user->email ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-slate-600">{{ $p->jabatan }}</td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        @if ($p->kementerian)
                        <span class="inline-flex text-[10px] font-mono-data font-bold uppercase tracking-wider
                                     text-navy bg-navy/8 px-2 py-0.5 rounded-md">
                            {{ $p->kementerian->kode }}
                        </span>
                        @else
                        <span class="text-slate-300 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-slate-500 hidden lg:table-cell text-xs">
                        {{ $p->kontak ?? '—' }}
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell">
                        <span class="text-[10px] font-semibold px-2 py-1 rounded-full {{ $p->user->role_color ?? 'bg-slate-100 text-slate-500' }}">
                            {{ $p->user->role_label ?? '—' }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.pengurus.edit', ['pengurus' => $p->id]) }}"
                               class="p-1.5 rounded-lg text-slate-400 hover:text-navy hover:bg-navy/8 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            @if (auth()->user()->isAdmin())
                            <form method="POST"
                                  action="{{ route('admin.pengurus.destroy', ['pengurus' => $p->id]) }}"
                                  onsubmit="return confirm('Hapus {{ $p->nama }}? Akun login-nya juga akan dihapus.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-red hover:bg-red/8 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($pengurus->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $pengurus->links() }}
    </div>
    @endif
    @endif
</div>

<p class="text-xs text-slate-400 mt-3">
    Menampilkan {{ $pengurus->count() }} dari {{ $pengurus->total() }} pengurus
</p>

@endsection