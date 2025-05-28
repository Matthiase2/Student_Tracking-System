<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
    if (!Schema::hasColumn('users', 'studentid')) {
        $table->string('studentid')->nullable();
    }

    if (!Schema::hasColumn('users', 'course')) {
        $table->string('course')->nullable();
    }

    if (!Schema::hasColumn('users', 'school')) {
        $table->string('school')->nullable();
    }
});

        
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['studentid', 'course', 'school']);
        });
    }
};
