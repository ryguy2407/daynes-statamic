<?php

namespace Statamic\Addons\CRMListings;

use Illuminate\Http\Request;
use Statamic\Addons\CRMListings\Repositories\SyncListings;
use Statamic\Extend\Controller;

class CRMListingsController extends Controller
{
    public $sync;

    public function __construct(SyncListings $sync)
    {
        parent::__construct();
        $this->sync = $sync;
    }

    public function index()
    {
        return $this->view('index', [
            'title' => 'Sync Listings'
        ]);
    }

    public function create()
    {
        return $this->view('create', [
            'title' => 'Create Listings'
        ]);
    }

    public function syncListings()
    {
        return $this->sync->syncAllListings(request('status'), request('listing_type'), 0);
    }
}
