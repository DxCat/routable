<?php

namespace Askaoru\Routable\Tests\Models;

use Askaoru\Routable\Traits\Routable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Routable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'body'];
}
