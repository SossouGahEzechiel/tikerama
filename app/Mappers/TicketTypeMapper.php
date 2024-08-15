<?php

namespace App\Mappers;

use App\Models\TicketType;
use stdClass;

class TicketTypeMapper
{
	public stdClass $type;
	public int $count;

	public function __construct(TicketType $type, int $count)
	{
		$this->type = new stdClass();
		$this->type->id = $type->getAttribute('id');
		$this->type->slug = $type->getAttribute('slug');
		$this->type->name = $type->getAttribute('name');
		$this->type->price = $type->getAttribute('price');
		$this->count = $count;
	}

	public static function parse(array $content): iterable
	{
		return TicketType::query()->findMany(($content = collect($content))->pluck('typeId'), ['slug', 'name', 'id', 'price'])
			->map(function (TicketType $type, $key) use ($content) {
				return new self($type, $content->get($key)['count']);
			});
	}
}
