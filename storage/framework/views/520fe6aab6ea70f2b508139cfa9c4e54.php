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
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Penulis (Ctrl/Cmd untuk multi)</label>
        <select name="authors[]" multiple class="form-select mt-1 h-28">
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
    <div class="md:col-span-2 flex flex-wrap gap-2 pt-2 border-t border-slate-100 dark:border-slate-700">
        <button class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
        <a href="<?php echo e(route('books.index')); ?>" class="btn-secondary">Batal</a>
    </div>
</form>
<?php /**PATH C:\laragon\www\web\Perpus\resources\views/books/_form.blade.php ENDPATH**/ ?>