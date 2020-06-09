<?php

namespace App\Policies;

use App\Policies\AssetPermissionsPolicy;

class SupplierPolicy extends AssetPermissionsPolicy
{
    protected function columnName()
    {
        return 'suppliers';
    }
}
