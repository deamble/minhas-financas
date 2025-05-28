<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('integrations')) {
            if (!Schema::hasColumn('integrations', 'settings')) {
                Schema::table('integrations', function (Blueprint $table) {
                    $table->json('settings')->nullable()->after('api_secret');
                });
            }
        } else {
            Schema::create('integrations', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('platform');
                $table->string('api_key');
                $table->string('api_secret');
                $table->json('settings')->nullable();
                $table->boolean('status')->default(true);
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('integrations')) {
            if (Schema::hasColumn('integrations', 'settings')) {
                Schema::table('integrations', function (Blueprint $table) {
                    $table->dropColumn('settings');
                });
            }
        }
    }
}; 