<form method="POST" action="<?php echo e($action); ?>" enctype="multipart/form-data" class="card grid grid-cols-1 md:grid-cols-2 gap-4"><?php echo csrf_field(); ?>
    <?php if($method !== 'POST'): ?> <?php echo method_field($method); ?> <?php endif; ?>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">ISBN</label>
        <input name="isbn" required value="<?php echo e(old('isbn', $book->isbn ?? '')); ?>" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Judul</label>
        <input name="title" required value="<?php echo e(old('title', $book->title ?? '')); ?>" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Subjudul</label>
        <input name="subtitle" value="<?php echo e(old('subtitle', $book->subtitle ?? '')); ?>" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Tahun Terbit</label>
        <input type="number" name="year_published" value="<?php echo e(old('year_published', $book->year_published ?? '')); ?>" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kategori</label>
        <select name="book_category_id" class="form-select mt-1">
            <option value="">—</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php if(old('book_category_id', $book->book_category_id ?? '') == $c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Penerbit</label>
        <select name="publisher_id" class="form-select mt-1">
            <option value="">—</option>
            <?php $__currentLoopData = $publishers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>" <?php if(old('publisher_id', $book->publisher_id ?? '') == $p->id): echo 'selected'; endif; ?>><?php echo e($p->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Rak</label>
        <select name="shelf_id" class="form-select mt-1">
            <option value="">—</option>
            <?php $__currentLoopData = $shelves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s->id); ?>" <?php if(old('shelf_id', $book->shelf_id ?? '') == $s->id): echo 'selected'; endif; ?>><?php echo e($s->code); ?> — <?php echo e($s->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Bahasa</label>
        <input name="language" value="<?php echo e(old('language', $book->language ?? 'id')); ?>" class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Halaman</label>
        <input type="number" name="pages" value="<?php echo e(old('pages', $book->pages ?? '')); ?>" class="form-input mt-1">
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Penulis (Ctrl untuk multi)</label>
        <select name="authors[]" multiple class="form-select mt-1 h-36">
            <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($a->id); ?>" <?php if(isset($book) && $book->authors->contains($a->id)): echo 'selected'; endif; ?>><?php echo e($a->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Sinopsis</label>
        <textarea name="synopsis" rows="4" class="form-textarea mt-1"><?php echo e(old('synopsis', $book->synopsis ?? '')); ?></textarea>
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kata Kunci</label>
        <input name="keywords" value="<?php echo e(old('keywords', $book->keywords ?? '')); ?>" class="form-input mt-1">
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Cover</label>
        <input type="file" name="cover" accept="image/*" class="form-input mt-1">
    </div>

    <?php if(!isset($book)): ?>
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
                    <?php echo e(ini_get('upload_max_filesize')); ?>)-->. Format: PDF, EPUB, DOCX, PPTX, audio, video.
                </p>
                <?php $__errorArgs = ['ebook_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-rose-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Format</label>
                <select name="ebook_format" class="form-select mt-1">
                    <option value="">—</option>
                    <?php $__currentLoopData = ['pdf','epub','docx','pptx','audio','video']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($f); ?>" <?php if(old('ebook_format')===$f): echo 'selected'; endif; ?>><?php echo e($f); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['ebook_format'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-rose-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Akses</label>
                <select name="ebook_access" class="form-select mt-1">
                    <option value="public" <?php if(old('ebook_access')==='public'): echo 'selected'; endif; ?>>Publik</option>
                    <option value="member" <?php if(old('ebook_access', 'member')==='member'): echo 'selected'; endif; ?>>Anggota</option>
                    <option value="staff" <?php if(old('ebook_access')==='staff'): echo 'selected'; endif; ?>>Staff</option>
                </select>
            </div>
            <label class="flex items-center gap-2 md:col-span-2 text-sm text-slate-700 dark:text-slate-200">
                <input type="checkbox" name="ebook_downloadable" value="1" <?php if(old('ebook_downloadable')): echo 'checked'; endif; ?> class="rounded border-slate-300 text-primary-600 focus:ring-primary-500"> Boleh diunduh
            </label>
        </div>
    </div>
    <?php endif; ?>

    <div class="md:col-span-2 flex flex-wrap gap-2 pt-2 border-t border-slate-100 dark:border-slate-700">
        <button class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
        <a href="<?php echo e(route('books.index')); ?>" class="btn-secondary">Batal</a>
    </div>
</form>
<?php /**PATH D:\laragon\www\web\Perpus\resources\views/books/_form.blade.php ENDPATH**/ ?>