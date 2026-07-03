{{--
    Komponen field dengan tombol bantuan (?) yang membuka modal.
    Pakai:
    @include('partials.help-modal', [
        'label' => 'Proteksi Ujian',
        'required' => true,
        'name' => 'proteksi_ujian',
        'options' => ['otomatis' => 'Blokir Otomatis', 'manual' => 'Blokir Manual', 'nonaktif' => 'Tidak Aktif'],
        'selected' => 'otomatis',
        'help_title' => 'Tentang Proteksi Ujian',
        'help_body' => 'Mode <strong>Blokir Otomatis</strong> akan menutup ujian peserta secara otomatis jika...',
    ])
--}}
<div x-data="{ openHelp: false }" class="space-y-1">
    <div class="flex items-center gap-2">
        <label class="text-sm font-medium">
            {{ $label }}
            @if($required ?? false)<span class="text-red-500">*</span>@endif
        </label>
        <button type="button"
                @click="openHelp = true"
                class="h-5 w-5 rounded-full bg-slate-200 dark:bg-slate-700 text-xs text-slate-700 dark:text-slate-200 hover:bg-primary-500 hover:text-white transition"
                aria-label="Bantuan {{ $label }}">?</button>
    </div>

    <select name="{{ $name }}" class="form-input">
        @foreach(($options ?? []) as $val => $text)
            <option value="{{ $val }}" @selected(($selected ?? null) === $val)>{{ $text }}</option>
        @endforeach
    </select>

    {{-- Modal --}}
    <div x-show="openHelp"
         x-cloak
         x-transition.opacity
         @keydown.escape.window="openHelp = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50"
         @click.self="openHelp = false">
        <div x-show="openHelp"
             x-transition
             class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl max-w-lg w-full p-6 relative ring-1 ring-slate-100 dark:ring-slate-700">
            <button type="button"
                    @click="openHelp = false"
                    class="absolute top-3 right-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-xl"
                    aria-label="Tutup">&times;</button>

            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-3">{{ $help_title ?? 'Bantuan' }}</h3>
            <div class="text-sm text-slate-700 dark:text-slate-300 space-y-2 prose dark:prose-invert max-w-none">
                {!! $help_body ?? '' !!}
            </div>

            <div class="flex justify-end mt-5">
                <button type="button" @click="openHelp = false" class="btn-primary">Mengerti</button>
            </div>
        </div>
    </div>
</div>
