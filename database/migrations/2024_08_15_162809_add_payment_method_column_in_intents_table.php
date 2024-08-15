<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up(): void
	{
		Schema::table('intents', function (Blueprint $table) {
			$table->string('payment_method', 10)->nullable()->comment("Mode de paiement de la commande");
			$table->dropColumn('code'); // J'ai retiré cette colonne parce que le slug suffira pour la recherche
		});
	}

	public function down(): void
	{
		Schema::table('intents', function (Blueprint $table) {
			$table->string('code')->nullable();
			$table->dropColumn('payment_method');
		});
	}
};
