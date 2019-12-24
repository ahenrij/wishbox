<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wish_boxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('deadline');
            $table->enum('visibility', visibilities);
            $table->enum('type', wish_types);
            $table->integer('user_id')->unsigned()->comment('wish box\'s owner');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::table('wish_boxes', function (Blueprint $table) {
            $table->dropForeign('wish_boxes_user_id_foreign');
        });
        Schema::dropIfExists('wish_boxes');
    }
}
