<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionary_snapshots', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->longText('value');
            $table->integer('timestamp', false, true);
            $table->unsignedBigInteger('dictionary_id');
            $table->foreign('dictionary_id')->references('id')->on('dictionaries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionaries');
    }
}
