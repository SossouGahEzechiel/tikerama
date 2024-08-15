<?php

namespace App\Enums;

use App\Traits\Enum\EnumValuesTrait;

enum EventCategoryEnum: string
{
	use EnumValuesTrait;

	case OTHER = 'Autre';

	case CONCERT_SHOW = 'Concert-Spectacle';

	case DINNER_GALA = 'Diner Gala';

	case FESTIVAL = 'Festival';

	case TRAINING = 'Formation';
}
