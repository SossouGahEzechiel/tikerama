<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\{OrderResource, UserResource};
use App\Models\User;
use Illuminate\Http\{Request, Response};
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserApiController extends Controller
{
	public function register(Request $request): Response|UserResource
	{
		$attributes = [
			'email' => 'Votre adresse email',
			'password' => 'Votre mot de passe',
			'firstName' => 'Votre prénom',
			'lastName' => 'Votre nom',
			'phone' => 'Votre numéro de téléphone',
		];

		$messages = [
			'email.unique' => 'Cette adresse email est déjà prise'
		];

		$validator = validator($request->all(), [
			'lastName' => ['required'],
			'firstName' => ['required'],
			'phone' => ['required'],
			'email' => ['nullable', 'email', 'unique:users'],
			'password' => ['required', 'confirmed'],
		], $messages, $attributes);

		if ($validator->fails()) {
			return __422($validator->errors()->first());
		}

		try {

			/**
			 * @var User $user
			 */
			$user = User::query()->create([
				'firstname' => $request->input('firstName'),
				'lastname' => $request->input('lastName'),
				'phone' => $request->input('phone'),
				'email' => $request->input('email'),
				'password' => Hash::make($request->input('password')),
			]);

			$user->setAttribute('token', $user->createToken('auth-token')->plainTextToken);

		} catch (Throwable $exception) {
			return __500($exception->getMessage());
		}

		return new UserResource($user);
	}

	public function login(Request $request): Response|UserResource
	{
		$validator = validator($request->all(), [
			'email' => ['required', 'email'],
			'password' => ['required']
		]);

		if ($validator->fails()) {
			return response(trans('auth.failed'), 401);
		}

		try {
			/**
			 * @var User $user
			 */
			$user = User::query()->firstWhere('email', $request->input('email'));
			if (!$user or !Hash::check($request->input('password'), $user->getAttribute('password'))) {
				return response(trans('auth.failed'), 401);
			}

			$user->setAttribute('token', $user->createToken('auth-token')->plainTextToken);

		} catch (Throwable $exception) {
			return __500($exception->getMessage());
		}

		return new UserResource($user->load('department', 'church'));
	}

	public function myOrders(): AnonymousResourceCollection
	{
		return OrderResource::collection(request()->user()->orders);
	}
}
