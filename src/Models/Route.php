<?php

namespace Askaoru\Routable\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Route extends Eloquent
{
    /**
     * Property to save the caller class on.
     *
     * @var object
     */
    protected $caller;

    /**
     * The attributes that can be set with Mass Assignment.
     *
     * @var array
     */
    protected $fillable = ['url', 'controller', 'controller_parameters', 'model', 'model_id'];

    /**
     * Override the getTable() method to set the database from config.
     *
     * @var string
     */
    public function getTable()
    {
        return config('routable.database', 'routes');
    }

    /**
     * Save the calling class details.
     *
     * @param object $caller
     *
     * @return void
     */
    public function setCaller($caller)
    {
        $this->caller = $caller;
    }

    /**
     * Return the saved caller.
     *
     * @return object
     */
    public function getCaller()
    {
        return $this->caller;
    }

    /**
     * Return the model full route url.
     *
     * @return string
     */
    public function getUrl()
    {
        return url($this->getRoute()->url);
    }

    /**
     * Create a route for this model.
     *
     * @param  string $url
     * @param  string $controller
     * @param  array  $controller_parameters
     * 
     * @return self
     */
    public function make($url, $controller, $controller_parameters = [])
    {
        if ($this->getRoute($url)) {
            return false;
        }

        return self::create([
            'url'                   => $url,
            'controller'            => '\\'.$controller,
            'controller_parameters' => json_encode($controller_parameters),
            'model'                 => get_class($this->caller),
            'model_id'              => $this->caller->id,
        ]);
    }

    /**
     * Update the route for this model.
     *
     * @param  string $url
     * @param  string $controller
     * @param  array  $controller_parameters
     * 
     * @return self
     */
    public function change($url, $controller, $controller_parameters = [])
    {
        if ($route = $this->getRoute()) {
            $route->url = $url;
            $route->controller = $controller;
            $route->controller_parameters = json_encode($controller_parameters);
            $route->save();

            return $route;
        }

        return false;
    }


    /**
     * Delete a route for this model.
     *
     * @return bool
     */
    public function clear()
    {
        if ($route = $this->getRoute($url)) {
            $route->delete();

            return true;
        }

        return false;
    }

    /**
     * Return the existing route of the caller model.
     *
     * @return self
     */
    public function getRoute()
    {
        return $this->where('model', get_class($this->caller))
                    ->where('model_id', $this->caller->id);
                    ->first();
    }
}
