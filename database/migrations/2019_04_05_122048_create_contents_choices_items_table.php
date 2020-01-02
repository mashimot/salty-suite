<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsChoicesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents_choices_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_choice_id')->unsigned();
            $table->string('text', 255);
            $table->string('value', 255);
            $table->bigInteger('position')->nullable();

            $table->timestamps();

            $table->foreign('content_choice_id')
            ->references('id')
            ->on('contents_choices')
            ->onDelete('cascade')
            ->onUpdate('cascade');            
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents_choices_items');
    }
}
