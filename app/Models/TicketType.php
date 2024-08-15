<?php

namespace App\Models;

use App\Traits\Routing\GenerateUniqueSlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketType extends Model
{
	use HasFactory, GenerateUniqueSlugTrait;

	public $timestamps = false;

	protected $guarded = ['id', 'slug'];

	public function event(): BelongsTo
	{
		return $this->belongsTo(Event::class);
	}
}
