<?php

namespace App\Policies;

use App\Policies\AssetPermissionsPolicy;

class UserPolicy extends AssetPermissionsPolicy
{
    protected function columnName()
    {
        return 'users';
    }
}
