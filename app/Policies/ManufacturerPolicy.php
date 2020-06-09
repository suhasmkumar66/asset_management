<?php

namespace App\Policies;

use App\Policies\AssetPermissionsPolicy;

class ManufacturerPolicy extends AssetPermissionsPolicy
{
    protected function columnName()
    {
        return 'manufacturers';
    }
}
