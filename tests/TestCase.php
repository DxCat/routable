<?php

namespace Askaoru\Routable\Tests;

use AdamWathan\Faktory\Faktory;
use Illuminate\Database\Capsule\Manager as DB;
use Orchestra\Testbench\TestCase as OrchestraTest;

class TestCase extends OrchestraTest
{
    /**
     * @var \AdamWathan\Faktory\Faktory
     */
    protected $faktory;

    /**
     * Set up the environtment for all tests.
     */
    public function setUp()
    {
        parent::setUp();

        $this->configureDatabase();
        $this->createPostsTable();
        $this->createRoutesTable();

        $this->faktory = new Faktory();
        $load_factories = function ($faktory) {
            require __DIR__.'/factories.php';
        };
        $load_factories($this->faktory);
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'routableTest');

        $app['config']->set('database.connections.routableTest', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Configure the database.
     */
    private function configureDatabase()
    {
        $db = new DB();
        $db->addConnection(
            [
                'driver'    => 'sqlite',
                'database'  => ':memory:',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ]
        );
        $db->bootEloquent();
        $db->setAsGlobal();
    }

    /**
     * Create the posts table in the database.
     */
    private function createPostsTable()
    {
        DB::schema()->create('posts', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->string('body');
            $table->timestamps();
        });
    }

    /**
     * Create the routes table in the database.
     */
    private function createRoutesTable()
    {
        DB::schema()->create('routes', function ($table) {
            $table->increments('id');
            $table->string('url')->unique();
            $table->string('controller');
            $table->string('controller_parameters')->nullable();
            $table->string('model');
            $table->integer('model_id');
            $table->string('locale');
            $table->timestamps();
        });
    }
}
