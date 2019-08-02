<?php

namespace Statamic\Addons\CRMListings;

use Statamic\Extend\Controller;

class CRMListingsController extends Controller
{
    /**
     * Maps to your route definition in routes.yaml
     *
     * @return mixed
     */
    public function index()
    {
        return $this->view('index');
    }
}
