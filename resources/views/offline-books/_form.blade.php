<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="card grid grid-cols-1 md:grid-cols-2 gap-4">@csrf
    @if($method !== 'POST') @method($method) @endif
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Reading Spot</label>
        <select name="reading_spot_id" required class="form-select mt-1">
            @foreach($spots as $s)<option value="{{ $s->id }}" @selected(old('reading_spot_id', $book->reading_spot_id ?? '') == $s->id)>{{ $s->name }}</option>@endforeach
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">ISBN</label>
        <input name="isbn" value="{{ old('isbn', $book->isbn ?? '') }}" class="form-input mt-1">
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Judul</label>
        <input name="title" required value="{{ old('title', $book->title ?? '') }}" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Subjudul</label>
        <input name="subtitle" value="{{ old('subtitle', $book->subtitle ?? '') }}" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Tahun</label>
        <input type="number" name="year_published" value="{{ old('year_published', $book->year_published ?? '') }}" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Penerbit</label>
        <select name="publisher_id" class="form-select mt-1">
            <option value="">—</option>
            @foreach($publishers as $p)<option value="{{ $p->id }}" @selected(old('publisher_id', $book->publisher_id ?? '') == $p->id)>{{ $p->name }}</option>@endforeach
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">DDC</label>
        <select name="ddc_category_id" class="form-select mt-1">
            <option value="">—</option>
            @foreach($ddcs as $d)<option value="{{ $d->id }}" @selected(old('ddc_category_id', $book->ddc_category_id ?? '') == $d->id)>{{ $d->code }} — {{ $d->name }}</option>@endforeach
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Bahasa</label>
        <input name="language" value="{{ old('language', $book->language ?? 'id') }}" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Halaman</label>
        <input type="number" name="pages" value="{{ old('pages', $book->pages ?? '') }}" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Sumber</label>
        <select name="source" class="form-select mt-1">
            <option value="purchase" @selected(old('source', $book->source ?? '')==='purchase')>Pembelian</option>
            <option value="donation" @selected(old('source', $book->source ?? '')==='donation')>Donasi</option>
            <option value="exchange" @selected(old('source', $book->source ?? '')==='exchange')>Tukar</option>
            <option value="other"    @selected(old('source', $book->source ?? '')==='other')>Lainnya</option>
        </select>
    </div>
    @if(!isset($book))
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Jumlah Kopi Awal</label>
        <input type="number" name="initial_copies" value="1" min="1" max="100" required class="form-input mt-1">
    </div>
    @endif
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Penulis (Ctrl/Cmd untuk multi)</label>
        <select name="authors[]" multiple class="form-select mt-1 h-28">
            @foreach($authors as $a)<option value="{{ $a->id }}" @selected(isset($book) && $book->authors->contains($a->id))>{{ $a->name }}</option>@endforeach
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kategori</label>
        <select name="categories[]" multiple class="form-select mt-1 h-24">
            @foreach($categories as $c)<option value="{{ $c->id }}" @selected(isset($book) && $book->categories->contains($c->id))>{{ $c->name }}</option>@endforeach
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Sinopsis</label>
        <textarea name="synopsis" rows="3" class="form-textarea mt-1">{{ old('synopsis', $book->synopsis ?? '') }}</textarea>
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kata Kunci</label>
        <input name="keywords" value="{{ old('keywords', $book->keywords ?? '') }}" class="form-input mt-1">
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Cover</label>
        <input type="file" name="cover" accept="image/*" class="form-input mt-1">
    </div>
    <div class="md:col-span-2 flex flex-wrap gap-2 pt-2 border-t border-slate-100 dark:border-slate-700">
        <button class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
        <a href="{{ route('offline-books.index') }}" class="btn-secondary">Batal</a>
    </div>
</form>
