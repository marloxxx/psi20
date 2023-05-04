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
        Schema::create('homestays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users');
            $table->string('name', 50)->nullable(false);
            $table->decimal('price', 8, 2)->nullable(false);
            $table->text('description')->nullable(false);
            $table->boolean('is_available')->nullable(false);
            $table->integer('capacity')->nullable(false);
            $table->string('address', 100)->nullable(false);
            $table->string('latitude', 50)->nullable(false);
            $table->string('longitude', 50)->nullable(false);
            $table->integer('views')->nullable(false)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homestays');
    }
};
