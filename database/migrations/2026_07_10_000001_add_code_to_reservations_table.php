<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('reservations', function (Blueprint $t) {
            $t->string('code', 20)->nullable()->unique()->after('id');
        });
    }
    public function down(): void {
        Schema::table('reservations', function (Blueprint $t) {
            $t->dropColumn('code');
        });
    }
};
