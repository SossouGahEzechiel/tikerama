<?php

namespace App\Mail;

use App\Models\ApiAccessRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

/**
 * Class ApiAccessCredentialMail
 *
 * Cette classe représente le mail envoyé à un utilisateur après qu'il a fait une demande d'accès à l'API.
 * Elle contient la clé API générée et les informations de l'utilisateur.
 *
 * @package App\Mail
 */
class ApiAccessCredentialMail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * La clé API générée pour l'utilisateur.
	 *
	 * @var string
	 */
	public string $apiKey;

	/**
	 * Crée une nouvelle instance de la classe ApiAccessCredentialMail.
	 *
	 * Le constructeur génère une clé API en utilisant un hash du nom de l'application.
	 * Il accepte également une instance de `ApiAccessRequest` représentant les informations de l'utilisateur.
	 *
	 * @param ApiAccessRequest $user L'utilisateur ayant demandé l'accès à l'API.
	 */
	public function __construct(public readonly ApiAccessRequest $user, string $apiKey)
	{
		// Génération de la clé API en utilisant un hash du nom de l'application
		$this->apiKey = Hash::make($apiKey);
	}

	/**
	 * Définir l'enveloppe du mail.
	 *
	 * Cette méthode configure l'objet enveloppe, incluant le sujet du mail.
	 *
	 * @return Envelope
	 */
	public function envelope(): Envelope
	{
		return new Envelope(
			subject: "Confirmation de la demande d'accès à l'API de " . env('APP_NAME'), // Sujet du mail
		);
	}

	/**
	 * Définir le contenu du mail.
	 *
	 * Cette méthode configure le contenu du mail, incluant la vue utilisée pour le corps du mail.
	 *
	 * @return Content
	 */
	public function content(): Content
	{
		return new Content(
			view: 'mails.api-access', // Vue Blade pour le contenu du mail
		);
	}
}
