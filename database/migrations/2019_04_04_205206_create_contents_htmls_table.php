<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsHtmlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents_htmls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id')->unsigned()->nullable();
            $table->integer('content_html_tag_id')->unsigned();
            $table->integer('content_choice_id')->unsigned()->nullable();
            $table->string('label', 255)->nullable();
            $table->text('text')->nullable();
            $table->text('data')->nullable();
            $table->text('src', 255)->nullable();

            $table->timestamps();

            $table->foreign('content_choice_id')
            ->references('id')
            ->on('contents_choices')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('content_html_tag_id')
            ->references('id')
            ->on('contents_htmls_tags')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('content_id')
            ->references('id')
            ->on('contents')
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
        Schema::dropIfExists('contents_htmls');
    }
}
