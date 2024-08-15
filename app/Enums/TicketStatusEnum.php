<?php

namespace App\Enums;

use App\Traits\Enum\EnumValuesTrait;

enum TicketStatusEnum: string
{
	use EnumValuesTrait;

	case ACTIVE = 'Actif';

	case VALIDATED = 'Validé';

	case EXPIRED = 'Expiré';

	case CANCELLED = 'Annulé';
}
