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
        Schema::create('intel_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intel_location_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('category');
            $table->text('note');
            $table->string('driver_handle');
            $table->unsignedInteger('helpful_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intel_posts');
    }
};
