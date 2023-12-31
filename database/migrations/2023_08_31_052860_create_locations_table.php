<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('residence_id')->unsigned()->nullable();
            $table->foreign('residence_id')->references('id')->on('residences')->onDelete('cascade');
            // $table->string('name', 256)->nullable();
            $table->string('lat', 32)->nullable();
            $table->string('lng', 32)->nullable();
            $table->string('premise')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('formatted_address', 1024)->nullable();
            $table->text('description');
            $table->json('geojson')->nullable();
            $table->foreignId('state_id')->nullable()->constrained();
            $table->tinyInteger('processed')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('locations');
    }
};
