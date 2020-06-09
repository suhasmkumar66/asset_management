<?php

namespace App\Policies;

use App\Policies\AssetPermissionsPolicy;

class AssetModelPolicy extends AssetPermissionsPolicy
{
    protected function columnName()
    {
        return 'models';
    }
}
