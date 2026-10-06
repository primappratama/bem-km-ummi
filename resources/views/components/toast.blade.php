@if(session('success') || session('error') || session('success_password') || session('warning'))

<div id="toast-wrap"
     class="fixed bottom-6 right-6 z-[9999] flex flex-col gap-3 pointer-events-none"
     style="min-width:320px; max-width:420px;">
</div>

<script>
(function () {
    const wrap = document.getElementById('toast-wrap');
    const queue = [
        @if(session('success'))
            { msg: @json(session('success')), type: 'success' },
        @endif
        @if(session('success_password'))
            { msg: @json(session('success_password')), type: 'success' },
        @endif
        @if(session('warning'))
            { msg: @json(session('warning')), type: 'warning' },
        @endif
        @if(session('error'))
            { msg: @json(session('error')), type: 'error' },
        @endif
    ];

    const icons = {
        success: `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`,
        error:   `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>`,
        warning: `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>`,
    };
    const styles = {
        success: { bg:'#f0faf4', border:'#86efac', icon:'#16a34a', iconBg:'#dcfce7', text:'#15803d' },
        error:   { bg:'#fff5f5', border:'#fca5a5', icon:'#dc2626', iconBg:'#fee2e2', text:'#991b1b' },
        warning: { bg:'#fffbeb', border:'#fcd34d', icon:'#d97706', iconBg:'#fef3c7', text:'#92400e' },
    };

    queue.forEach((t, i) => {
        setTimeout(() => {
            const st = styles[t.type] || styles.success;
            const el = document.createElement('div');
            el.className = 'pointer-events-auto flex items-start gap-3 p-4 rounded-2xl shadow-xl transition-all duration-300 translate-y-4 opacity-0';
            el.style.cssText = `background:${st.bg}; border:1.5px solid ${st.border};`;
            el.innerHTML = `
                <div style="background:${st.iconBg}; color:${st.icon}"
                     class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                    ${icons[t.type]}
                </div>
                <p class="text-sm font-medium flex-1 leading-relaxed" style="color:${st.text}">${t.msg}</p>
                <button class="mt-0.5 opacity-40 hover:opacity-80 transition-opacity shrink-0"
                        style="color:${st.text}"
                        onclick="dismissToast(this.closest('div[style]'))">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>`;
            wrap.appendChild(el);
            requestAnimationFrame(() => {
                el.classList.remove('translate-y-4', 'opacity-0');
                el.classList.add('translate-y-0', 'opacity-100');
            });
            setTimeout(() => dismissToast(el), 4500 + i * 300);
        }, i * 250);
    });

    window.dismissToast = function(el) {
        if (!el) return;
        el.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => el.remove(), 300);
    };
})();
</script>

@endif
