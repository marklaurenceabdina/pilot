<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'student_id')) {
                $table->string('student_id')->unique()->nullable();
            }
            if (!Schema::hasColumn('users', 'program')) {
                $table->string('program')->nullable();
            }
            if (!Schema::hasColumn('users', 'year')) {
                $table->string('year')->nullable();
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('Member');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active');
            }
            if (!Schema::hasColumn('users', 'last_login')) {
                $table->date('last_login')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'student_id')) $table->dropColumn('student_id');
            if (Schema::hasColumn('users', 'program')) $table->dropColumn('program');
            if (Schema::hasColumn('users', 'year')) $table->dropColumn('year');
            if (Schema::hasColumn('users', 'role')) $table->dropColumn('role');
            if (Schema::hasColumn('users', 'status')) $table->dropColumn('status');
            if (Schema::hasColumn('users', 'last_login')) $table->dropColumn('last_login');
        });
    }
};
