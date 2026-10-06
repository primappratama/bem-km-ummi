{{--
    Confirm Delete Modal — reusable
    Include SEKALI di layouts/admin.blade.php sebelum </body>
    Pakai: <button onclick="confirmDelete('{{ route(...) }}', 'Nama Item')">Hapus</button>
--}}

<div id="confirm-modal"
     class="fixed inset-0 z-[9998] hidden items-center justify-center p-4"
     role="dialog" aria-modal="true">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-navy/50 backdrop-blur-sm"
         onclick="closeConfirm()"></div>

    {{-- Card --}}
    <div id="confirm-card"
         class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm z-10
                translate-y-4 opacity-0 transition-all duration-200 ease-out overflow-hidden">

        {{-- Top accent --}}
        <div class="h-1 w-full" style="background: linear-gradient(90deg, #E31E30, #F0871E);"></div>

        <div class="p-6">
            {{-- Icon --}}
            <div class="w-12 h-12 rounded-2xl bg-red/8 flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-red" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            <h3 class="text-base font-bold text-navy text-center mb-1">Konfirmasi Hapus</h3>
            <p class="text-sm text-slate-400 text-center mb-1">Yakin ingin menghapus</p>
            <p id="confirm-name" class="text-sm font-semibold text-navy text-center mb-5 px-2"></p>
            <p class="text-xs text-slate-400 text-center mb-6">Tindakan ini tidak dapat dibatalkan.</p>

            <div class="flex gap-3">
                <button onclick="closeConfirm()"
                        class="flex-1 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold
                               text-slate-500 hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <form id="confirm-form" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold text-white
                                   transition-colors duration-150 active:scale-[.98]"
                            style="background:#E31E30">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(action, name) {
    document.getElementById('confirm-form').action = action;
    document.getElementById('confirm-name').textContent = name || 'data ini';

    const modal = document.getElementById('confirm-modal');
    const card  = document.getElementById('confirm-card');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';

    requestAnimationFrame(() => {
        card.classList.remove('translate-y-4', 'opacity-0');
        card.classList.add('translate-y-0', 'opacity-100');
    });
}

function closeConfirm() {
    const modal = document.getElementById('confirm-modal');
    const card  = document.getElementById('confirm-card');
    card.classList.add('translate-y-4', 'opacity-0');
    card.classList.remove('translate-y-0', 'opacity-100');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }, 200);
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeConfirm(); });
</script>
