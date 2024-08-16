<?php

namespace App\Mappers;

use App\Models\TicketType;
use stdClass;

/**
 * Mapper pour transformer les données des types de tickets en objets standard.
 */
class TicketTypeMapper
{
	public stdClass $type;
	public int $count;

	/**
	 * Crée une nouvelle instance de TicketTypeMapper.
	 *
	 * @param TicketType $type Le type de ticket à mapper.
	 * @param int $count Le nombre de tickets associés à ce type.
	 */
	public function __construct(TicketType $type, int $count)
	{
		$this->type = new stdClass();
		$this->type->id = $type->getAttribute('id'); // L'ID du type de ticket.
		$this->type->slug = $type->getAttribute('slug'); // Le slug unique du type de ticket.
		$this->type->name = $type->getAttribute('name'); // Le nom du type de ticket.
		$this->type->price = $type->getAttribute('price'); // Le prix du type de ticket.
		$this->count = $count; // Le nombre de tickets associés à ce type.
	}

	/**
	 * Transforme un tableau de données en une collection d'objets TicketTypeMapper.
	 *
	 * @param array $content Le tableau de données à mapper.
	 * @return iterable La collection d'objets TicketTypeMapper.
	 */
	public static function parse(array $content): iterable
	{
		return TicketType::query()->findMany(($content = collect($content))->pluck('typeId'), ['slug', 'name', 'id', 'price'])
			->map(function (TicketType $type, $key) use ($content) {
				return new self($type, $content->get($key)['count']);
			});
	}
}
