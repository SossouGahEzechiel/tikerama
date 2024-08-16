<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	public function up(): void
	{
		Schema::table('api_access_requests', function (Blueprint $table) {
			$table->string('api_key', 60)->comment("Clé d'accès à l'Api fournie à cet utilisateur");
			$table->string('slug');
		});
	}

	public function down(): void
	{
		Schema::table('api_access_requests', function (Blueprint $table) {
			$table->dropColumn('api_key', 'slug');
		});
	}
};
