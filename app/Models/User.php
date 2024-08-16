<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Routing\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasFactory, HasApiTokens;
	use GenerateUniqueSlugTrait;

	public function hasSlugBaseKeyProvider(): bool
	{
		return false;
	}

	protected $fillable = [
		'firstname',
		'lastname',
		'email',
		'password',
		'phone'
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected function casts(): array
	{
		return [
			'email_verified_at' => 'datetime',
			'password' => 'hashed',
		];
	}

	public function orders(): HasMany
	{
		return $this->hasMany(Order::class);
	}
}
