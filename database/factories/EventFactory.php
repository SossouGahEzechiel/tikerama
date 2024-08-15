<?php

namespace Database\Factories;

use App\Enums\{EventCategoryEnum, EventStatusEnum};
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory pour le modèle Event.
 * Cette classe est responsable de la génération de données factices pour les
 * instances d'Event lors de l'exécution des tests ou des seeders.
 *
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
	/**
	 * Définit les valeurs factices pour les attributs du modèle Event.
	 *
	 * La méthode génère aléatoirement des valeurs pour les colonnes du modèle
	 * telles que 'category', 'image', 'city', 'status', 'title', 'description',
	 * 'address' et 'date'.
	 *
	 * @return array Un tableau associatif contenant les valeurs des attributs.
	 */
	public function definition(): array
	{
		return [
			'category' => fake()->randomElement(EventCategoryEnum::cases()), // Sélectionne aléatoirement une catégorie d'événement
			'image' => fake()->imageUrl(640, 480, 'events'), // Génère une URL d'image factice
			'city' => fake()->city, // Génère un nom de ville factice
			'status' => fake()->randomElement(EventStatusEnum::cases()), // Sélectionne aléatoirement un statut d'événement
			'title' => fake()->sentence, // Génère un titre factice
			'description' => fake()->paragraph, // Génère une description factice
			'address' => fake()->address, // Génère une adresse factice
			'date' => fake()->dateTimeBetween('-2 months', '+2 months'), // Génère une date entre deux mois avant et deux mois après la date actuelle
		];
	}

	/**
	 * Méthode pour générer le code de l'événement après sa création.
	 *
	 * Cette méthode appelle la fonction setCode() de l'événement après la création
	 * de celui-ci, ce qui permet de générer un code unique pour chaque événement.
	 *
	 * @return self
	 */
	public function generateCode(): self
	{
		return $this->afterCreating(fn(Event $event) => $event->setCode());
	}
}
