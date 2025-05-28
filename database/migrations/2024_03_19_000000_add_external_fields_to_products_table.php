<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('external_id')->nullable()->after('id');
            $table->foreignId('integration_id')->nullable()->after('user_id')->constrained()->onDelete('set null');
            $table->index('external_id');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['integration_id']);
            $table->dropColumn(['external_id', 'integration_id']);
        });
    }
}; 