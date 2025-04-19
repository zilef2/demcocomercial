<?php

namespace App\helpers;

class MyModels {
    public static function getPermissionToNumber($permissions): int{
        
        if ($permissions === 'trabajador') return 1;// no reportan
        if ($permissions === 'supervisor') return 2;
        if ($permissions === 'admin') return 9;
        if ($permissions === 'superadmin') return 10;
        return 0;
    }
    public static function getPermissiToLog($permissions): string{
        
        if ($permissions === 'trabajador') return 'single';
        if ($permissions === 'supervisor') return 'supervisor';
        if ($permissions === 'admin') return 'soloadmin';
        if ($permissions === 'superadmin') return 'solosuper';
        return 'emergency';
    }
}
