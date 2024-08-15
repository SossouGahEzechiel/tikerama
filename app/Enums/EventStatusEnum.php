<?php

namespace App\Enums;

use App\Traits\Enum\EnumValuesTrait;

enum EventStatusEnum: string
{

	use EnumValuesTrait;

	case UPCOMING = "À venir";

	case COMPLETED = "Terminé";

	case CANCELED = "Annulé";
}
