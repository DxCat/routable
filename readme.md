#### :zap:Package Archived and Abandoned :zap:
This package is abandoned and no longer maintained. This package no longer have much value for the open source community
and it is severely outdated. I'm sorry for any inconveniences caused.




# Laravel 5 Routable
Simple laravel 5 routable models package

Creating a slugged model is not really that hard in laravel even without any package,
however when you have multiple models that need the same feature, it can get a bit spaghetti-ish, repeated and tedious.
If you have encountered this, this package will be perfect for you.

Using this package, any of your model can have their own route easily!

P/S : This package also have basic supports for multilingual route. I am planning to expand more this feature later.

## Installation 

Add it to your composer to json simply by running   
````bash
$ composer require askaoru/routable
````

Then add the service provider to your `config/app.php` under the providers array  
````php
'providers' => [
    // Other laravel packages ...
    
    Askaoru\Routable\RoutableServiceProvider::class,
],
````

Publish the config and migration
````bash
$ php artisan vendor:publish --provider="Askaoru\Routable\RoutableServiceProvider"
````
That will create 2 files which you can edit if you want to change the database name
````
config\routable.php
database\migrations\2017_01_28_041412_create_routes_table.php
````
Finally run
````bash
$ php artisan migrate
````

That's it!

## Usage

Attach the trait to any of your model which you want it to be routable
````php
<?php

namespace App;

use Askaoru\Routable\Traits\Routable; # Import the routable trait
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	use Routable; # Use the trait
    
  // Other codes
}

````

### Create route  
````php
$model->route()->make($url, $controller, $controller_parameter = [], $locale = null);
# $url = the url for this route, example 'post/awesome-first-post'
# $controller = controller method which will be called when the url is hit
# $controller_parameter = array of parameter that the controller need to accept, optional
# $locale = locale which the route is for, optional, will use the current app locale when it is not set

# Example
$post = Post::find(1); # Model item that was attached with the trait
$post->route()->make('post-title', 'App\Http\Controllers\PostController@view', [$post->id]);

# Will return the route object if created successfully, false if the url already exist

# Note : The controller need to be in full namespace with the method name, omit leading slash.
````

### Update route  
````php
$model->route()->change($url, $controller, $controller_parameter = [], $locale = null);
# Same parameters and requirements with the create method

# Example
$post = Post::find(1); # Model item that was attached with the trait
$post->route()->change('updated-post-title', 'App\Http\Controllers\PostController@view', [$post->id]);

# Will return false if no route was found, return the route object if updated successfully

# Note : The controller need to be in full namespace with the method name, omit leading slash.
````

### Delete route
````php
$model->route()->clear($locale = null);
# $locale = locale which the route is for, optional, will use the current app locale when it is not set

$post = Post::find(1); # Model item that was attached with the trait
$post->route()->clear(); # Will return false if model have no route, return true if deleted successfully
````

### Return route
````php
$model->route()->getUrl($locale = null);
$model->route()->getRoute($locale = null);
# $locale = locale which the route is for, optional, will use the current app locale when it is not set

# Example
$post = Post::find(1); # Model item that was attached with the trait
$post->route()->getUrl(); # Will return the full url, http://project.dev/post/awesome-first-post
$post->route()->getRoute(); # Will return the full route object
````

### Main Route
For the routing to work, you will need a main entry point with a catch all route.

So in your `app\Http\route.php` (or `routes\web.php` depending on your laravel version), insert
````php
Route::any('{any}', function ($any) {
	$routable = new \Askaoru\Routable\RoutableController;
	$exist = $routable->exist($any);

	if (! $exist) {
		abort(404); # If you want to handle the not found differently, replace here with your code
	}

	return $routable->go($any);
})->where('any', '.*');
````

#### Remember to put it as the last route entry or it may cause issue with your other route!!!





That's about it. If you have any question or suggestion, feel free to open an issue. Contributions and criticism will be appreciated!

Thank you.

