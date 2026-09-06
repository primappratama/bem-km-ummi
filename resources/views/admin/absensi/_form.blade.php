@php $isEdit = isset($absensi); @endphp

<div class="glass-card p-6 space-y-5">

    {{-- Pengurus --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
            Pengurus <span class="text-red">*</span>
        </label>
        <select name="pengurus_id" required
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                       @error('pengurus_id') border-red @enderror">
            <option value="">— Pilih Pengurus —</option>
            @foreach ($pengurus as $pg)
            <option value="{{ $pg->id }}"
                {{ old('pengurus_id', $isEdit ? $absensi->pengurus_id : '') == $pg->id ? 'selected' : '' }}>
                {{ $pg->nama }} — {{ $pg->jabatan }}
            </option>
            @endforeach
        </select>
        @error('pengurus_id') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
    </div>

    {{-- Program Kerja --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
            Program Kerja <span class="text-red">*</span>
        </label>
        <select name="program_kerja_id" required
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                       @error('program_kerja_id') border-red @enderror">
            <option value="">— Pilih Program Kerja —</option>
            @foreach ($programKerja as $p)
            <option value="{{ $p->id }}"
                {{ old('program_kerja_id', $isEdit ? $absensi->program_kerja_id : '') == $p->id ? 'selected' : '' }}>
                {{ $p->nama_kegiatan }}
            </option>
            @endforeach
        </select>
        @error('program_kerja_id') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
    </div>

    <div class="grid sm:grid-cols-2 gap-4">
        {{-- Tanggal --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                Tanggal Kegiatan <span class="text-red">*</span>
            </label>
            <input type="date" name="tanggal" required
                   value="{{ $isEdit ? $absensi->tanggal->format('Y-m-d') : old('tanggal', date('Y-m-d')) }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                          focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                          @error('tanggal') border-red @enderror">
            @error('tanggal') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
        </div>

        {{-- Status --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                Status Kehadiran <span class="text-red">*</span>
            </label>
            <div class="flex gap-3">
                @foreach (\App\Models\Absensi::STATUS as $val => $label)
                <label class="relative flex items-center cursor-pointer">
                    <input type="radio" name="status_kehadiran" value="{{ $val }}" class="peer sr-only"
                           {{ old('status_kehadiran', $isEdit ? $absensi->status_kehadiran : 'hadir') === $val ? 'checked' : '' }}>
                    <span class="px-4 py-2 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-400
                                 transition-all duration-150
                                 @if($val === 'hadir') peer-checked:border-green-400 peer-checked:bg-green-50 peer-checked:text-green-600
                                 @elseif($val === 'izin') peer-checked:border-amber-400 peer-checked:bg-amber-50 peer-checked:text-amber-600
                                 @else peer-checked:border-red/50 peer-checked:bg-red/5 peer-checked:text-red @endif">
                        {{ $label }}
                    </span>
                </label>
                @endforeach
            </div>
            @error('status_kehadiran') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
        </div>
    </div>
</div>
