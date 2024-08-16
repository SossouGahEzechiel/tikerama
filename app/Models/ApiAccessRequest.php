<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiAccessRequest extends Model
{
	protected $fillable = [
		'first_name',
		'last_name',
		'company',
		'email',
		'city',
		'address'
	];
}
