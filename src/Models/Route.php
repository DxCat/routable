<?php

namespace Askaoru\Routable\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\App;

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
    protected $fillable = ['url', 'controller', 'controller_parameters', 'model', 'model_id', 'locale'];

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
    public function getUrl($locale = null)
    {
        return url($this->getRoute($locale)->url);
    }

    /**
     * Create a route for this model.
     *
     * @param string $url
     * @param string $controller
     * @param array  $controller_parameters
     *
     * @return self
     */
    public function make($url, $controller, $controller_parameters = [], $locale = null)
    {
        if ($this->checkUrlExist($url)) {
            return false;
        }

        return self::create([
            'url'                   => $url,
            'controller'            => '\\'.$controller,
            'controller_parameters' => json_encode($controller_parameters),
            'model'                 => get_class($this->caller),
            'model_id'              => $this->caller->id,
            'locale'                => $this->getLocale($locale),
        ]);
    }

    /**
     * Update the route for this model.
     *
     * @param string $url
     * @param string $controller
     * @param array  $controller_parameters
     *
     * @return self
     */
    public function change($url, $controller, $controller_parameters = [], $locale = null)
    {
        if ($route = $this->getRoute($locale)) {
            $route->url = $url;
            $route->controller = '\\'.$controller;
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
    public function clear($locale = null)
    {
        if ($route = $this->getRoute($locale)) {
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
    public function getRoute($locale = null)
    {
        $locale = $this->getLocale($locale);

        return $this->where('model', get_class($this->caller))
                    ->where('model_id', $this->caller->id)
                    ->where('locale', $locale)
                    ->first();
    }

    /**
     * Check whether the url already exist in the database.
     *
     * @param string $url
     *
     * @return bool
     */
    protected function checkUrlExist($url)
    {
        if ($this->where('url', $url)->first()) {
            return true;
        }

        return false;
    }

    /**
     * Return the locale if it's set, return default application locale if not set.
     *
     * @param string $locale
     *
     * @return string
     */
    protected function getLocale($locale)
    {
        return $locale ?: App::getLocale();
    }
}
