<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up(): void
	{
		Schema::create('orders', function (Blueprint $table) {
			$table->id();
			$table->string('slug')->comment("Chaîne de caractères utile à la navigation dans un navigateur");
			$table->string('number', 50)->comment("Numéro de la commande");
			$table->string('price', 10)->comment("Prix total de la commande");
			$table->string('payment_method', 10)->comment("Mode de paiement de la commande");
			$table->text('info')->nullable()->comment("Informations supplémentaires sur la commande");
			$table->foreignIdFor(Event::class)->comment("Identifiant de l’événement associé");
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('orders');
	}
};
