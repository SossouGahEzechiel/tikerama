<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up(): void
	{
		Schema::create('ticket_types', function (Blueprint $table) {
			$table->id();
			$table->string('slug')->comment("Chaîne de caractères utile à la navigation dans un navigateur");
			$table->string('name', 50)->comment("Nom du type de ticket, par exemple Grand Public, VIP, Premium, etc");
			$table->string('price', 10)->comment("Prix du type de ticket");
			$table->integer('quantity', unsigned: true)
				->comment("Quantité totale de tickets disponibles, tient compte des intentions de paiement");
			$table->mediumText('description')
				->comment("Description du type de ticket, par exemple : Place assise en première rangée, 1 boisson offerte");
			$table->foreignIdFor(Event::class)->comment("Identifiant de l’événement associé");
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('ticket_types');
	}
};
