<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('states', function (Blueprint $table) {
			$table->id();
            $table->string('state', 64);
            $table->string('state_code', 8);
            $table->string('irwin_state_code', 8)->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('states');
	}
};
