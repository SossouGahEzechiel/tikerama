<?php

use App\Enums\{EventCategoryEnum, EventStatusEnum};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up(): void
	{
		Schema::create('events', function (Blueprint $table) {
			$table->id();
			$table->string('slug')->comment("Chaîne de caractères utile à la navigation dans un navigateur");
			$table->enum('category', EventCategoryEnum::values())->comment(" Catégorie de l’événement");
			$table->string('title', 30)->comment("Titre de l’événement");
			$table->mediumText('description')->comment("Description textuelle de l’événement");
			$table->timestamp('date')->comment("Date de l’événement");
			$table->string('image', 200)->comment("URL de l’image principale de l’événement");
			$table->string('city', 100)->comment("Ville où se déroule l’événement");
			$table->string('address', 200)->comment("Adresse de l’événement");
			$table->enum('status', EventStatusEnum::values())->comment("Statut de l’événement");
			$table->string('code')->nullable()->comment("Code de l'évènement");
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('events');
	}
};
