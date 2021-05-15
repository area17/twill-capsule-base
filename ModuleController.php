<?php

namespace App\Twill\Base;

use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use A17\Twill\Http\Controllers\Admin\ModuleController as TwillModuleController;

class ModuleController extends TwillModuleController
{
    public function __construct(Application $app, Request $request)
    {
        parent::__construct($app, $request);

        $this->defaultOrders = [$this->titleColumnKey => 'asc'];
    }
}
