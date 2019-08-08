<?php

namespace Statamic\Addons\CRMListings;

use Illuminate\Http\Request;
use Statamic\Addons\CRMListings\Repositories\CRMInterface;
use Statamic\API\Collection;
use Statamic\API\Entry;
use Statamic\Extend\Controller;

class CRMListingsController extends Controller
{
    public $crm;

    public function __construct(CRMInterface $crm)
    {
        parent::__construct();
        $this->crm = $crm;
    }

    /**
     * Maps to your route definition in routes.yaml
     *
     * @return mixed
     */
    public function index()
    {
        return $this->view('index');
    }

    public function show()
    {
        return $this->view('index');
    }

//    public function getListings($firstParam, $secondParam)
//    {
//        $result = $this->crm->getListings($firstParam, $secondParam)['result']['rows'];
//        return $result;
//    }
//
//    public function postListings(Request $request)
//    {
//        $result = $this->crm->getListings('current', 0, $request->all())['result']['rows'];
//        return $result;
//    }
//
//    public function getCreateListings($offset = 0)
//    {
//        $limit = 20;
//        $result = $this->crm->getListings('published', $offset, null)['result']['rows'];
//        $count = count($result);
//
//
//
//        // Keep running until all listings are saved into DB
//        if($count == $limit) {
//            $offset += $limit;
//            foreach($result as $listing) {
//                $this->store($listing);
//            }
//            $this->getCreateListings($offset);
//        }
//
//        // Run this loop when count is less than limit
//        foreach($result as $listing) {
//            $this->store($listing);
//        }
//
//        return $result;
//    }
//
//    public function store($listing)
//    {
//        if(! Collection::handleExists('listings')) {
//            Collection::create('listings');
//        }
//
//        $factory = Entry::updateOrCreate($listing['advert_internet']['heading'])
//            ->collection('listings')
//            ->with([
//                'title' => $listing['advert_internet']['heading'],
//                'content' => $listing['advert_internet']['body'],
//                'price' => $listing['price_advertise_as'],
//                'bedrooms' => $listing['attributes']['bedrooms'],
//                'bathrooms' => $listing['attributes']['bathrooms'],
//                'cars' => $listing['attributes']['total_car_accom'],
//                'status' => $listing['system_listing_state']
//            ]);
//
//        $entry = $factory->get();
//        $entry->save();
//    }
}
