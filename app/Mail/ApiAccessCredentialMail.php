<?php

namespace App\Mail;

use App\Models\ApiAccessRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class ApiAccessCredentialMail extends Mailable
{
	use Queueable, SerializesModels;

	public string $apiKey;

	public function __construct(public readonly ApiAccessRequest $user)
	{
		$this->apiKey = Hash::make(env('APP_NAME'));
	}

	public function envelope(): Envelope
	{
		return new Envelope(
			subject: "Confirmation de la demande d'accès à l'API de " . env('APP_NAME'),
		);
	}

	public function content(): Content
	{
		return new Content(
			view: 'mails.api-access',
		);
	}
}
