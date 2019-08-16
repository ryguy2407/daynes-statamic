<?php

namespace Statamic\Addons\CRMListings\Repositories;

use Statamic\API\Entry;

class SyncListings {

	public $crm;

	public function __construct(CRMInterface $crm)
	{
		$this->crm = $crm;
	}

	public function syncAllListings($status = 'Active', $listingType = 'residential_sale', $offset)
	{
		$limit = 60;
		$result = $this->crm->getListings($status, $listingType, $offset);
		$listings = [];

		//Count how many total entries for this request there are
		$count = count($result['data']);

		// Keep running until all listings are saved into DB
		if($count == $limit) {
			$offset += $limit;
			foreach($result['data'] as $listing) {
				$this->storeListings($listing);
				$listings[] = $listing;
			}
			$this->syncAllListings($status, $listingType, $offset);
		}

		// Run this loop when count is less than limit
		foreach($result['data'] as $listing) {
			$this->storeListings($listing);
			$listings[] = $listing;
		}

		return $listings;
	}

	public function storeListings($listing)
	{
//		//Get the linked images
//		$images = $this->crm->getImages($listing['relationships']['images']['links']['related']);
//		$imagesArray = [];
//
//		// Loop through the retrieved images and store in array
//		foreach($images['data'] as $image) {
//			$imagesArray[] = ['url' => $image['attributes']['url']];
//		}

		$dataArray = [
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
			'suburb' => $listing['attributes']['suburb'],
			'main_image' => $listing['attributes']['primary_image'],
			'images' => $listing['relationships']['images']['links']['related'],
			'property_id' => $listing['id'],
			'price_search' => $listing['attributes']['price']
		];

		$factory = Entry::create($listing['attributes']['headline'])
		                ->collection('listings')
		                ->with($dataArray);

		$entry = $factory->get();

		if(! Entry::slugExists($entry->slug(), 'listings')) {
			//If the entry doesn't exist just go ahead and save it
			$entry->save();
		} else {
			$existingEntry = Entry::whereSlug($entry->slug(), 'listings');
			foreach($dataArray as $key => $value) {
				$existingEntry->set($key, $value);
			}
			$existingEntry->save();
		}
	}

	public function getImages($image)
	{
		//Get the linked images
		$images = $this->crm->getImages($image);
		$imagesArray = [];

		// Loop through the retrieved images and store in array
		foreach($images['data'] as $image) {
			$imagesArray[] = ['imageUrl' => $image['attributes']['url']];
		}

		return $imagesArray;
	}

}