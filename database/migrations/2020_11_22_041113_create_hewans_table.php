<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHewansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hewan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 14);
        });

        DB::table('hewan')->insert([
            ['nama' => 'Sapi Potong'],
            ['nama' => 'Kerbau'],
            ['nama' => 'Kambing'],
            ['nama' => 'Domba'],
            ['nama' => 'Kuda'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hewan');
    }
}
