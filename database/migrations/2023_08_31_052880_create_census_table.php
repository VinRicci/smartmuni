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
        Schema::create('census', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('residence_id')->unsigned();
            $table->foreign('residence_id')->references('id')->on('residences')->onDelete('cascade');
            $table->string('name');
            $table->date('date');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('census');
    }
};
