<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoriesToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //aggiungiamo la foreign_key
            $table->unsignedBigInteger("category_id")->nullable();

            // con onDelete diciamo che se la categoria viene cancellata viene svuotato quel campo
            $table->foreign("category_id")->references("id")->on("categories")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign("post_category_id_foreign");
            $table->dropColumn("category_id");
        });
    }
}
