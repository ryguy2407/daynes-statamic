<?php

namespace Statamic\Addons\CRMListings\Repositories;

use GuzzleHttp\Client;

class RexListings implements CRMInterface {

	public function getListings( $criteria, $offset = 0 )
	{
		if (! session('token')) {
			session()->put('token', $token = $this->getToken());
		}

		$client = new Client();
		$response = $client->request( 'GET', 'https://api.rexsoftware.com/rex.php', [
			'query' => [
				'method' => 'PublishedListings::search',
				'args' => [
					'criteria' => [
						[
							'name'  => 'listing.system_publication_status',
							'value' => 'published',
						],
						[
							'name' => 'listing.system_listing_state',
							"type" => "!=",
							"value" => "withdrawn"
						],
						[
							'name' => 'listing.system_listing_state',
							"value" => "current"
						],
						[
							'name' => 'property.property_category_id',
							"type" => "!=",
							"value" => "commercial"
						]
					],
					'extra_options' => [
						'extra_fields' => [
							0 => 'images',
							1 => 'advert_internet'
						],
					],
					'limit' => 20,
					'offset' => $offset,
					'order_by' => [
						'system_ctime' => 'asc',
					],
				],
				'token'  => session('token')->result,
			]
		]);

		$resArray = json_decode($response->getBody()->getContents(), true);
		return $resArray;
	}

	public function getToken()
	{
		$client = new Client();
		$response = $client->request('GET', 'https://api.rexsoftware.com/rex.php', [
			'query' => [
				'method' => 'Authentication::login',
				'args' => [
					'email' => env('REX_EMAIL'),
					'password' => env('REX_PASSWORD'),
					'application' => 'rex'
				]
			]
		]);
		return json_decode($response->getBody()->getContents());
	}
}