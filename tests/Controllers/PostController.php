<?php

namespace Askaoru\Routable\Tests\Controllers;

use Illuminate\Routing\Controller;

class PostController extends Controller
{
    /**
     * Return true if this controller is executed and contains the parameter $id.
     *
     * @return bool
     */
    public function view($id)
    {
        if (!$id) {
            return false;
        }

        return true;
    }
}
