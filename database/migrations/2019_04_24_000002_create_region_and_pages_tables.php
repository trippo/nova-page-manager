<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use OptimistDigital\NovaPageManager\NovaPageManager;

class CreateRegionAndPagesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create regions table
        Schema::create(NovaPageManager::getRegionsTableName(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('locale');
            $table->string('template');
            $table->bigInteger('locale_parent_id')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();

            $table->unique(['locale', 'template'], 'nova_page_manager_locale_template');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(NovaPageManager::getRegionsTableName());
    }
}
