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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->text('description')->nullable();
			$table->decimal('price', 8, 2);
			$table->unsignedBigInteger('image_id')->nullable()->default(1);
			$table->unsignedBigInteger('category_id')->nullable()->default(1);
			$table->boolean('recommended')->default(false);
            $table->timestamps();
			
			$table->foreign('image_id')->references('id')->on('images')->onDelete('set null');
    		$table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
