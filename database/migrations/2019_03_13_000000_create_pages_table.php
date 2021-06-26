<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use OptimistDigital\NovaPageManager\NovaPageManager;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            NovaPageManager::getPagesTableName(),
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('slug')->default('');
                $table->string('locale', 5);
                $table->string('template');
                $table->string('seo_title')->nullable();
                $table->text('seo_description')->nullable();
                $table->text('seo_image')->nullable();
                $table->foreignId('locale_parent_id')
                    ->nullable()
                    ->constrained(NovaPageManager::getPagesTableName())
                    ->onUpdate('cascade')
                    ->onDelete('set null');
                $table->foreignId('parent_id')
                    ->nullable()
                    ->constrained(NovaPageManager::getPagesTableName())
                    ->onUpdate('cascade')
                    ->onDelete('set null');
                $table->foreignId('draft_parent_id')
                    ->nullable()
                    ->constrained(NovaPageManager::getPagesTableName())
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->string('preview_token')->nullable();
                $table->boolean('published')->default(true);
                $table->json('data')->nullable();
                $table->timestamps();
                $table->unique(
                    ['locale_parent_id', 'locale', 'published'],
                    NovaPageManager::getPagesTableName() . '_locale_parent_id_locale_published_unique'
                );
                $table->unique(
                    ['locale', 'slug', 'published', 'parent_id'],
                    NovaPageManager::getPagesTableName() . '_locale_slug_published_parent_id_unique'
                );
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(NovaPageManager::getPagesTableName());
    }
}
