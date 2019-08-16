<?php

namespace Statamic\Addons\Suburb;

use Statamic\API\Collection;
use Statamic\API\Entry;
use Statamic\Extend\Tags;

class SuburbTags extends Tags
{
    /**
     * The {{ suburb }} tag
     *
     * @return string|array
     */
    public function index()
    {
        $listings = Entry::whereCollection('listings');
        $suburbs = [];
        foreach($listings->toArray() as $listing) {
            $suburbs[] = $listing['suburb'];
        }
        $arr = array_values(array_unique($suburbs));

        $uniqueArray = [];
        foreach($arr as $a) {
            $uniqueArray[] = ['suburb_name' => $a];
        }
        return $this->parseLoop($uniqueArray);
    }

    /**
     * The {{ suburb:example }} tag
     *
     * @return string|array
     */
    public function example()
    {
        //
    }
}
