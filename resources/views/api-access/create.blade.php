<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ env('APP_NAME') }} - Demande d'accès à l'API</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			background: linear-gradient(to right, #061161, #780206);
			color: white;
			min-height: 100vh;
			display: flex;
			flex-direction: column;
			font-family: Raleway;
		}

		.navbar {
			background-color: #e7e8ef;
			padding: 1rem;
		}

		.form-container {
			background-color: rgba(255, 255, 255, 0.9);
			border-radius: 8px;
			padding: 2rem;
			max-width: 800px;
			margin: 2rem auto;
			color: #333;
		}

		.form-container h1 {
			margin-bottom: 1.5rem;
			color: #061161;
		}
	</style>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway&amp;display=swap">
</head>
<body>

<nav class="navbar navbar-dark">
	<div class="container-fluid">
		<a class="navbar-brand" href="#">
			<img src="https://www.tikerama.com/assets/img/brand/logo-tikerama.png" alt="Logo" width="120"
					 class="d-inline-block align-text-top">
		</a>
	</div>
</nav>

<div class="px-3 mt-lg-3">
	<div class="form-container container mt-5">
		<h1 class="text-center">Demande d'accès à l'API</h1>
		@if(session()->has('success'))
			<div class="alert alert-success" role="alert">
				Merci pour votre intérêt, vous recevrez un mail contenant les identifiants sous peu.
			</div>
		@endif
		<form method="POST" action="{{ route('api-access.store') }}" class="mt-4">
			@csrf
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="first_name" class="form-label">Prénom</label>
					<input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}"
								 required>
					@error('first_name')
					<small class="text-danger">{{ $message }}</small>
					@enderror
				</div>
				<div class="col-md-6 mb-3">
					<label for="last_name" class="form-label">Nom</label>
					<input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}"
								 required>
					@error('last_name')
					<small class="text-danger">{{ $message }}</small>
					@enderror
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="company" class="form-label">Entreprise</label>
					<input type="text" class="form-control" id="company" name="company" value="{{ old('company') }}" required>
					@error('company')
					<small class="text-danger">{{ $message }}</small>
					@enderror
				</div>
				<div class="col-md-6 mb-3">
					<label for="email" class="form-label">Adresse email</label>
					<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
					@error('email')
					<small class="text-danger">{{ $message }}</small>
					@enderror
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="city" class="form-label">Ville</label>
					<input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
					@error('city')
					<small class="text-danger">{{ $message }}</small>
					@enderror
				</div>
				<div class="col-md-6 mb-3">
					<label for="address" class="form-label">Adresse</label>
					<input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
					@error('address')
					<small class="text-danger">{{ $message }}</small>
					@enderror
				</div>
			</div>
			<div class="text-sm text-center my-2">
				<input type="checkbox" name="cgu" id="cgu" class="form-check-input" @checked(old('cgu'))>
				<label for="cgu">
					Oui, j'ai lu et accepté les <a href="javascript:void(0);" target="_blank">conditions générales
						d'utilisation</a> de l'API de {{ env('APP_NAME') }}
				</label>
			</div>
			<button type="submit" class="btn btn-primary w-100">Envoyer la demande</button>
		</form>
	</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>
	let notyf = new Notyf({
		position: {
			x: "right",
			y: "top"
		},
		duration: 10000
	});

	@if($errors->any())
	notyf.error('{{ $errors->first() }}');
	@endif

	@if(session()->has('success'))
	notyf.success('{{ session()->pull('success') }}');
	@endif

	document.addEventListener('DOMContentLoaded', function () {

		const form = document.querySelector('form');
		const checkbox = document.getElementById('cgu');

		form.addEventListener('submit', function (event) {
			if (!checkbox.checked) {
				event.preventDefault();
				notyf.error("Vous devez accepter les conditions générales d'utilisation avant de soumettre le formulaire.");
			}
		});
	});
</script>

</body>
</html>
