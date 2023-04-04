<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('halls', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->string('address');
            $table->integer('rooms');
            $table->integer('chairs');
            $table->double('price');
            $table->float('hours');
            $table->integer('tables');
            $table->string('type');
            $table->integer('capacity');
            $table->boolean('available');
            $table->foreignId('person_id')->references('id')->on('users')->onDelete('cascade');
           // $table->foreign('person_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('halls');
    }
};
