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
        Schema::create('responsibles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('residence_id')->unsigned()->nullable();
            $table->foreign('residence_id')->references('id')->on('residences')->onDelete('cascade');
            $table->string('dpi');
            $table->enum('gender', ['male', 'female']);
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('birthday')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsibles');
    }
};
