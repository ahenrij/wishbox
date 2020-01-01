<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->string('link');
            $table->string('filename');
            $table->enum('priority', array_keys(wish_priorities));
            $table->integer('status')->unsigned()->comment('0 : just created ; 1 => Someone proposed to give ; 2 => gift is received');
            $table->integer('user_id')->unsigned()->comment('giver or receiver')->nullable();
            $table->integer('wish_box_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreign('wish_box_id')->references('id')->on('wish_boxes')
                ->onUpdate('restrict')
                ->onDelete('restrict');

            $table->foreign('category_id')->references('id')->on('categories')
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
        Schema::table('wishes', function (Blueprint $table) {
           $table->dropForeign('wishes_user_id_foreign');
           $table->dropForeign('wishes_wish_box_id_foreign');
           $table->dropForeign('wishes_category_id_foreign');
        });
        Schema::dropIfExists('wishes');
    }
}
