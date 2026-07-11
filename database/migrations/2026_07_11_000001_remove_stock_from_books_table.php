<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('books', function (Blueprint $t) {
            $t->dropColumn(['stock', 'available']);
        });
    }
    public function down(): void {
        Schema::table('books', function (Blueprint $t) {
            $t->unsignedInteger('stock')->default(1)->after('status');
            $t->unsignedInteger('available')->default(1)->after('stock');
        });
    }
};
