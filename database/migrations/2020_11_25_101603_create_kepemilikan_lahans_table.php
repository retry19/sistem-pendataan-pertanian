<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKepemilikanLahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepemilikan_lahan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('blok', 32);
            $table->string('pemilik', 32);
            $table->decimal('luas_sawah');
            $table->decimal('luas_rencana');
            $table->string('alamat');
            $table->year('tahun');
            $table->unsignedInteger('kelompok_tani_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('kuartal_id')->index();

            $table->foreign('kelompok_tani_id')
                ->references('id')->on('kelompok_tani')
                ->onDelete('cascade');
 
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
 
            $table->foreign('kuartal_id')
                ->references('id')->on('quarters')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kepemilikan_lahan');
    }
}
