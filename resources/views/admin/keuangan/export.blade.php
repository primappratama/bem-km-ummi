<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Keuangan BEM KM UMMI</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Arial', sans-serif; font-size: 11px; color: #1a1a1a; background: white; }

        .page { max-width: 900px; margin: 0 auto; padding: 32px; }

        /* Header */
        .header { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2.5px solid #102A52; }
        .header img { width: 56px; height: 56px; object-fit: contain; }
        .header-text h1 { font-size: 15px; font-weight: 800; color: #102A52; }
        .header-text p { font-size: 10px; color: #64748b; margin-top: 2px; }
        .doc-title { margin-left: auto; text-align: right; }
        .doc-title h2 { font-size: 14px; font-weight: 700; color: #102A52; }
        .doc-title .periode { font-size: 10px; color: #64748b; margin-top: 2px; }

        /* Summary cards */
        .summary { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 24px; }
        .card { border-radius: 8px; padding: 12px 16px; }
        .card.masuk  { background: #f0faf4; border: 1px solid #86efac; }
        .card.keluar { background: #fff5f5; border: 1px solid #fca5a5; }
        .card.saldo  { background: #E8EEF5; border: 1px solid #c5d5ea; }
        .card-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 4px; }
        .card.masuk  .card-val { color: #15803d; font-size: 16px; font-weight: 800; }
        .card.keluar .card-val { color: #dc2626; font-size: 16px; font-weight: 800; }
        .card.saldo  .card-val { color: #102A52; font-size: 16px; font-weight: 800; }

        /* Table */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        thead tr { background: #102A52; }
        thead th { color: white; padding: 8px 10px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .3px; }
        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 7px 10px; font-size: 11px; vertical-align: middle; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 9px; font-weight: 700; }
        .badge-masuk  { background: #dcfce7; color: #15803d; }
        .badge-keluar { background: #fee2e2; color: #dc2626; }
        .amount-masuk  { color: #15803d; font-weight: 700; font-family: monospace; }
        .amount-keluar { color: #dc2626; font-weight: 700; font-family: monospace; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-muted { color: #94a3b8; font-style: italic; }

        /* Footer */
        .footer { margin-top: 32px; padding-top: 16px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: flex-end; }
        .footer-left p { font-size: 9.5px; color: #64748b; }
        .sign-box { text-align: center; }
        .sign-box .name { font-size: 10px; font-weight: 700; color: #102A52; margin-top: 48px; }
        .sign-box .role { font-size: 9px; color: #64748b; }

        .total-row td { background: #f0f4f8; font-weight: 700; font-size: 11px; padding: 9px 10px; }

        @media print {
            body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            .no-print { display: none !important; }
            .page { padding: 20px; }
        }
    </style>
</head>
<body>

{{-- Print / Back buttons --}}
<div class="no-print" style="background:#102A52; padding:12px 24px; display:flex; gap:12px; align-items:center;">
    <button onclick="window.print()"
            style="background:#F0871E; color:white; border:none; padding:8px 20px; border-radius:8px; font-weight:700; font-size:13px; cursor:pointer;">
        Cetak / Simpan PDF
    </button>
    <a href="{{ route('admin.keuangan.index') }}"
       style="color:#CADCFC; font-size:13px; text-decoration:none;">← Kembali</a>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.keuangan.export') }}"
          style="margin-left:auto; display:flex; gap:8px; align-items:center;">
        <select name="bulan" style="padding:6px 10px; border-radius:6px; border:none; font-size:12px;">
            <option value="">Semua Bulan</option>
            @for($m=1; $m<=12; $m++)
            <option value="{{ $m }}" {{ request('bulan')==$m?'selected':'' }}>
                {{ \Carbon\Carbon::createFromDate(null,$m,1)->translatedFormat('F') }}
            </option>
            @endfor
        </select>
        <select name="tahun" style="padding:6px 10px; border-radius:6px; border:none; font-size:12px;">
            <option value="">Semua Tahun</option>
            @for($y=now()->year; $y>=2024; $y--)
            <option value="{{ $y }}" {{ request('tahun')==$y?'selected':'' }}>{{ $y }}</option>
            @endfor
        </select>
        <select name="jenis" style="padding:6px 10px; border-radius:6px; border:none; font-size:12px;">
            <option value="">Semua Jenis</option>
            <option value="masuk"  {{ request('jenis')==='masuk'?'selected':'' }}>Pemasukan</option>
            <option value="keluar" {{ request('jenis')==='keluar'?'selected':'' }}>Pengeluaran</option>
        </select>
        <button type="submit" style="background:#F0871E; color:white; border:none; padding:6px 14px; border-radius:6px; font-weight:700; font-size:12px; cursor:pointer;">Filter</button>
    </form>
</div>

<div class="page">

    {{-- Header --}}
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo BEM KM UMMI">
        <div class="header-text">
            <h1>BEM KM Universitas Muhammadiyah Sukabumi</h1>
            <p>Badan Eksekutif Mahasiswa Keluarga Mahasiswa · Kabinet Revolusioner 2025/2026</p>
            <p>Jl. R. Syamsudin, S.H. No. 50, Kota Sukabumi, Jawa Barat 43113</p>
        </div>
        <div class="doc-title">
            <h2>LAPORAN KEUANGAN</h2>
            <div class="periode">{{ $periode }}</div>
            <div class="periode">Dicetak: {{ now()->translatedFormat('d F Y') }}</div>
        </div>
    </div>

    {{-- Summary --}}
    <div class="summary">
        <div class="card masuk">
            <div class="card-label">Total Pemasukan</div>
            <div class="card-val">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</div>
        </div>
        <div class="card keluar">
            <div class="card-label">Total Pengeluaran</div>
            <div class="card-val">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</div>
        </div>
        <div class="card saldo">
            <div class="card-label">Saldo Akhir</div>
            <div class="card-val">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Program Kerja</th>
                <th>Jenis</th>
                <th class="text-right">Jumlah (Rp)</th>
                <th>Dicatat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksi as $i => $t)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $t->tanggal_transaksi->translatedFormat('d M Y') }}</td>
                <td>{{ $t->keterangan ?: '-' }}</td>
                <td>{{ $t->programKerja->nama_kegiatan ?? '-' }}</td>
                <td><span class="badge badge-{{ $t->jenis }}">{{ ucfirst($t->jenis) }}</span></td>
                <td class="text-right amount-{{ $t->jenis }}">
                    {{ $t->jenis === 'masuk' ? '+' : '-' }} {{ number_format($t->jumlah, 0, ',', '.') }}
                </td>
                <td>{{ $t->user->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted" style="padding:20px;">
                    Tidak ada transaksi pada periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($transaksi->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="5">Total Transaksi: {{ $transaksi->count() }}</td>
                <td class="text-right">Rp {{ number_format($saldo, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>

    {{-- Footer tanda tangan --}}
    <div class="footer">
        <div class="footer-left">
            <p>Dokumen ini digenerate otomatis oleh Aplikasi BEM KM UMMI</p>
            <p>{{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>
        <div style="display:flex; gap:60px;">
            <div class="sign-box">
                <div class="name">_________________________</div>
                <div class="role">Bendahara Umum</div>
            </div>
            <div class="sign-box">
                <div class="name">_________________________</div>
                <div class="role">Presiden BEM KM UMMI</div>
            </div>
        </div>
    </div>

</div>

<script>
// Auto open print dialog if ?print=1
if (new URLSearchParams(location.search).get('print') === '1') {
    window.addEventListener('load', () => setTimeout(() => window.print(), 500));
}
</script>
</body>
</html>
