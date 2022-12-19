<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSearchExcludeColumnToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->integer('search_exclude')->nullable()->after('decorators');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->integer('search_exclude')->nullable()->after('decorators');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->integer('search_exclude')->nullable()->after('decorators');
        });

        Schema::table('static_pages', function (Blueprint $table) {
            $table->integer('search_exclude')->nullable()->after('attributes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('search_exclude');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('search_exclude');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('search_exclude');
        });

        Schema::table('static_pages', function (Blueprint $table) {
            $table->dropColumn('search_exclude');
        });
    }
}
