@php
    $user           = auth()->user();
    $isEdit         = isset($programKerja);
    $old            = fn($field, $default = '') => old($field, $isEdit ? $programKerja->$field : ($field === 'kementerian_id' ? ($defaultKemenId ?? '') : $default));
@endphp

<div class="glass-card p-6 space-y-4">

    {{-- Nama Kegiatan --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
            Nama Kegiatan <span class="text-red">*</span>
        </label>
        <input type="text" name="nama_kegiatan"
               value="{{ $old('nama_kegiatan') }}" required
               placeholder="Contoh: Sekolah Kastrat & Eksekutif"
               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                      transition-all @error('nama_kegiatan') border-red @enderror">
        @error('nama_kegiatan') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
    </div>

    {{-- Kementerian --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
            Kementerian <span class="text-red">*</span>
        </label>
        @if ($user->isKementerian())
            {{-- Kementerian user: read-only, auto-set --}}
            <div class="px-4 py-2.5 rounded-xl border border-slate-100 bg-slate-50 text-sm text-slate-500">
                {{ auth()->user()->pengurus?->kementerian?->kode }}
                — {{ auth()->user()->pengurus?->kementerian?->nama_kementerian }}
            </div>
            <input type="hidden" name="kementerian_id" value="{{ $old('kementerian_id') }}">
        @else
            <select name="kementerian_id" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                           focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                           @error('kementerian_id') border-red @enderror">
                <option value="">— Pilih Kementerian —</option>
                @foreach ($kementerian as $k)
                <option value="{{ $k->id }}" {{ $old('kementerian_id') == $k->id ? 'selected' : '' }}>
                    {{ $k->kode }} — {{ $k->nama_kementerian }}
                </option>
                @endforeach
            </select>
            @error('kementerian_id') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
        @endif
    </div>

    {{-- Tanggal + Anggaran --}}
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                Tanggal Pelaksanaan <span class="text-red">*</span>
            </label>
            <input type="date" name="tanggal_pelaksanaan"
                   value="{{ $isEdit ? $programKerja->tanggal_pelaksanaan->format('Y-m-d') : old('tanggal_pelaksanaan') }}"
                   required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                          focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                          @error('tanggal_pelaksanaan') border-red @enderror">
            @error('tanggal_pelaksanaan') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                Anggaran Rencana (Rp) <span class="text-red">*</span>
            </label>
            <input type="number" name="anggaran" min="0" step="1000"
                   value="{{ $old('anggaran', 0) }}" required
                   placeholder="0"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                          focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                          @error('anggaran') border-red @enderror">
            @error('anggaran') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Status --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
            Status <span class="text-red">*</span>
        </label>
        <div class="flex gap-3 flex-wrap">
            @foreach ([
                'rencana'  => ['label' => 'Rencana',  'color' => 'peer-checked:border-slate-400 peer-checked:bg-slate-50 peer-checked:text-slate-600'],
                'berjalan' => ['label' => 'Berjalan', 'color' => 'peer-checked:border-orange peer-checked:bg-orange/5 peer-checked:text-orange'],
                'selesai'  => ['label' => 'Selesai',  'color' => 'peer-checked:border-green-400 peer-checked:bg-green-50 peer-checked:text-green-600'],
            ] as $val => $opt)
            <label class="relative flex items-center cursor-pointer">
                <input type="radio" name="status" value="{{ $val }}" class="peer sr-only"
                       {{ $old('status', 'rencana') === $val ? 'checked' : '' }}>
                <span class="px-4 py-2 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-400
                             transition-all duration-150 {{ $opt['color'] }}">
                    {{ $opt['label'] }}
                </span>
            </label>
            @endforeach
        </div>
        @error('status') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
    </div>
</div>
