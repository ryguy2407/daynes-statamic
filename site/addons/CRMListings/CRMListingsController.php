<?php

namespace Statamic\Addons\CRMListings;

use Carbon\Carbon;
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

    public function update()
    {
        return $this->view('create', [
            'title' => 'Update Listings'
        ]);
    }

    public function syncListings()
    {
        //Add a timestamp for when the sync was done
        $this->storage->put('lastsync', Carbon::now());

        return $this->sync->syncAllListings(request('status'), request('listing_type'), 0);
    }

    public function updateListings()
    {

    }

    public function getRelated()
    {
        return $this->sync->getRelated(request('url'));
    }
}
