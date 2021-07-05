<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // unsignedBigInteger si usa per creare la colonna che diventerà foreign key che per convenzione avranno il nome della tabella di 
            // riferimento al singolare
            $table->unsignedBigInteger("user_id");
            // specifichiamo quale sarà la foreign key con il metodo foreign e associamola ad una colonna di riferimento
            // di una data tabella con reference e on
            $table->foreign("user_id")
                ->references("id")
                ->on("users");

            // si può utilizzare il metodo "rapido nel seguente modo: 
            // $table->foreignId("user_id")->constrained();
            // constrained si preoccuperà di associare la nostra foreign key alla tabella plurale con quel nome
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
            //nel down cancelliamo la relazione creata:
            $table->dropForeign("posts_user_id_foreign");
            
            //e cancelliamo la colonna foreign
            $table->dropColumn("user_id");

        });
    }
}
