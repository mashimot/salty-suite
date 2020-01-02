<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id')->unsigned();

            $table->string('columnName', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->tinyInteger('isPrimaryKey')->nullable();
            $table->tinyInteger('nullable')->nullable();
            $table->bigInteger('size')->nullable();

            $table->timestamps();

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
        Schema::dropIfExists('contents_tables');
    }
}
