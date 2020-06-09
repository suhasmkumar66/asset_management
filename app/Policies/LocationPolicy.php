<?php

namespace App\Policies;

use App\Policies\AssetPermissionsPolicy;

class LocationPolicy extends AssetPermissionsPolicy
{
    protected function columnName()
    {
        return 'locations';
    }
}
