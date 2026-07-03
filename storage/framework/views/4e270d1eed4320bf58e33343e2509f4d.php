<?php $__env->startSection('title','Manajemen User'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-users-gear',
    'title' => 'Manajemen User',
    'desc'  => 'Kelola akun pengguna sistem.',
    'actions' => [
        ['url' => route('users.create'), 'label' => 'User Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aktif</th>
                <th class="text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="font-medium"><?php echo e($u->name); ?></td>
                <td><?php echo e($u->email); ?></td>
                <td><?php echo e($u->getRoleNames()->join(', ')); ?></td>
                <td>
                    <?php if($u->is_active): ?><span class="badge-green"><i class="fas fa-check"></i> aktif</span>
                    <?php else: ?><span class="badge-red"><i class="fas fa-xmark"></i> nonaktif</span><?php endif; ?>
                </td>
                <td class="px-4 py-3 text-right whitespace-nowrap">
                    <div class="inline-flex gap-1 items-center">
                        <a href="<?php echo e(route('users.show', $u)); ?>" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Detail"><i class="fas fa-eye"></i></a>
                        <a href="<?php echo e(route('users.edit', $u)); ?>" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Edit"><i class="fas fa-pen"></i></a>
                        <form method="POST" action="<?php echo e(route('users.toggleActive', $u)); ?>" class="inline-flex">
                            <?php echo csrf_field(); ?>
                            <button class="p-2 rounded-lg hover:bg-amber-50 dark:hover:bg-slate-700 text-amber-600" title="<?php echo e($u->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>">
                                <i class="fas <?php echo e($u->is_active ? 'fa-toggle-off' : 'fa-toggle-on'); ?>"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" class="text-center text-slate-500 py-10">
                    <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                    Belum ada data.
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="mt-4 px-2"><?php echo e($users->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/users/index.blade.php ENDPATH**/ ?>