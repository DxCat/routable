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
        if ($route = Route::where('url', $currentRoute)->first()) {
            $controller = explode('@', $route->controller);
            $parameters = json_decode($route->controller_parameters);
            $execute = app()->make($controller[0])->callAction($controller[1], $parameters);

            return $execute;
        }

        return false;        
    }

    /**
     * Determine if the route exist.
     *
     * @return bool
     */
    public function exist($currentRoute)
    {
        if (Route::where('url', $currentRoute)->first()) {
            return true;
        }

        return false;
    }
}
