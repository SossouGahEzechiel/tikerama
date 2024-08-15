<?php

namespace App\Mappers;

use App\Models\TicketType;

class TicketTypeMapper
{
	public TicketType $type;
	public int $count;

	public function __construct(int $id, int $count)
	{
		$this->type = TicketType::query()->find($id, ['slug', 'name']);
		$this->count = $count;
	}

	public static function parse(array $content): array
	{
		return collect($content)->map(fn($data) => new self($data['typeId'], $data['count']))->toArray();
	}
}
