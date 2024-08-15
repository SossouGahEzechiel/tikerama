<?php

namespace App\Models;

use App\Traits\Routing\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Intent extends Model
{
	use GenerateUniqueSlugTrait;

	public function hasSlugBaseKeyProvider(): bool
	{
		return false;
	}

	protected $guarded = [
		'slug',
		'created_at',
		'updated_at'
	];

	protected $casts = [
		'content' => 'json',
		'expiration_date' => 'datetime'
	];

	public function event(): BelongsTo
	{
		return $this->belongsTo(Event::class);
	}
}
