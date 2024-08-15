<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up(): void
	{
		Schema::table('orders', function (Blueprint $table) {
			$table->string('author_email', 100)->comment("Email de l’utilisateur");
			$table->string('author_phone', 20)->comment("Téléphone de l’utilisateur");
		});
	}

	public function down(): void
	{
		Schema::table('orders', function (Blueprint $table) {
			$table->dropColumn('author_phone', 'author_email');
		});
	}
};
