<?php $__env->startSection('title', 'Anggota'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-users',
    'title' => 'Manajemen Anggota',
    'desc'  => 'Kelola data keanggotaan perpustakaan.',
    'actions' => [
        ['url' => route('members.create'), 'label' => 'Anggota Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus', 'can' => 'member.create'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<form class="card mb-6" method="get">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Nama / NIS / email..." class="form-input md:col-span-6">
        <select name="type" class="form-select md:col-span-4">
            <option value="">Semua</option>
            <option value="student" <?php if(request('type')==='student'): echo 'selected'; endif; ?>>Siswa</option>
            <option value="teacher" <?php if(request('type')==='teacher'): echo 'selected'; endif; ?>>Guru</option>
            <option value="public"  <?php if(request('type')==='public'): echo 'selected'; endif; ?>>Umum</option>
        </select>
        <button class="btn-secondary md:col-span-2"><i class="fas fa-magnifying-glass"></i> Cari</button>
    </div>
</form>

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>No</th><th>Nama</th><th>NIS/NIP</th><th>Tipe</th><th>Aktif</th><th></th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="font-mono text-xs"><?php echo e($m->member_no); ?></td>
                <td><?php echo e($m->user?->name); ?><br><span class="text-xs text-slate-500 dark:text-slate-400"><?php echo e($m->user?->email); ?></span></td>
                <td><?php echo e($m->nis_nip); ?></td>
                <td><?php echo e($m->type); ?></td>
                <td><?php if($m->is_active): ?><span class="badge-green"><i class="fas fa-check"></i> aktif</span><?php else: ?><span class="badge-red"><i class="fas fa-xmark"></i> tidak</span><?php endif; ?></td>
                <td class="text-right whitespace-nowrap">
                    <a href="<?php echo e(route('members.show', $m)); ?>" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Detail"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" class="text-center text-slate-500 py-10">
                <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                Belum ada anggota.
            </td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="mt-4 px-2"><?php echo e($members->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/members/index.blade.php ENDPATH**/ ?>