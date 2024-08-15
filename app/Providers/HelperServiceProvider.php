<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Le HelperServiceProvider est responsable du chargement de toutes mes fonctions
 * d'assistance définies au sein de l'application. Il enregistre automatiquement
 * tous les fichiers d'assistance situés dans le répertoire "app/Helpers",
 * me rendant leurs fonctions accessibles globalement à travers l'application.
 *
 * @package Tikerama-Test
 * @author SOSSOU-GAH Ézéchiel
 * @created 2024-07-10
 */
class HelperServiceProvider extends ServiceProvider
{
	/**
	 * Enregistre tous mes fichiers d'assistance au sein de l'application.
	 *
	 * Cette méthode charge tous mes fichiers PHP situés dans le répertoire `app/Helpers`
	 * et rend leurs fonctions disponibles pour une utilisation globale. Elle utilise la
	 * fonction `glob` pour parcourir chaque fichier d'assistance et les inclut
	 * automatiquement dans le contexte de l'application.
	 *
	 * @return void
	 */
	public function register(): void
	{
		foreach (glob(app_path('Helpers/*.php')) as $helper) {
			require_once $helper;
		}
	}
}
