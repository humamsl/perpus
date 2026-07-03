<?php $__env->startSection('title', 'Tambah Anggota'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-user-plus',
    'title' => 'Tambah Anggota',
    'desc'  => 'Daftarkan anggota baru perpustakaan.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div x-data="{
        tab: 'manual',
        csrf: document.querySelector('meta[name=csrf-token]').content,
        loading: false,
        error: '',
        tahunList: [], rombelList: [], siswaList: [],
        tahunAjaranId: '', rombelId: '',
        selected: [],
        openDatacenterTab() {
            this.tab = 'datacenter';
            if (this.tahunList.length === 0) this.loadTahun();
        },
        async loadTahun() {
            this.loading = true; this.error = '';
            try {
                const res = await fetch('<?php echo e(route('members.datacenter.tahunAjaran')); ?>', { headers: { 'X-CSRF-TOKEN': this.csrf } });
                const d = await res.json();
                if (!res.ok) { this.error = d.message || 'Gagal memuat data Tahun Ajaran.'; return; }
                this.tahunList = d.data;
            } catch (e) { this.error = 'Tidak bisa terhubung ke Data Center.'; }
            finally { this.loading = false; }
        },
        async loadRombel() {
            this.rombelList = []; this.siswaList = []; this.rombelId = ''; this.selected = [];
            if (!this.tahunAjaranId) return;
            this.loading = true; this.error = '';
            try {
                const res = await fetch('<?php echo e(route('members.datacenter.rombel')); ?>?tahun_ajaran_id=' + this.tahunAjaranId, { headers: { 'X-CSRF-TOKEN': this.csrf } });
                const d = await res.json();
                if (!res.ok) { this.error = d.message || 'Gagal memuat data Kelas.'; return; }
                this.rombelList = d.data;
            } catch (e) { this.error = 'Tidak bisa terhubung ke Data Center.'; }
            finally { this.loading = false; }
        },
        async loadSiswa() {
            this.siswaList = []; this.selected = [];
            if (!this.rombelId) return;
            this.loading = true; this.error = '';
            try {
                const res = await fetch('<?php echo e(route('members.datacenter.siswa')); ?>?rombel_id=' + this.rombelId, { headers: { 'X-CSRF-TOKEN': this.csrf } });
                const d = await res.json();
                if (!res.ok) { this.error = d.message || 'Gagal memuat daftar siswa.'; return; }
                this.siswaList = d.data;
            } catch (e) { this.error = 'Tidak bisa terhubung ke Data Center.'; }
            finally { this.loading = false; }
        },
        toggleAll(checked) {
            this.selected = checked ? this.siswaList.filter(s => !s.already_member).map(s => s.id) : [];
        },
        toggleOne(id) {
            this.selected = this.selected.includes(id) ? this.selected.filter(x => x !== id) : [...this.selected, id];
        },
    }">

    <div class="flex gap-2 mb-4">
        <button type="button" @click="tab = 'manual'"
                class="px-4 py-2 rounded-lg text-sm font-semibold"
                :class="tab === 'manual' ? 'bg-primary-600 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300'">
            <i class="fas fa-pen"></i> Manual
        </button>
        <button type="button" @click="openDatacenterTab()"
                class="px-4 py-2 rounded-lg text-sm font-semibold"
                :class="tab === 'datacenter' ? 'bg-primary-600 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300'">
            <i class="fas fa-school"></i> Dari Data Center
        </button>
    </div>

    
    <div class="card max-w-3xl" x-show="tab === 'manual'">
        <form method="POST" action="<?php echo e(route('members.store')); ?>"><?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label><input name="name" required class="form-input mt-1"></div>
                <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label><input type="email" name="email" required class="form-input mt-1"></div>
                <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Password</label><input type="password" name="password" required class="form-input mt-1"></div>
                <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Konfirmasi</label><input type="password" name="password_confirmation" required class="form-input mt-1"></div>
                <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">NIS/NIP</label><input name="nis_nip" class="form-input mt-1"></div>
                <div>
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Tipe</label>
                    <select name="type" class="form-select mt-1">
                        <option value="student">Siswa</option><option value="teacher">Guru</option><option value="staff">Staff</option><option value="public">Umum</option>
                    </select>
                </div>
                <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kelas</label><input name="class" class="form-input mt-1"></div>
                <div><label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Jurusan</label><input name="major" class="form-input mt-1"></div>
                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Alamat</label>
                    <textarea name="address" class="form-textarea mt-1" rows="2"></textarea>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 mt-6">
                <button class="btn-primary"><i class="fas fa-check"></i> Simpan</button>
                <a href="<?php echo e(route('members.index')); ?>" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>

    
    <div class="card max-w-3xl" x-show="tab === 'datacenter'" x-cloak>
        <div x-show="error" class="badge-red mb-4 block py-2 px-3"><i class="fas fa-exclamation-circle"></i> <span x-text="error"></span></div>
        <div x-show="loading" class="text-sm text-slate-500 mb-4"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>

        <form method="POST" action="<?php echo e(route('members.datacenter.import')); ?>"><?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Tahun Ajaran</label>
                    <select class="form-select mt-1" x-model="tahunAjaranId" @change="loadRombel()">
                        <option value="">Pilih Tahun Ajaran...</option>
                        <template x-for="t in tahunList" :key="t.id">
                            <option :value="t.id" x-text="t.nama_tahun_ajaran + ' (' + t.semester + ')' + (t.is_aktif ? ' — Aktif' : '')"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kelas</label>
                    <select class="form-select mt-1" x-model="rombelId" @change="loadSiswa()" :disabled="!tahunAjaranId">
                        <option value="">Pilih Kelas...</option>
                        <template x-for="r in rombelList" :key="r.id">
                            <option :value="r.id" x-text="r.nama_rombel + (r.jurusan ? ' — ' + r.jurusan.nama_jurusan : '')"></option>
                        </template>
                    </select>
                </div>
            </div>

            <div class="mt-4" x-show="siswaList.length > 0">
                <div class="flex items-center justify-between mb-2">
                    <label class="flex items-center gap-2 text-sm font-semibold text-slate-700 dark:text-slate-200">
                        <input type="checkbox" class="rounded text-primary-600" @change="toggleAll($event.target.checked)">
                        Pilih Semua
                    </label>
                    <span class="text-xs text-slate-500" x-text="selected.length + ' dari ' + siswaList.length + ' siswa dipilih'"></span>
                </div>
                <div class="max-h-80 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-700 border rounded-lg border-slate-200 dark:border-slate-700">
                    <template x-for="s in siswaList" :key="s.id">
                        <label class="flex items-center gap-3 p-2 text-sm" :class="s.already_member ? 'opacity-50' : ''">
                            <input type="checkbox" class="rounded text-primary-600"
                                   :checked="selected.includes(s.id)"
                                   :disabled="s.already_member"
                                   @change="toggleOne(s.id)">
                            <span class="flex-1">
                                <span x-text="s.nama_siswa"></span>
                                <span class="text-slate-400" x-text="' — ' + s.nisn"></span>
                            </span>
                            <span x-show="s.already_member" class="badge-green text-xs">Sudah Anggota</span>
                        </label>
                    </template>
                </div>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 italic mt-2" x-show="rombelId && siswaList.length === 0 && !loading">
                Tidak ada siswa aktif di kelas ini.
            </p>

            <input type="hidden" name="rombel_id" :value="rombelId">
            <template x-for="id in selected" :key="id">
                <input type="hidden" name="siswa_ids[]" :value="id">
            </template>

            <div class="flex flex-wrap gap-2 mt-6">
                <button class="btn-primary" :disabled="selected.length === 0" :class="{ 'opacity-50': selected.length === 0 }">
                    <i class="fas fa-check"></i> Tambahkan <span x-text="selected.length"></span> Anggota
                </button>
                <a href="<?php echo e(route('members.index')); ?>" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/members/create.blade.php ENDPATH**/ ?>