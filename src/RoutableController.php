<?php

namespace Askaoru\Routable;

use Askaoru\Routable\Models\Route;
use Illuminate\Routing\Controller;

class RoutableController extends Controller
{
    /**
     * If the route exist, call the controller and attach the parameter.
     *
     * @return mixed
     */
    public function go($currentRoute)
    {
        $route = Route::where('url', $currentRoute)->first();

        if (!$route) {
            return false;
        }

        $controller = explode('@', $route->controller);
        $parameters = json_decode($route->controller_parameters);
        $execute = app()->make($controller[0])->callAction($controller[1], $parameters);

        return $execute;
    }

    /**
     * Determine if the route exist.
     *
     * @return bool
     */
    public function exist($currentRoute)
    {
        $route = Route::where('url', $currentRoute)->first();

        if (!$route) {
            return false;
        }

        return true;
    }
}
