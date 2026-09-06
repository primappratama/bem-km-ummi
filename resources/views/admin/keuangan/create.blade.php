@extends('layouts.admin')
@section('title', 'Catat Transaksi')
@section('page-title', 'Keuangan')
@section('page-subtitle', 'Catat Transaksi')

@section('content')
<div class="max-w-xl">
    <a href="{{ route('admin.keuangan.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-navy mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>

    <form method="POST" action="{{ route('admin.keuangan.store') }}" class="space-y-5">
        @csrf
        @include('admin.keuangan._form')
        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Simpan Transaksi</button>
            <a href="{{ route('admin.keuangan.index') }}"
               class="px-5 py-2.5 rounded-full text-sm font-semibold text-slate-500
                      border border-slate-200 hover:bg-slate-50 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
