<?php

namespace Askaoru\Routable\Tests;

use Askaoru\Routable\Models\Route;
use Askaoru\Routable\Tests\Models\Post;

class RoutableModelTest extends TestCase
{
    /**
     * @var Askaoru\Routable\Tests\Models\Post
     */
    protected $post;

    /**
     * Set up the environtment for this test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->post = $this->faktory->create('post');
    }

    /**
     * Target : Make sure that the make() create the route and returns it correctly.
     * Condition : Url doesnt yet exist.
     */
    public function testMakeRoute()
    {
        $url = str_slug($this->post->title);
        $controller = 'Askaoru\Routable\Tests\Controller\PostController@view';
        $parameter = [$this->post->id];

        $route = $this->post->route()->make($url, $controller, $parameter);

        $this->assertEquals($url, $route->url);
        $this->assertEquals('\\'.$controller, $route->controller);
        $this->assertContains('1', $route->controller_parameters);
    }

    /**
     * Target : Make sure that the make() returns false.
     * Condition : Url already exist.
     */
    public function testFailedToMakeRoute()
    {
        $this->faktory->create('route');

        $url = str_slug($this->post->title);
        $controller = 'Askaoru\Routable\Tests\Controller\PostController@view';
        $parameter = [$this->post->id];

        $route = $this->post->route()->make($url, $controller, $parameter);
        $this->assertFalse($route);
    }

    /**
     * Target : Make sure that the getRoute returns the Askaoru\Routable\Models\Route object.
     * Condition : The route exist.
     */
    public function testReturnRoute()
    {
        $route = $this->faktory->create('route');

        $this->assertInstanceOf('Askaoru\Routable\Models\Route', $this->post->route()->getRoute());
    }

    /**
     * Target : Make sure that the getUrl() returns url string.
     * Condition : The route exist.
     */
    public function testReturnRouteUrl()
    {
        $route = $this->faktory->create('route');

        $this->assertStringEndsWith('post-title', $this->post->route()->getUrl());
    }

    /**
     * Target : Make sure that the change() updates and return the route correctly.
     * Condition : The route exist.
     */
    public function testUpdateRoute()
    {
        $route = $this->faktory->create('route');

        $newUrl = 'new-url';
        $newController = 'Askaoru\Routable\Tests\Controllers\NewController@view';
        $newParameter = [2];

        $changedRoute = $this->post->route()->change($newUrl, $newController, $newParameter);

        $this->assertEquals($newUrl, $changedRoute->url);
        $this->assertEquals('\\'.$newController, $changedRoute->controller);
        $this->assertContains('2', $changedRoute->controller_parameters);
    }

    /**
     * Target : Make sure that the change() returns false if $this->post doest have a route.
     * Condition : The route doesnt exist to $this->post.
     */
    public function testFailedToUpdateRoute()
    {
        $newUrl = 'new-url';
        $newController = 'Askaoru\Routable\Tests\Controllers\NewController@view';
        $newParameter = [2];

        $changedRoute = $this->post->route()->change($newUrl, $newController, $newParameter);

        $this->assertFalse($changedRoute);
    }

    /**
     * Target : Make sure that the clear() returns true.
     * Condition : The route exist.
     */
    public function testDeleteRoute()
    {
        $route = $this->faktory->create('route');

        $clear = $this->post->route()->clear();

        $this->assertTrue($clear);
    }

    /**
     * Target : Make sure that the clear() returns false.
     * Condition : The route doesnt exist.
     */
    public function testFailedToDeleteRoute()
    {
        $delete = $this->post->route()->clear();

        $this->assertFalse($delete);
    }
}