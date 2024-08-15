<?php

namespace App\Traits\Routing;

trait ModelsSlugKeyTrait
{
	public function getRouteKeyName(): string
	{
		return 'slug';
	}

	public function getSlugBaseKeyName(): string
	{
		return "name";
	}

	public function hasSlugBaseKeyProvider(): bool
	{
		return true;
	}

	public function hasComplexSlug(): bool
	{
		return false;
	}
}
