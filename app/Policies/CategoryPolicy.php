<?php

namespace App\Policies;

use App\Policies\AssetPermissionsPolicy;

class CategoryPolicy extends AssetPermissionsPolicy
{
    protected function columnName()
    {
        return 'categories';
    }
}
