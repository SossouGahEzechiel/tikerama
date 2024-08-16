<?php

namespace App\Models;

use App\Traits\Routing\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Model;

class ApiAccessRequest extends Model
{
	use GenerateUniqueSlugTrait;

	public function hasSlugBaseKeyProvider(): bool
	{
		return false;
	}

	protected $fillable = [
		'first_name',
		'last_name',
		'company',
		'email',
		'city',
		'address',
		'api_key'
	];
}
