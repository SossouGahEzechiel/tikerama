<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up(): void
	{
		Schema::create('intents', function (Blueprint $table) {
			$table->id();
			$table->string('slug')->comment("Chaîne de caractères utile à la navigation dans un navigateur");
			$table->string('code')->nullable()->comment("Code de recherche d'une intention pour sa finalisation");
			$table->string('price', 10)->comment('Prix total de l’intention de commande');
			$table->string('author_email', 100)->comment("Email de l’utilisateur");
			$table->string('author_phone', 20)->comment("Téléphone de l’utilisateur");
			$table->timestamp('expiration_date')
				->default(now()->addMinutes(30))
				->comment("Date d’expiration de l’intention de commande, soit, 30 minutes après sa création");
			$table->json('content')
				->comment("Tableau associatif contenant l'id des types de tickets et leur nombre que l'utilisateur voudrait commander");
			$table->foreignIdFor(Event::class)->comment("Colonne permettant de voir les intentions de commandes d'un évènement");
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('intents');
	}
};
