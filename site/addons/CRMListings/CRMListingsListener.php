<?php

namespace Statamic\Addons\CRMListings;

use Statamic\API\Nav;
use Statamic\Extend\Listener;

class CRMListingsListener extends Listener
{
    /**
     * The events to be listened for, and the methods to call.
     *
     * @var array
     */
    public $events = [
        'cp.nav.created' => 'addNavItems'
    ];

    public function addNavItems($nav)
    {
        // Create the first level navigation item
        $listing = Nav::item('Sync Listings')->route('index')->icon('cw');

        // Finally, add our first level navigation item
        // to the navigation under the 'content' section.
        $nav->addTo('content', $listing);
    }
}
