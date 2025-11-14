<?php
// database/migrations/2024_01_01_000000_create_events_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('date');
            $table->time('time');
            $table->string('location');
            $table->integer('capacity');
            $table->string('category');
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->timestamps();
            $table->softDeletes(); // Added for safe deletion
        });

        // Create attendees table to track registrations
        Schema::create('attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('registered_at')->useCurrent();
            $table->enum('attendance_status', ['registered', 'attended', 'cancelled'])->default('registered');
            $table->timestamps();
            
            $table->unique(['event_id', 'user_id']); // Prevent duplicate registrations
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendees');
        Schema::dropIfExists('events');
    }
}