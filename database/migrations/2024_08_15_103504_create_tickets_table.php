<?php

use App\Enums\TicketStatusEnum;
use App\Models\{Event, Order, TicketType};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up(): void
	{
		Schema::create('tickets', function (Blueprint $table) {
			$table->id();
			$table->string('email', 100)->comment("Email du détenteur du ticket");
			$table->string('phone', 20)->comment("Téléphone du détenteur du ticket");
			$table->string('price', 10)->comment(" Prix du ticket");
			$table->string('key', 100)->comment("Clé unique du ticket");
			$table->enum('status', TicketStatusEnum::values())->comment("Statut du ticket");
			$table->foreignIdFor(TicketType::class)->comment("Identifiant du type de ticket");
			$table->foreignIdFor(Event::class)->comment("Identifiant de l’événement associé");
			$table->foreignIdFor(Order::class)->comment("Identifiant de la commande associée");
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('tickets');
	}
};
