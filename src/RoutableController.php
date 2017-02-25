<?php

namespace Askaoru\Routable;

use Illuminate\Http\Request;
use Askaoru\Routable\Models\Route;
use App\Http\Controllers\Controller;

class RoutableController extends Controller
{	
	/**
	 * If the route exist, call the controller and attach the parameter
	 *
	 * @return Mixed [Any controller attached, or 404 if not found]
	 */
    public function go($currentRoute)
    {
    	$route = Route::where('url', $currentRoute)->first();

    	if ( ! $route ) {
    		abort(404);
    	}

    	$controller = explode('@', $route->controller);
    	$parameters = json_decode($route->controller_parameters);
    	$execute = app()->make($controller[0])->callAction($controller[1], $parameters);

    	return $execute;
    }

    /**
     * Determine if the route exist
     * 
     * @return Boolean
     */
    public function exist($currentRoute)
    {
    	$route = Route::where('url', $currentRoute)->first();

    	if ( ! $route ) {
    		return false;
    	}
    	
    	return true;
    }
}
