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
        Schema::create('intel_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->boolean('is_open')->default(true);
            $table->decimal('rating', 2, 1)->nullable();
            $table->string('bathroom_code')->nullable();
            $table->timestamp('code_verified_at')->nullable();
            $table->decimal('distance_km', 5, 1)->nullable();
            $table->string('pin_category')->nullable();
            $table->unsignedSmallInteger('map_x')->nullable();
            $table->unsignedSmallInteger('map_y')->nullable();
            $table->json('tags');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intel_locations');
    }
};
