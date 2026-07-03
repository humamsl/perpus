@extends('layouts.app')
@section('title','Checkout Baru')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-door-open',
    'title' => 'Checkout Buku Fisik',
    'desc'  => 'Catat peminjaman buku fisik di reading spot.',
])

<div class="card max-w-3xl">
    <form method="POST" action="{{ route('checkouts.store') }}" x-data="{ copies: [] }">@csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Anggota</label>
                <select name="user_id" required class="form-select mt-1">
                    <option value="">Pilih anggota...</option>
                    @foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>@endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Reading Spot</label>
                <select name="reading_spot_id" required class="form-select mt-1">
                    <option value="">Pilih lokasi...</option>
                    @foreach($spots as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Scan / Tambah Kopi (catalog_code atau barcode)</label>
                <div class="flex gap-2 mt-1">
                    <input type="text" id="copy-input" placeholder="Tempelkan barcode/catalog code..." class="form-input flex-1"
                           @keyup.enter.prevent="
                               fetch('{{ route('checkouts.lookupCopy') }}?code=' + $event.target.value, { headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }})
                                   .then(r => r.json())
                                   .then(d => { if (d && d.id && !copies.find(c => c.id===d.id)) copies.push(d); $event.target.value=''; });
                           ">
                </div>
                <div class="mt-2 space-y-1">
                    <template x-for="c in copies" :key="c.id">
                        <div class="flex justify-between items-center p-2 rounded-lg bg-primary-50/70 dark:bg-slate-700/40">
                            <span class="text-sm" x-text="(c.offline_book?.title || 'Buku') + ' — ' + c.catalog_code"></span>
                            <button type="button" @click="copies = copies.filter(x => x.id !== c.id)" class="text-red-600 text-sm px-2"><i class="fas fa-xmark"></i></button>
                            <input type="hidden" name="copy_ids[]" :value="c.id">
                        </div>
                    </template>
                    <p x-show="copies.length === 0" class="text-xs text-slate-500 dark:text-slate-400 italic">Belum ada kopi dipilih.</p>
                </div>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Lama Pinjam (hari, default sesuai CheckoutSetting)</label>
                <input type="number" name="days" min="1" max="30" class="form-input mt-1">
            </div>
        </div>
        <div class="mt-6">
            <button class="btn-primary" :disabled="copies.length === 0" :class="{ 'opacity-50': copies.length === 0 }"><i class="fas fa-check"></i> Simpan Checkout</button>
        </div>
    </form>
</div>
@endsection
