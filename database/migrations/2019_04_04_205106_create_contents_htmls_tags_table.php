<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsHtmlsTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents_htmls_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('content_html_category_id')->unsigned();

            $table->timestamps();
            
            $table->foreign('content_html_category_id')
            ->references('id')
            ->on('contents_htmls_categories')
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
        Schema::dropIfExists('contents_htmls_tags');
    }
}
