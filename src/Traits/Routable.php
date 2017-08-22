<?php

namespace Askaoru\Routable\Traits;

use Askaoru\Routable\Models\Route;

trait Routable
{
    /**
     * Establish the link to the route class.
     *
     * @return \Askaoru\Routable\Models\Route
     */
    public function route()
    {
        $route_model = new Route();
        $route_model->setCaller($this);

        return $route_model;
    }
}
