<?php

namespace App\Policies;

use App\Policies\AssetPermissionsPolicy;

class TicketPolicy extends AssetPermissionsPolicy
{
    protected function columnName()
    {
        return 'tickets';
    }
}
