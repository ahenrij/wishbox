<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('message');
            $table->integer('user_id')->unsigned();
            $table->integer('wish_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->foreign('wish_id')->references('id')->on('wishes')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('comments_user_id_foreign');
            $table->dropForeign('comments_wish_id_foreign');
        });
        Schema::dropIfExists('comments');
    }
}
