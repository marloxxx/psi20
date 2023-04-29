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
        Schema::create('homestay_has_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homestay_id')->constrained('homestays');
            $table->foreignId('facility_id')->constrained('facilities');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homestay_has_facilitiys');
    }
};
