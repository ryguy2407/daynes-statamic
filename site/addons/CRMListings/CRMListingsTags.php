<?php

namespace Statamic\Addons\CRMListings;

use Illuminate\Pagination\LengthAwarePaginator;
use Statamic\Addons\CRMListings\Repositories\CRMInterface;
use Statamic\API\Collection;
use Statamic\API\Entry;
use Statamic\API\Fieldset;
use Statamic\Extend\Tags;

class CRMListingsTags extends Tags
{

	/**
     *
     * The CRM Api interface
     * @var CRMInterface
     */
    public $crm;

    public $limit;

    public function __construct(CRMInterface $crm)
    {
        parent::__construct();
        $this->crm = $crm;
        $this->limit = 20;
    }

    /**
     * The {{ c_r_m_listings }} tag
     * @return array|string
     * @internal param CRMInterface $crm
     *
     */
    public function index()
    {
    }

    public function createlistings($offset = 0)
    {

        if(! Fieldset::exists('listings')) {
            $fieldset = Fieldset::create( 'test', [
                'title'        => 'Test',
                'create_title' => 'Test',
                'taxonomies'   => true,
                'sections'     => [
                    'main' => [
                        'display' => 'Main',
                        'fields'  => [
                            'price' => [
                                'type' => 'text'
                            ]
                        ]
                    ]
                ]
            ] );

            $fieldset->save();
        }

        $limit = 20;
        $result = $this->crm->getListings('Sold', 'residential_sale', 0);

        $count = count($result);

        // Keep running until all listings are saved into DB
        if($count == $limit) {
            $offset += $limit;
            foreach($result as $listing) {
                $this->store($listing);
            }
            $this->createlistings($offset);
        }

        // Run this loop when count is less than limit
        foreach($result as $listing) {
            $this->store($listing);
        }

        return $result;
    }

    public function store($listing)
    {

        $factory = Entry::create($listing['advert_internet']['heading'])
                        ->collection('listings')
                        ->with([
                            'title' => $listing['advert_internet']['heading'],
                            'content' => $listing['advert_internet']['body'],
                            'price' => $listing['price_advertise_as'],
                            'bedrooms' => $listing['attributes']['bedrooms'],
                            'bathrooms' => $listing['attributes']['bathrooms'],
                            'cars' => $listing['attributes']['total_car_accom'],
                            'status' => $listing['system_listing_state'],
                            'images' => $listing['images'],
                            'property_id' => $listing['property_id']
                        ]);

        $entry = $factory->get();

        if(! Entry::slugExists($entry->slug(), 'listings')) {
            $entry->save();
        }
    }
}
