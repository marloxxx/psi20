<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('code')->nullable(false);
            $table->integer('adults')->nullable(false);
            $table->integer('children')->nullable(false);
            $table->dateTime('check_in')->nullable(false);
            $table->dateTime('check_out')->nullable(false);
            $table->foreignId('homestay_id')->constrained('homestays');
            $table->decimal('total_price', 8, 2)->nullable(false);
            $table->string('status')->nullable(false)->default('pending')->comment('pending, booked, canceled');
            // $table->string('payment_status')->nullable(false)->default('pending');
            $table->string('payment_proof')->nullable();
            // $table->string('snap_token', 36)->nullable();
            $table->enum('payment_status', ['1', '2', '3', '4'])->comment('1: pending, 2: success, 3: failed, 4: expired')->default('1');
            $table->integer('rating')->nullable();
            $table->text('review')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
