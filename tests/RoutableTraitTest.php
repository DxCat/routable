<?php

namespace Askaoru\Routable\Tests;

use Askaoru\Routable\Models\Route;
use Askaoru\Routable\Tests\Models\Post;

class RoutableTraitTest extends TestCase
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
     * Target : Make sure that the makeRoute() returns true.
     * Condition : $this->post does not already contains a route.
     */
    public function testMakeRoute()
    {
    	$route = $this->post->makeRoute($this->post->title, 'Askaoru\Routable\Tests\Controllers\PostController@view', [$this->post->id]);

    	$this->assertTrue($route);
    }

    /**
     * Target : Make sure that the makeRoute() returns false.
     * Condition : $this->post already contains a route.
     */
    public function testFailedToMakeRoute()
    {
    	$route = $this->faktory->build('route');
        $this->post->getRoute()->save($route);

    	$route = $this->post->makeRoute($this->post->title, 'Askaoru\Routable\Tests\Controllers\PostController@view', [$this->post->id]);

    	$this->assertFalse($route);
    }

    /**
     * Target : Make sure that the getRoute returns the Askaoru\Routable\Models\Route object.
     * Condition : The route exist.
     */
    public function testReturnRoute()
    {		
        $route = $this->faktory->build('route');
        $this->post->getRoute()->save($route);

    	$this->assertNotNull($this->post->getRoute);
    }

    /**
     * Target : Make sure that the getRouteUrl() returns url string.
     * Condition : The route exist.
     */
    public function testReturnRouteUrl()
    {		
        $route = $this->faktory->build('route');
        $this->post->getRoute()->save($route);

    	$this->assertStringEndsWith('post-title', $this->post->getRouteUrl());
    }

    /**
     * Target : Make sure that the getRoute returns the Askaoru\Routable\Models\Route object.
     * Condition : The route exist.
     */
    public function testUpdateRoute()
    {		
        $route = $this->faktory->build('route');
        $this->post->getRoute()->save($route);
        $updatedRoute = $this->post->updateRoute('new-url', 'Askaoru\Routable\Tests\Controllers\NewController@view', [$this->post->id]);

    	$this->assertTrue($updatedRoute);
    }

    /**
     * Target : Make sure that the getRoute returns the Askaoru\Routable\Models\Route object.
     * Condition : The route exist.
     */
    public function testFailedToUpdateRoute()
    {		
        $route = $this->post->updateRoute('new-url', 'Askaoru\Routable\Tests\Controllers\NewController@view', [$this->post->id]);

    	$this->assertFalse($route);
    }

    /**
     * Target : Make sure that the deleteRoute() returns true.
     * Condition : The route exist.
     */
    public function testDeleteRoute()
    {	
        $route = $this->faktory->build('route');
        $this->post->getRoute()->save($route);

        $delete = $this->post->deleteRoute();

    	$this->assertTrue($delete);
    }

    /**
     * Target : Make sure that the deleteRoute() returns false.
     * Condition : The route doesnt exist.
     */
    public function testFailedToDeleteRoute()
    {	
        $delete = $this->post->deleteRoute();

    	$this->assertFalse($delete);
    }
}