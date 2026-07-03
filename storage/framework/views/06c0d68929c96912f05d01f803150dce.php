<div class="fixed bottom-6 right-6 z-50 space-y-2 w-80">
    <template x-for="t in items" :key="t.id">
        <div x-transition class="flex items-start gap-3 rounded-xl shadow-lg px-4 py-3 text-sm border-l-4"
             :class="{
                'bg-emerald-50 border-emerald-500 text-emerald-800': t.type==='success',
                'bg-red-50 border-red-500 text-red-800': t.type==='error',
                'bg-primary-50 border-primary-500 text-primary-800': t.type==='info'
             }">
            <i class="fas mt-0.5 text-base" :class="`fa-${t.icon}`"></i>
            <span class="flex-1 font-medium" x-text="t.msg"></span>
            <button @click="dismiss(t.id)" class="opacity-60 hover:opacity-100">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
    </template>
</div>
<?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/partials/toast.blade.php ENDPATH**/ ?>