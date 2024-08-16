<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Identifiants d'accès à l'API de {{ env('APP_NAME') }}</title>
</head>
<body>
<p>Bonjour {{ $user->first_name }} {{ $user->last_name }},</p>

<p>Nous sommes heureux de vous informer que votre demande d'accès à l'API de {{ env('APP_NAME') }} a été approuvée.</p>

<p>Voici vos identifiants d'accès :</p>
<ul>
	<li><strong>Nom de la clé API :</strong> {{ $user->slug }}</li>
	<li><strong>Clé API :</strong> {{ $apiKey }}</li>
</ul>

<p>Pour utiliser notre API, vous devez inclure la clé API dans l'en-tête `Api-Key` de toutes vos requêtes. Voici un
	exemple de la manière dont vous pouvez le faire :</p>

<pre><code>curl -H "Api-Key: {{ $apiKey }}" https://api.example.com/endpoint</code></pre>

<p>Pour plus d'informations, veuillez consulter notre [documentation](https://www.example.com/documentation).
	Assurez-vous de protéger votre clé API et de ne pas la partager avec des tiers non autorisés.</p>

<p>Si vous avez des questions ou si vous avez besoin d'une assistance supplémentaire, n'hésitez pas à nous contacter à
	l'adresse suivante : <a href="mailto:support@{{ env('APP_NAME') }}.com"> {{ env('APP_SUPPORT_ADDRESS') }}</a>.</p>

<p>Merci pour votre confiance et bonne utilisation de notre API !</p>

<p>Cordialement,</p>
<p>L'équipe de {{ env('APP_NAME') }}</p>

</body>
</html>

