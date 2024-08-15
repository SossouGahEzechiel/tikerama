<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up(): void
	{
		Schema::table('ticket_types', function (Blueprint $table) {
			$table->string('real_quantity', 11)
				->comment("Quantité réelle de tickets disponibles, mise à jour une fois l’intention de paiement validée");
			$table->string('total_quantity')
				->comment("Quantité totale de tickets (incluant les tickets vendus et non encore vendus)");
		});
	}

	public function down(): void
	{
		Schema::table('ticket_types', function (Blueprint $table) {
			$table->dropColumn(['real_quantity', 'total_quantity']);
		});
	}
};
