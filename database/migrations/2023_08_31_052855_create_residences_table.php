<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('residences', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('residence_type_id')->unsigned();
            $table->foreign('residence_type_id')->references('id')->on('residence_types')->onDelete('cascade');
            // $table->bigInteger('location_id')->unsigned();
            // $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->bigInteger('village_id')->unsigned();
            $table->foreign('village_id')->references('id')->on('villages')->onDelete('cascade');
            $table->bigInteger('sector_id')->unsigned();
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade');
            $table->string('name');
            // $table->string('latitude');
            // $table->string('longitude');
            // $table->string('reference');
            // $table->string('residence_number');
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residences');
    }
};
