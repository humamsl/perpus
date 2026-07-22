<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="card grid grid-cols-1 md:grid-cols-2 gap-4">@csrf
    @if($method !== 'POST') @method($method) @endif
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">ISBN</label>
        <input name="isbn" required value="{{ old('isbn', $book->isbn ?? '') }}" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Judul</label>
        <input name="title" required value="{{ old('title', $book->title ?? '') }}" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Subjudul</label>
        <input name="subtitle" value="{{ old('subtitle', $book->subtitle ?? '') }}" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Tahun Terbit</label>
        <input type="number" name="year_published" value="{{ old('year_published', $book->year_published ?? '') }}" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kategori</label>
        <select name="book_category_id" class="form-select mt-1">
            <option value="">—</option>
            @foreach($categories as $c)<option value="{{ $c->id }}" @selected(old('book_category_id', $book->book_category_id ?? '') == $c->id)>{{ $c->name }}</option>@endforeach
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Penerbit</label>
        <select name="publisher_id" class="form-select mt-1">
            <option value="">—</option>
            @foreach($publishers as $p)<option value="{{ $p->id }}" @selected(old('publisher_id', $book->publisher_id ?? '') == $p->id)>{{ $p->name }}</option>@endforeach
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Rak</label>
        <select name="shelf_id" class="form-select mt-1">
            <option value="">—</option>
            @foreach($shelves as $s)<option value="{{ $s->id }}" @selected(old('shelf_id', $book->shelf_id ?? '') == $s->id)>{{ $s->code }} — {{ $s->name }}</option>@endforeach
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
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Penulis (Ctrl untuk multi)</label>
        <select name="authors[]" multiple class="form-select mt-1 h-36">
            @foreach($authors as $a)<option value="{{ $a->id }}" @selected(isset($book) && $book->authors->contains($a->id))>{{ $a->name }}</option>@endforeach
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Sinopsis</label>
        <textarea name="synopsis" rows="4" class="form-textarea mt-1">{{ old('synopsis', $book->synopsis ?? '') }}</textarea>
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kata Kunci</label>
        <input name="keywords" value="{{ old('keywords', $book->keywords ?? '') }}" class="form-input mt-1">
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Cover</label>
        <input type="file" name="cover" accept="image/*" class="form-input mt-1">
    </div>

    @if(!isset($book))
    <div class="md:col-span-2 form-section">
        <h3 class="form-section-title"><i class="fas fa-cloud-arrow-up"></i> File Buku Digital </h3>
        <p class="form-hint mb-3">Unggah file agar buku ini langsung bisa dibaca online. Bisa juga ditambahkan/diedit belakangan dari halaman detail buku.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">File</label>
                <input type="file" name="ebook_file" class="form-input mt-1"
                       accept=".pdf,.epub,.docx,.pptx,.mp3,.m4a,.wav,.mp4,.webm">
                <p class="form-hint mt-1">
                    <!--setting max upload file di php.ini tidak bisa diubah di sini, jadi jika ingin mengunggah file lebih besar dari 100 MB, silakan ubah settingan servernya.-->
                    Maks. 100 MB per file <!--(batas server saat ini:
                    {{ ini_get('upload_max_filesize') }})-->. Format: PDF, EPUB, DOCX, PPTX, audio, video.
                </p>
                @error('ebook_file')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Format</label>
                <select name="ebook_format" class="form-select mt-1">
                    <option value="">—</option>
                    @foreach(['pdf','epub','docx','pptx','audio','video'] as $f)<option value="{{ $f }}" @selected(old('ebook_format')===$f)>{{ $f }}</option>@endforeach
                </select>
                @error('ebook_format')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Akses</label>
                <select name="ebook_access" class="form-select mt-1">
                    <option value="public" @selected(old('ebook_access')==='public')>Publik</option>
                    <option value="member" @selected(old('ebook_access', 'member')==='member')>Anggota</option>
                    <option value="staff" @selected(old('ebook_access')==='staff')>Staff</option>
                </select>
            </div>
            <label class="flex items-center gap-2 md:col-span-2 text-sm text-slate-700 dark:text-slate-200">
                <input type="checkbox" name="ebook_downloadable" value="1" @checked(old('ebook_downloadable')) class="rounded border-slate-300 text-primary-600 focus:ring-primary-500"> Boleh diunduh
            </label>
        </div>
    </div>
    @endif

    <div class="md:col-span-2 flex flex-wrap gap-2 pt-2 border-t border-slate-100 dark:border-slate-700">
        <button class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
        <a href="{{ route('books.index') }}" class="btn-secondary">Batal</a>
    </div>
</form>
