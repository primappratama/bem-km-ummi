@php
    $isEdit = isset($keuangan);
    $old = fn($f, $d='') => old($f, $isEdit ? $keuangan->$f : $d);
@endphp

<div class="glass-card p-6 space-y-5">

    {{-- Jenis Transaksi --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
            Jenis Transaksi <span class="text-red">*</span>
        </label>
        <div class="flex gap-3">
            <label class="relative flex items-center cursor-pointer">
                <input type="radio" name="jenis" value="masuk" class="peer sr-only"
                       {{ $old('jenis','masuk') === 'masuk' ? 'checked' : '' }}>
                <span class="px-5 py-2.5 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-400
                             peer-checked:border-green-400 peer-checked:bg-green-50 peer-checked:text-green-600
                             transition-all duration-150">
                    + Pemasukan
                </span>
            </label>
            <label class="relative flex items-center cursor-pointer">
                <input type="radio" name="jenis" value="keluar" class="peer sr-only"
                       {{ $old('jenis') === 'keluar' ? 'checked' : '' }}>
                <span class="px-5 py-2.5 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-400
                             peer-checked:border-red/50 peer-checked:bg-red/5 peer-checked:text-red
                             transition-all duration-150">
                    - Pengeluaran
                </span>
            </label>
        </div>
        @error('jenis') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
    </div>

    {{-- Jumlah (Rupiah formatted) --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
            Jumlah (Rp) <span class="text-red">*</span>
        </label>
        <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400 font-mono-data select-none">Rp</span>
            {{-- Display input (formatted) --}}
            <input type="text"
                   id="jumlah_display"
                   inputmode="numeric"
                   placeholder="0"
                   autocomplete="off"
                   value="{{ $isEdit ? number_format(old('jumlah', $keuangan->jumlah), 0, ',', '.') : (old('jumlah') ? number_format(old('jumlah'), 0, ',', '.') : '') }}"
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-mono-data
                          focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                          transition-all @error('jumlah') border-red @enderror">
            {{-- Hidden input sends raw number --}}
            <input type="hidden" name="jumlah" id="jumlah_raw"
                   value="{{ old('jumlah', $isEdit ? (int)$keuangan->jumlah : '') }}">
        </div>
        <p class="mt-1 text-xs text-slate-400">Contoh: 1.500.000 → otomatis diformat</p>
        @error('jumlah') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
    </div>

    {{-- Keterangan --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
            Keterangan
        </label>
        <input type="text" name="keterangan"
               value="{{ $old('keterangan') }}"
               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                      focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                      transition-all"
               placeholder="Contoh: Dana proker SEKATIF, Iuran anggota, dll.">
        @error('keterangan') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
    </div>

    <div class="grid sm:grid-cols-2 gap-4">
        {{-- Tanggal --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                Tanggal Transaksi <span class="text-red">*</span>
            </label>
            <input type="date" name="tanggal_transaksi"
                   value="{{ $isEdit ? $keuangan->tanggal_transaksi->format('Y-m-d') : old('tanggal_transaksi', date('Y-m-d')) }}"
                   required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                          focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                          @error('tanggal_transaksi') border-red @enderror">
            @error('tanggal_transaksi') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
        </div>

        {{-- Program Kerja (opsional) --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                Program Kerja <span class="text-slate-300 font-normal">(opsional)</span>
            </label>
            <select name="program_kerja_id"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                           focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
                <option value="">— Transaksi Umum —</option>
                @foreach ($programKerja as $p)
                <option value="{{ $p->id }}"
                    {{ old('program_kerja_id', $isEdit ? $keuangan->program_kerja_id : '') == $p->id ? 'selected' : '' }}>
                    {{ Str::limit($p->nama_kegiatan, 45) }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{{-- JS: format Rupiah otomatis --}}
<script>
(function () {
    const display = document.getElementById('jumlah_display');
    const raw     = document.getElementById('jumlah_raw');

    function toRupiah(val) {
        const digits = val.replace(/\D/g, '');
        return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    display.addEventListener('input', function () {
        const pos = this.selectionStart;
        const oldLen = this.value.length;
        this.value = toRupiah(this.value);
        // Restore cursor position approximately
        const newLen = this.value.length;
        this.setSelectionRange(pos + (newLen - oldLen), pos + (newLen - oldLen));
        raw.value = this.value.replace(/\./g, '');
    });

    display.addEventListener('blur', function () {
        if (!this.value) raw.value = '';
    });

    // Sync on page load (edit mode)
    if (display.value) {
        raw.value = display.value.replace(/\./g, '');
    }

    // Strip dots before submit (backup)
    display.closest('form').addEventListener('submit', function () {
        raw.value = display.value.replace(/\./g, '');
    });
})();
</script>
