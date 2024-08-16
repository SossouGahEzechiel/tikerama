<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ApiAccessRequestValidator
 *
 * Valide les données de la requête pour la demande d'accès à l'API.
 *
 * @package App\Http\Requests
 */
class ApiAccessRequestValidator extends FormRequest
{
	/**
	 * Autorise la requête.
	 *
	 * Cette méthode détermine si l'utilisateur est autorisé à faire cette requête.
	 * Ici, elle renvoie toujours `true`, ce qui signifie que tout utilisateur est autorisé.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		return true; // Autorise toutes les requêtes
	}

	/**
	 * Règles de validation de la requête.
	 *
	 * Cette méthode définit les règles de validation appliquées aux champs du formulaire.
	 *
	 * @return array Les règles de validation pour chaque champ.
	 */
	public function rules(): array
	{
		return [
			'cgu' => ['accepted'], // Le champ 'cgu' doit être accepté (checkbox cochée)
			'first_name' => ['required', 'string', 'max:255'], // Prénom requis, chaîne de caractères de 255 caractères max
			'last_name' => ['required', 'string', 'max:255'], // Nom requis, chaîne de caractères de 255 caractères max
			'company' => ['required', 'string', 'max:255'], // Entreprise requise, chaîne de caractères de 255 caractères max
			'email' => ['required', 'email', 'unique:api_access_requests,email'], // Email requis, doit être unique dans la table 'api_access_requests'
			'city' => ['required', 'string', 'max:255'], // Ville requise, chaîne de caractères de 255 caractères max
			'address' => ['required', 'string', 'max:255'], // Adresse requise, chaîne de caractères de 255 caractères max
		];
	}

	/**
	 * Attributs personnalisés pour les messages d'erreur.
	 *
	 * Cette méthode définit les noms des champs personnalisés qui apparaîtront dans les messages d'erreur.
	 * Cela rend les messages plus lisibles pour l'utilisateur.
	 *
	 * @return array
	 */
	public function attributes(): array
	{
		return [
			'first_name' => 'Votre prénom',
			'last_name' => 'Votre nom',
			'company' => 'Votre compagnie',
			'email' => 'Votre adresse email',
			'city' => 'Votre ville',
			'address' => 'Votre adresse',
		];
	}

	/**
	 * Messages d'erreur personnalisés.
	 *
	 * Cette méthode retourne les messages d'erreur personnalisés pour des règles spécifiques,
	 * notamment pour les erreurs de validation telles que l'email déjà utilisé ou la non-acceptation des CGU.
	 *
	 * @return array
	 */
	public function messages(): array
	{
		return [
			'email.unique' => "Votre compagnie semble avoir déjà reçu les identifiants d'accès à notre API.", // Message si l'email existe déjà
			'cgu.accepted' => "Vous devez accepter les conditions générales d'utilisation avant de soumettre le formulaire." // Message si les CGU ne sont pas acceptées
		];
	}
}
