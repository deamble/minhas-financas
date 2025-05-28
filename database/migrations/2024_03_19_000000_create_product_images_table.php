<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('external_id')->nullable();
            $table->string('url');
            $table->string('alt')->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->index('external_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_images');
    }
}; 