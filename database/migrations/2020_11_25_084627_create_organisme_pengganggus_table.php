<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganismePengganggusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisme_pengganggu', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tanaman_id')->index();
            $table->string('bencana', 30);
            $table->integer('luas_serangan');
            $table->string('upaya');
            $table->year('tahun');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('kuartal_id')->index();

            // $table->foreign('tanaman_id')
            //     ->references('id')->on('tanaman')
            //     ->onDelete('cascade');
 
            // $table->foreign('user_id')
            //     ->references('id')->on('users')
            //     ->onDelete('set null');
 
            // $table->foreign('kuartal_id')
            //     ->references('id')->on('quarters')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organisme_pengganggu');
    }
}
