<form method="POST" action="<?php echo e($action); ?>" enctype="multipart/form-data" class="card grid md:grid-cols-2 gap-4"><?php echo csrf_field(); ?>
    <?php if($method !== 'POST'): ?> <?php echo method_field($method); ?> <?php endif; ?>
    <div><label class="text-sm">Reading Spot</label>
        <select name="reading_spot_id" required class="form-input">
            <?php $__currentLoopData = $spots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s->id); ?>" <?php if(old('reading_spot_id', $book->reading_spot_id ?? '') == $s->id): echo 'selected'; endif; ?>><?php echo e($s->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label class="text-sm">ISBN</label><input name="isbn" value="<?php echo e(old('isbn', $book->isbn ?? '')); ?>" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Judul</label><input name="title" required value="<?php echo e(old('title', $book->title ?? '')); ?>" class="form-input"></div>
    <div><label class="text-sm">Subjudul</label><input name="subtitle" value="<?php echo e(old('subtitle', $book->subtitle ?? '')); ?>" class="form-input"></div>
    <div><label class="text-sm">Tahun</label><input type="number" name="year_published" value="<?php echo e(old('year_published', $book->year_published ?? '')); ?>" class="form-input"></div>
    <div><label class="text-sm">Penerbit</label>
        <select name="publisher_id" class="form-input">
            <option value="">—</option>
            <?php $__currentLoopData = $publishers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>" <?php if(old('publisher_id', $book->publisher_id ?? '') == $p->id): echo 'selected'; endif; ?>><?php echo e($p->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label class="text-sm">DDC</label>
        <select name="ddc_category_id" class="form-input">
            <option value="">—</option>
            <?php $__currentLoopData = $ddcs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($d->id); ?>" <?php if(old('ddc_category_id', $book->ddc_category_id ?? '') == $d->id): echo 'selected'; endif; ?>><?php echo e($d->code); ?> — <?php echo e($d->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label class="text-sm">Bahasa</label><input name="language" value="<?php echo e(old('language', $book->language ?? 'id')); ?>" class="form-input"></div>
    <div><label class="text-sm">Halaman</label><input type="number" name="pages" value="<?php echo e(old('pages', $book->pages ?? '')); ?>" class="form-input"></div>
    <div><label class="text-sm">Sumber</label>
        <select name="source" class="form-input">
            <option value="purchase" <?php if(old('source', $book->source ?? '')==='purchase'): echo 'selected'; endif; ?>>Pembelian</option>
            <option value="donation" <?php if(old('source', $book->source ?? '')==='donation'): echo 'selected'; endif; ?>>Donasi</option>
            <option value="exchange" <?php if(old('source', $book->source ?? '')==='exchange'): echo 'selected'; endif; ?>>Tukar</option>
            <option value="other"    <?php if(old('source', $book->source ?? '')==='other'): echo 'selected'; endif; ?>>Lainnya</option>
        </select>
    </div>
    <?php if(!isset($book)): ?>
    <div><label class="text-sm">Jumlah Kopi Awal</label><input type="number" name="initial_copies" value="1" min="1" max="100" required class="form-input"></div>
    <?php endif; ?>
    <div class="md:col-span-2"><label class="text-sm">Penulis (Ctrl/Cmd untuk multi)</label>
        <select name="authors[]" multiple class="form-input h-28">
            <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($a->id); ?>" <?php if(isset($book) && $book->authors->contains($a->id)): echo 'selected'; endif; ?>><?php echo e($a->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="md:col-span-2"><label class="text-sm">Kategori</label>
        <select name="categories[]" multiple class="form-input h-24">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php if(isset($book) && $book->categories->contains($c->id)): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="md:col-span-2"><label class="text-sm">Sinopsis</label><textarea name="synopsis" rows="3" class="form-input"><?php echo e(old('synopsis', $book->synopsis ?? '')); ?></textarea></div>
    <div class="md:col-span-2"><label class="text-sm">Kata Kunci</label><input name="keywords" value="<?php echo e(old('keywords', $book->keywords ?? '')); ?>" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Cover</label><input type="file" name="cover" accept="image/*" class="form-input"></div>
    <div class="md:col-span-2 flex gap-2"><button class="btn-primary">Simpan</button><a href="<?php echo e(route('offline-books.index')); ?>" class="btn-secondary">Batal</a></div>
</form>
<?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/offline-books/_form.blade.php ENDPATH**/ ?>