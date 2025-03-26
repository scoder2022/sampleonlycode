<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class SiteHelperFacade extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'SiteHelper';
    }
}
