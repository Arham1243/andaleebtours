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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('destination_name');
            $table->string('origin_code')->default('DXB');
            $table->string('destination_code');
            $table->string('image');
            $table->string('badge')->nullable();
            $table->string('departure_date')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('class')->default('Economy');
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
