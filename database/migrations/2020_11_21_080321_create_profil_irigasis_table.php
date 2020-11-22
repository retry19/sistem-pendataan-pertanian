<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilIrigasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profil_irigasi', function (Blueprint $table) {
            $table->increments('id');
            $table->text('kondisi_umum');
            $table->text('sumber_air');
            $table->text('ketersediaan_air');
            $table->text('profil_sosial');
            $table->text('profil_teknik');
            $table->text('profil_kelembagaan');
            $table->text('kondisi_usahatani');
            $table->text('potensi_sumberdaya_lokal');
            $table->year('tahun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profil_irigasis');
    }
}
