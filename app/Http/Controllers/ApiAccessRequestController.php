<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiAccessRequestValidator;
use App\Mail\ApiAccessCredentialMail;
use App\Models\ApiAccessRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

/**
 * Class ApiAccessRequestController
 *
 * Ce contrôleur gère les actions liées aux demandes d'accès à l'API.
 *
 * @package App\Http\Controllers
 */
class ApiAccessRequestController extends Controller
{
	/**
	 * Affiche la vue du formulaire de demande d'accès à l'API.
	 *
	 * Cette méthode retourne la vue associée à la création d'une demande d'accès à l'API.
	 *
	 * @return View
	 */
	public function create(): View
	{
		// Crée une nouvelle instance de ApiAccessRequest et la passe à la vue.
		return view('api-access.create')->with('apiAccessRequest', new ApiAccessRequest());
	}

	/**
	 * Traite le stockage d'une nouvelle demande d'accès à l'API.
	 *
	 * Cette méthode valide les données soumises, enregistre la demande dans la base de données,
	 * et envoie un email de confirmation à l'utilisateur avec ses informations d'accès.
	 *
	 * @param ApiAccessRequestValidator $request Les données validées de la requête.
	 *
	 * @return RedirectResponse Redirige l'utilisateur avec un message de succès.
	 */
	public function store(ApiAccessRequestValidator $request): RedirectResponse
	{
		// Crée une nouvelle entrée dans la base de données à partir des données validées.
		$user = ApiAccessRequest::query()->create($request->validated());

		// Envoie un email contenant les informations d'accès à l'utilisateur.
		// La méthode `dispatch()` envoie l'email après que la réponse a été renvoyée
		// pour ne pas perdre du temps à l'utilisateur si l'envoie du mail prenait du temps.
		dispatch(Mail::to($user)->send(new ApiAccessCredentialMail($user)))->afterResponse();

		// Redirige l'utilisateur vers la page précédente avec un message de succès.
		return back()->with('success', 'Votre demande a été envoyée avec succès.');
	}
}
