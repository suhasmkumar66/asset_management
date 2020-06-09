<?php

namespace App\Policies;

use App\Policies\AssetPermissionsPolicy;

class CustomFieldPolicy extends AssetPermissionsPolicy
{
    protected function columnName()
    {
        return 'customfields';
    }
}
