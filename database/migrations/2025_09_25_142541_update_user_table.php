<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $columns = [
        'first_name',
        'middle_name',
        'last_name',
        'student_id',
        'program',
        'year',
        'role',
        'status',
        'last_login',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add columns only if they don't already exist
        if (! Schema::hasColumn('users', 'first_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('first_name')->nullable()->after('id');
            });
        }

        if (! Schema::hasColumn('users', 'middle_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('middle_name')->nullable()->after('first_name');
            });
        }

        if (! Schema::hasColumn('users', 'last_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('last_name')->nullable()->after('middle_name');
            });
        }

        if (! Schema::hasColumn('users', 'student_id')) {
            Schema::table('users', function (Blueprint $table) {
                // Keep nullable for existing records — we'll add unique index later after cleanup if desired
                $table->string('student_id')->nullable()->after('name');
            });
        }

        if (! Schema::hasColumn('users', 'program')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('program')->nullable()->after('student_id');
            });
        }

        if (! Schema::hasColumn('users', 'year')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('year')->nullable()->after('program');
            });
        }

        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                // Use string for easier migration; you can enforce allowed values via app validation
                $table->string('role')->nullable()->default('Member')->after('year');
            });
        }

        if (! Schema::hasColumn('users', 'status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('status')->nullable()->default('active')->after('role');
            });
        }

        if (! Schema::hasColumn('users', 'last_login')) {
            Schema::table('users', function (Blueprint $table) {
                $table->date('last_login')->nullable()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Build a list of columns that actually exist, then drop them
        $toDrop = [];
        foreach ($this->columns as $col) {
            if (Schema::hasColumn('users', $col)) {
                $toDrop[] = $col;
            }
        }

        if (! empty($toDrop)) {
            Schema::table('users', function (Blueprint $table) use ($toDrop) {
                $table->dropColumn($toDrop);
            });
        }
    }
};
