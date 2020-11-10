<?php

namespace MrwangTc\UserCertification;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class UserCertification
{
    public static function routes(string $prefix = '')
    {
        Route::group([
            'namespace' => '\MrwangTc\UserCertification\UserCertification\Controller',
            'prefix'    => $prefix,
        ], function (Router $router) {
            $router->post('usercertification', 'UserCertificationController@store');
        });
    }
}
