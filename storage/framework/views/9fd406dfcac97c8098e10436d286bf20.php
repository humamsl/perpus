<form method="POST" action="<?php echo e($action); ?>" enctype="multipart/form-data" class="card grid md:grid-cols-2 gap-4"><?php echo csrf_field(); ?>
    <?php if($method !== 'POST'): ?> <?php echo method_field($method); ?> <?php endif; ?>
    <div><label class="text-sm">ISBN</label><input name="isbn" required value="<?php echo e(old('isbn', $book->isbn ?? '')); ?>" class="form-input"></div>
    <div><label class="text-sm">Judul</label><input name="title" required value="<?php echo e(old('title', $book->title ?? '')); ?>" class="form-input"></div>
    <div><label class="text-sm">Subjudul</label><input name="subtitle" value="<?php echo e(old('subtitle', $book->subtitle ?? '')); ?>" class="form-input"></div>
    <div><label class="text-sm">Tahun Terbit</label><input type="number" name="year_published" value="<?php echo e(old('year_published', $book->year_published ?? '')); ?>" class="form-input"></div>
    <div><label class="text-sm">Kategori</label>
        <select name="book_category_id" class="form-input">
            <option value="">—</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php if(old('book_category_id', $book->book_category_id ?? '') == $c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label class="text-sm">Penerbit</label>
        <select name="publisher_id" class="form-input">
            <option value="">—</option>
            <?php $__currentLoopData = $publishers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>" <?php if(old('publisher_id', $book->publisher_id ?? '') == $p->id): echo 'selected'; endif; ?>><?php echo e($p->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label class="text-sm">Rak</label>
        <select name="shelf_id" class="form-input">
            <option value="">—</option>
            <?php $__currentLoopData = $shelves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s->id); ?>" <?php if(old('shelf_id', $book->shelf_id ?? '') == $s->id): echo 'selected'; endif; ?>><?php echo e($s->code); ?> — <?php echo e($s->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label class="text-sm">Stok</label><input type="number" name="stock" required value="<?php echo e(old('stock', $book->stock ?? 1)); ?>" class="form-input"></div>
    <div><label class="text-sm">Bahasa</label><input name="language" value="<?php echo e(old('language', $book->language ?? 'id')); ?>" class="form-input"></div>
    <div><label class="text-sm">Halaman</label><input type="number" name="pages" value="<?php echo e(old('pages', $book->pages ?? '')); ?>" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Penulis (Ctrl/Cmd untuk multi)</label>
        <select name="authors[]" multiple class="form-input h-28">
            <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($a->id); ?>" <?php if(isset($book) && $book->authors->contains($a->id)): echo 'selected'; endif; ?>><?php echo e($a->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="md:col-span-2"><label class="text-sm">Sinopsis</label><textarea name="synopsis" rows="4" class="form-input"><?php echo e(old('synopsis', $book->synopsis ?? '')); ?></textarea></div>
    <div class="md:col-span-2"><label class="text-sm">Kata Kunci</label><input name="keywords" value="<?php echo e(old('keywords', $book->keywords ?? '')); ?>" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Cover</label><input type="file" name="cover" accept="image/*" class="form-input"></div>
    <div class="md:col-span-2 flex gap-2"><button class="btn-primary">Simpan</button><a href="<?php echo e(route('books.index')); ?>" class="btn-secondary">Batal</a></div>
</form>
<?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/books/_form.blade.php ENDPATH**/ ?>