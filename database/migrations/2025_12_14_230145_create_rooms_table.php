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
        Schema::disableForeignKeyConstraints();
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('room_name', 255);
            $table->string('sku', 50)->nullable()->unique(); 
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);

            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
