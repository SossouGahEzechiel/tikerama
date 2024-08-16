<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('api_access_requests', function (Blueprint $table) {
			$table->id();
			$table->string('first_name')->comment("Prénom du demandeur");
			$table->string('last_name')->comment("Nom du demandeur");
			$table->string('company')->comment("Compagnie du demandeur");
			$table->string('email')->unique()->comment("Adresse mail du demandeur");
			$table->string('city')->comment("Ville du demandeur");
			$table->string('address')->comment("Adresse du demandeur");
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('api_access_requests');
	}
};

