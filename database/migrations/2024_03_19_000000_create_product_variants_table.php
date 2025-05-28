<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('external_id')->nullable();
            $table->string('name');
            $table->string('sku')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->json('attributes')->nullable();
            $table->timestamps();

            $table->index('external_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}; 