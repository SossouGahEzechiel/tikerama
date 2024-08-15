<?php

namespace Database\Factories;

use App\Models\{TicketType};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory pour le modèle TicketType.
 * Cette classe est responsable de la génération de données factices pour les
 * instances de TicketType lors de l'exécution des tests ou des seeders.
 *
 * @extends Factory<TicketType>
 */
class TicketTypeFactory extends Factory
{
	/**
	 * Définit les valeurs factices pour les attributs du modèle TicketType.
	 *
	 * Cette méthode génère aléatoirement des valeurs pour les colonnes du modèle
	 * telles que 'name', 'quantity', 'price' et 'description'.
	 *
	 * @return array Un tableau associatif contenant les valeurs des attributs.
	 */
	public function definition(): array
	{
		return [
			'name' => $this->faker->word, // Génère un nom de type de ticket factice
			'quantity' => $this->faker->numberBetween(1, 10), // Génère une quantité de tickets entre 1 et 10
			'price' => $this->faker->randomElement([0, 2000, 5000, 7500, 10000, 25000, 50000, 85000]), // Génère un prix aléatoire parmi les valeurs spécifiées
			'description' => $this->faker->sentence, // Génère une description factice pour le type de ticket
		];
	}
}
