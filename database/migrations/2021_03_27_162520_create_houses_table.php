<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('location');
            $table->string('coordenates');
            $table->double('rent', 8, 2);
            $table->integer('maxPeopleNum');
            $table->integer('roomsNum');
            $table->integer('area');
            $table->string('houseType');
            $table->string('spaceType');
            $table->string('description');
            $table->string('houseRules');
            $table->decimal('rating', $precision = 1, $scale = 1)->default(0); //0-5
            $table->integer('timesRated')->default(0);
            $table->date('dateAvailable');
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
        Schema::dropIfExists('houses');
    }
}
