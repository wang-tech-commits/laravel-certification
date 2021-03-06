<?php

namespace MrwangTc\UserCertification;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class UserCertification
{
    public static function routes(string $prefix = '')
    {
        Route::group([
            'namespace' => '\MrwangTc\UserCertification\Certification\Controller',
            'prefix'    => $prefix,
        ], function (Router $router) {
            $router->get('certification/personal', 'UserCertificationController@index');
            $router->post('certification/personal', 'UserCertificationController@store');
        });
    }
}
