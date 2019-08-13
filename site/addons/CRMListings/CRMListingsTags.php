<?php

namespace Statamic\Addons\CRMListings;

use Aws\Handler\GuzzleV5\GuzzleHandler;
use Illuminate\Pagination\LengthAwarePaginator;
use Statamic\Addons\CRMListings\Repositories\CRMInterface;
use Statamic\API\Collection;
use Statamic\API\Entry;
use Statamic\API\Fieldset;
use Statamic\Extend\Tags;
use GuzzleHttp\Client;

class CRMListingsTags extends Tags
{

	/**
     *
     * The CRM Api interface
     * @var CRMInterface
     */
    public $crm;

    public $limit;

    public $client;

    public function __construct(CRMInterface $crm, Client $client)
    {
        parent::__construct();
        $this->crm = $crm;
        $this->limit = 20;
        $this->client = $client;
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

        $limit = 60;
        $result = $this->crm->getListings($this->getParam('status'), $this->getParam('listing_type'), $offset);

        $count = count($result['data']);

        // Keep running until all listings are saved into DB
        if($count == $limit) {
            $offset += $limit;
            foreach($result['data'] as $listing) {
                $this->store($listing);
            }
            $this->createlistings($offset);
        }

        // Run this loop when count is less than limit
        foreach($result['data'] as $listing) {
            $this->store($listing);
        }

        return $result;
    }

    public function store($listing)
    {
        $images = $this->crm->getImages($listing['relationships']['images']['links']['related']);
        $imagesArray = [];

        foreach($images['data'] as $image) {
            $imagesArray[] = ['url' => $image['attributes']['url']];
        }

        $factory = Entry::create($listing['attributes']['headline'])
                        ->collection('listings')
                        ->with([
                            'title' => $listing['attributes']['headline'],
                            'property_type' => $listing['attributes']['property_type'],
                            'listing_type' => $listing['attributes']['listing_type'],
                            'content' => $listing['attributes']['description'],
                            'price' => $listing['attributes']['alt_to_price'],
                            'rent' => $listing['attributes']['rental_per_week'],
                            'bedrooms' => $listing['attributes']['bedrooms'],
                            'bathrooms' => $listing['attributes']['bathrooms'],
                            'cars' => $listing['attributes']['car_spaces'],
                            'status' => $listing['attributes']['status'],
                            'address' => $listing['attributes']['full_address'],
                            'main_image' => $listing['attributes']['primary_image'],
                            'images' => $imagesArray,
                            'property_id' => $listing['id']
                        ]);

        $entry = $factory->get();

        if(! Entry::slugExists($entry->slug(), 'listings')) {
            $entry->save();
        }
    }
}
