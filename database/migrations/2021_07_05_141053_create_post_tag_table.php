<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            // $table->id();
            //creiamo le foreign key per post e tag e rendiamole chiavi primarie(togliamo id) perche è una tabella apposita per le ralazioni
            //(nomeTabella_referenza)
            $table->foreignId('post_id')->constrained();
            $table->foreignId('tag_id')->constrained();
            $table->primary(['post_id', 'tag_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tag');
    }
}
