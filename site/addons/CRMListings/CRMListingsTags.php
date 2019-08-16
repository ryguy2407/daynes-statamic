<?php

namespace Statamic\Addons\CRMListings;

use Statamic\Addons\CRMListings\Repositories\CRMInterface;
use Statamic\Addons\CRMListings\Repositories\SyncListings;
use Statamic\Extend\Tags;

class CRMListingsTags extends Tags
{
    public $sync;


    public function __construct(SyncListings $sync)
    {
        parent::__construct();
        $this->sync = $sync;
    }

    /**
     * The {{ c_r_m_listings }} tag
     * @return array|string
     * @internal param int $offset
     *
     * @internal param CRMInterface $crm
     */
    public function index()
    {
        return $this->sync->syncAllListings($this->getParam('status'), $this->getParam('listing_type'), $this->getParam('offset'));
    }

    public function images()
    {
        return $this->parseLoop($this->sync->getImages($this->getParam('images')));
    }
}
