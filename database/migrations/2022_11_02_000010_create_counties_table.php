<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('counties', function (Blueprint $table) {
			$table->id();
            $table->string('state_code', 4);
            $table->string('county', 128);
            $table->bigInteger('state_id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('counties');
	}
};
