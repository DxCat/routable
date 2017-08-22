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
     * Target : Make sure that the route() returns an instance of Askaoru\Translatable\Models\Route.
     * Target 2 : The returned instance must have a caller property which is an instance of the original class.
     */
    public function testTraitConnection()
    {
        $this->assertInstanceOf('Askaoru\Routable\Models\Route', $this->post->route());
        $this->assertInstanceOf('Askaoru\Routable\Tests\Models\Post', $this->post->route()->getCaller());
    }
}
