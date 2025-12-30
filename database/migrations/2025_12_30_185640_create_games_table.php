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
    Schema::create('games', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique(); 
        
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

        $table->text('description')->nullable(); 
        $table->decimal('price', 15, 0)->default(0); 
        
        $table->string('image')->nullable();
        
        $table->string('download_link')->nullable(); 
        
        $table->integer('sold_count')->default(0);
        $table->boolean('is_active')->default(true);
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
