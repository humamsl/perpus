<div class="fixed bottom-6 right-4 sm:right-6 z-[60] space-y-3 w-[calc(100%-2rem)] sm:w-96 pointer-events-none">
    <template x-for="t in items" :key="t.id">
        <div x-data="{ shown: false }" x-init="$nextTick(() => shown = true)" x-show="shown"
             x-transition:enter="transition ease-out-expo duration-500" x-transition:enter-start="opacity-0 translate-x-12 scale-95" x-transition:enter-end="opacity-100 translate-x-0 scale-100"
             class="pointer-events-auto relative overflow-hidden flex items-start gap-3 rounded-2xl px-4 py-3.5 text-sm shadow-hover ring-1 backdrop-blur-xl bg-white/90 dark:bg-ink-900/90"
             :class="{
                'ring-emerald-200 dark:ring-emerald-500/30': t.type==='success',
                'ring-rose-200 dark:ring-rose-500/30': t.type==='error',
                'ring-primary-200 dark:ring-primary-500/30': t.type==='info'
             }">
            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-xl text-white shadow-lg"
                  :class="{
                     'bg-gradient-to-br from-emerald-400 to-emerald-600 shadow-emerald-500/30': t.type==='success',
                     'bg-gradient-to-br from-rose-400 to-rose-600 shadow-rose-500/30': t.type==='error',
                     'bg-gradient-to-br from-primary-400 to-primary-700 shadow-primary-500/30': t.type==='info'
                  }">
                <i class="fas text-sm" :class="`fa-${t.icon}`"></i>
            </span>
            <span class="flex-1 font-medium text-slate-700 dark:text-slate-100 pt-1" x-text="t.msg"></span>
            <button @click="dismiss(t.id)" class="h-7 w-7 grid place-items-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-white/10 dark:hover:text-white transition" aria-label="Tutup">
                <i class="fas fa-xmark"></i>
            </button>
            <span class="absolute bottom-0 left-0 h-[3px] w-full origin-left"
                  style="animation: toast-bar 4.5s linear forwards"
                  :class="{
                     'bg-emerald-500': t.type==='success',
                     'bg-rose-500': t.type==='error',
                     'bg-primary-500': t.type==='info'
                  }"></span>
        </div>
    </template>
</div>
<?php /**PATH D:\laragon\www\web\Perpus\resources\views/partials/toast.blade.php ENDPATH**/ ?>