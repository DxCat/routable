<?php

namespace Askaoru\Routable\Tests;

use Askaoru\Routable\RoutableController;

class RoutableControllerTest extends TestCase
{
    /**
     * @var Askaoru\Routable\Tests\Models\Post
     */
    protected $post;

    /**
     * @var Askaoru\Routable\Models\Route
     */
    protected $route;

    /**
     * @var Askaoru\Routable\RoutableController
     */
    protected $routable;

    /**
     * Set up the environtment for this test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->post = $this->faktory->create('post');
        $this->route = $this->faktory->create('route');

        $this->routable = new RoutableController();
    }

    /**
     * Target : Make sure that the makeRoute() returns true.
     * Condition : The route exist.
     */
    public function testRouteExist()
    {
        $exist = $this->routable->exist('post-title');

        $this->assertTrue($exist);
    }

    /**
     * Target : Make sure that the makeRoute() returns false.
     * Condition : The route do not exist.
     */
    public function testRouteNotExist()
    {
        $exist = $this->routable->exist('post-title-none-existing');

        $this->assertFalse($exist);
    }

    /**
     * Target : Make sure that go() returns true.
     * Condition : The route exist.
     */
    public function testExecuteController()
    {
        $this->assertTrue($this->routable->go('post-title'));
    }

    /**
     * Target : Make sure that the go() returns false.
     * Condition : The route do not exist.
     */
    public function testFailedToExecuteController()
    {
        $this->assertFalse($this->routable->go('post-title-none-existing'));
    }
}
