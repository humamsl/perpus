<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'book.view','book.create','book.update','book.delete','book.import','book.export',
            'ebook.view','ebook.upload','ebook.read','ebook.download','ebook.manage',
            'member.view','member.create','member.update','member.delete',
            'checkout.create','checkout.manage','checkout.view',
            'fine.view','fine.create','fine.waive','payment.record',
            'review.create','review.moderate',
            'report.view','report.export',
            'setting.manage','user.manage','audit.view','backup.run',
        ];
        foreach ($permissions as $p) Permission::firstOrCreate(['name' => $p, 'guard_name' => 'web']);

        $super  = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $admin  = Role::firstOrCreate(['name' => 'admin',       'guard_name' => 'web']);
        $staff  = Role::firstOrCreate(['name' => 'staff',       'guard_name' => 'web']);
        $teacher= Role::firstOrCreate(['name' => 'teacher',     'guard_name' => 'web']);
        $student= Role::firstOrCreate(['name' => 'student',     'guard_name' => 'web']);

        $super->syncPermissions(Permission::all());
        $admin->syncPermissions(Permission::whereNotIn('name',
            ['user.manage','setting.manage','backup.run'])->get());
        // Staff = petugas sirkulasi di meja layanan: boleh menambah transaksi
        // peminjaman (checkout.create) serta menambah & meng-import koleksi buku
        // (book.create + book.import), tapi tetap tidak boleh mengubah/menghapus
        // buku, mengelola user, atau mengubah pengaturan.
        $staff->syncPermissions([
            'book.view','book.create','book.import','member.view','member.create',
            'checkout.create','checkout.manage','checkout.view',
            'fine.view','payment.record',
        ]);
        $teacher->syncPermissions([
            'book.view','ebook.view','ebook.read','review.create',
        ]);
        $student->syncPermissions([
            'book.view','ebook.view','ebook.read','review.create',
        ]);
    }
}
