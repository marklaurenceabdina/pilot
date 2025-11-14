<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('deadline');
            $table->integer('total_users');
            $table->integer('paid')->default(0);
            $table->integer('unpaid')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requirements');
    }
};