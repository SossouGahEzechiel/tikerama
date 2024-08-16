<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up(): void
	{
		// Suppression de la table users pour l'intégration de nos nouvelles colonnes
		Schema::table('users', fn(Blueprint $table) => $table->drop());

		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('firstname')->comment("Prénoms mail de l'utilisateur");
			$table->string('lastname')->comment("Nom mail de l'utilisateur");
			$table->string('email')->unique()->comment("Adresse mail de l'utilisateur");
			$table->string('phone')->comment("Numéro de téléphone de l'utilisateur");
			$table->string('password')->comment("Mot de passe de l'utilisateur");
			$table->string('slug');
			$table->timestamps();
		});
	}

	public function down(): void
	{
	}
};
