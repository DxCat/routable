<?php

namespace Askaoru\Routable\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Route extends Eloquent
{
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
}
