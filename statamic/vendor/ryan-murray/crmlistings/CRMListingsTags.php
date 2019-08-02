<?php

namespace Statamic\Addons\CRMListings;

use Statamic\Extend\Tags;

class CRMListingsTags extends Tags
{
    /**
     * The {{ c_r_m_listings }} tag
     *
     * @return string|array
     */
    public function index()
    {
        return 'CRM Listing stuff here';
    }

    /**
     * The {{ c_r_m_listings:example }} tag
     *
     * @return string|array
     */
    public function example()
    {
        //
    }
}
