<?php

namespace App\Policies;

use App\Policies\AssetPermissionsPolicy;

class DepartmentPolicy extends AssetPermissionsPolicy
{
    protected function columnName()
    {
        return 'departments';
    }
}
