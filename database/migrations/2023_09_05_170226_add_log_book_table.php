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
        Schema::create('logbook', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('residence_id');
            $table->unsignedBigInteger('service_id');
            $table->decimal('amount', 9,2);
            $table->text('description');
            $table->string('responsable',55);
            $table->foreign('residence_id')->references('id')->on('residences')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook');
    }
};
