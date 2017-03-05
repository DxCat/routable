<?php

namespace Askaoru\Routable\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Askaoru\Routable\Traits\Routable;

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