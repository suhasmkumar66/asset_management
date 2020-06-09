<?php

namespace App\Policies;

use App\Policies\AssetPermissionsPolicy;

class StatuslabelPolicy extends AssetPermissionsPolicy
{
    protected function columnName()
    {
        return 'statuslabels';
    }
}
