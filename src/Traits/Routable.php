<?php

namespace Askaoru\Routable\Traits;

use Askaoru\Routable\Models\Route;

trait Routable
{
    /**
     * Route relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    protected function getRoute()
    {
        return $this->hasOne('Askaoru\Routable\Models\Route', 'model_id')->where('model', get_class($this));
    }

    /**
     * Return the model full route url.
     *
     * @return string
     */
    public function getRouteUrl()
    {
        return url($this->getRoute->url);
    }

    /**
     * Create a route for this model.
     *
     * @return bool
     */
    public function makeRoute($url, $controller, $controller_parameters = null)
    {
        if ($this->getRoute) {
            return false;
        }

        $route = Route::create([
            'url'                   => $url,
            'controller'            => '\\'.$controller,
            'controller_parameters' => json_encode($controller_parameters),
            'model'                 => get_class($this),
            'model_id'              => $this->id,
        ]);

        if (!$route) {
            return false;
        }

        return true;
    }

    /**
     * Update the route for this model.
     *
     * @return bool
     */
    public function updateRoute($url, $controller, $controller_parameters = null)
    {
        if (!$this->getRoute) {
            return false;
        }

        $route = $this->getRoute;
        $route->url = $url;
        $route->controller = $controller;
        $route->controller_parameters = json_encode($controller_parameters);
        $route->save();

        return true;
    }

    /**
     * Delete a route for this model.
     *
     * @return bool
     */
    public function deleteRoute()
    {
        if (!$this->getRoute) {
            return false;
        }

        $this->getRoute->delete();

        return true;
    }
}
