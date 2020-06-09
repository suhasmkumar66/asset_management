<?php

namespace App\Policies;

use App\Policies\AssetPermissionsPolicy;

class CompanyPolicy extends AssetPermissionsPolicy
{
    protected function columnName()
    {
        return 'companies';
    }
}
