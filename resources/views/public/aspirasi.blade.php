@extends('layouts.public')
@section('title', 'Sampaikan Aspirasi')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-teal-50/30 py-16 px-4">
  <div class="max-w-xl mx-auto">

    {{-- Header --}}
    <div class="text-center mb-10">
      <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-4"
           style="background-color:#E8F0FA; border:1px solid #c5d5ea">
        <svg class="w-7 h-7" style="color:#102A52" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
      </div>
      <h1 class="text-2xl font-bold text-navy mb-2">Sampaikan Aspirasi Anda</h1>
      <p class="text-sm text-slate-500">
        Aspirasi Anda akan diterima dan ditindaklanjuti oleh BEM KM UMMI.<br>
        Pengisian nama dan fakultas bersifat opsional.
      </p>
    </div>

    {{-- Success message --}}
    @if (session('success'))
    <div class="mb-6 flex items-start gap-3 p-4 rounded-xl"
         style="background:#f0faf4; border:1px solid #86efac">
      <svg class="w-5 h-5 mt-0.5 shrink-0" style="color:#16a34a" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <p class="text-sm font-medium" style="color:#15803d">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Form --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-8">
      <form method="POST" action="{{ route('aspirasi.store') }}" class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
          <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
            Nama <span class="text-slate-300 font-normal normal-case">(opsional)</span>
          </label>
          <input type="text" name="nama" value="{{ old('nama') }}"
            placeholder="Nama Anda"
            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                   focus:outline-none transition-all
                   {{ $errors->has('nama') ? 'border-red-400' : '' }}"
            style="focus-border-color:#102A52">
          @error('nama')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        {{-- Fakultas --}}
        <div>
          <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
            Asal Fakultas <span class="text-slate-300 font-normal normal-case">(opsional)</span>
          </label>
          <input type="text" name="fakultas" value="{{ old('fakultas') }}"
            placeholder="Contoh: Fakultas Sains dan Teknologi"
            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                   focus:outline-none transition-all
                   {{ $errors->has('fakultas') ? 'border-red-400' : '' }}">
          @error('fakultas')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        {{-- Isi aspirasi --}}
        <div>
          <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
            Isi Aspirasi <span class="text-red-400">*</span>
          </label>
          <textarea name="isi_aspirasi" rows="6"
            placeholder="Tuliskan aspirasi, saran, atau masukan Anda untuk BEM KM UMMI..."
            class="w-full px-4 py-3 rounded-xl border text-sm resize-none focus:outline-none transition-all
                   {{ $errors->has('isi_aspirasi') ? 'border-red-400 bg-red-50' : 'border-slate-200 bg-white' }}">{{ old('isi_aspirasi') }}</textarea>
          @error('isi_aspirasi')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror
          @if (!$errors->has('isi_aspirasi'))
            <p class="mt-1 text-xs text-slate-400">Minimal 10 karakter.</p>
          @endif
        </div>

        {{-- Submit --}}
        <button type="submit"
          class="w-full py-3 rounded-xl text-white text-sm font-semibold transition-all duration-150 active:scale-[.98]"
          style="background-color:#102A52;"
          onmouseover="this.style.backgroundColor='#0d2244'"
          onmouseout="this.style.backgroundColor='#102A52'">
          Kirim Aspirasi
        </button>

      </form>
    </div>

    <p class="text-center text-xs text-slate-400 mt-6">
      BEM KM Universitas Muhammadiyah Sukabumi &mdash; {{ now()->year }}
    </p>

  </div>
</div>

@endsection