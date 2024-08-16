<?php

namespace App\Models;

use App\Traits\Routing\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Modèle représentant un utilisateur de l'application.
 * Ce modèle utilise le trait pour générer des slugs uniques
 * et gère les tokens d'API via Sanctum.
 */
class User extends Authenticatable
{
	use HasFactory, HasApiTokens;
	use GenerateUniqueSlugTrait;

	/**
	 * Indique si ce modèle utilise une certaine colonne pour générer des slugs uniques.
	 *
	 * @return bool Retourne false pour ne pas utiliser une quelconque colonne pour les slugs.
	 */
	public function hasSlugBaseKeyProvider(): bool
	{
		return false;
	}

	/**
	 * Les attributs qui peuvent être assignés en masse.
	 *
	 * @var array
	 */
	protected $fillable = [
		'firstname', // Prénom de l'utilisateur
		'lastname',  // Nom de famille de l'utilisateur
		'email',     // Adresse email de l'utilisateur
		'password',  // Mot de passe de l'utilisateur (haché)
		'phone'      // Numéro de téléphone de l'utilisateur
	];

	/**
	 * Relation "one-to-many" avec le modèle Order.
	 * Un utilisateur peut avoir plusieurs commandes.
	 *
	 * @return HasMany
	 */
	public function orders(): HasMany
	{
		return $this->hasMany(Order::class);
	}
}
