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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homestay_id')->nullable()->constrained('homestays');
            $table->foreignId('event_id')->nullable()->constrained('events');
            $table->string('name', 50)->nullable(false);
            $table->integer('size')->nullable(false);
            $table->string('image_path', 255)->nullable(false);
            $table->boolean('is_primary')->nullable(false)->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
