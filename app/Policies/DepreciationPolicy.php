<?php

namespace App\Policies;

use App\Policies\AssetPermissionsPolicy;

class DepreciationPolicy extends AssetPermissionsPolicy
{
    protected function columnName()
    {
        return 'depreciations';
    }
}
