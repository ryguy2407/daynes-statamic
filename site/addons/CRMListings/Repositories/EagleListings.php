<?php

namespace Statamic\Addons\CRMListings\Repositories;

use GuzzleHttp\Client;

class EagleListings implements CRMInterface {

	public $client;

	public function __construct(Client $client)
	{
		$this->client = $client;
	}

	public function getToken() {
		$response = $this->client->post('https://www.eagleagent.com.au/api/v2/sessions', [
			'headers' => [
				'Content-Type' => 'application/vnd.api+json'
			],
			'json' => [
				'data' => [
					'type' => 'sessions',
					'attributes' => [
						'email' => env('EAGLE_EMAIL'),
						'password' => env('EAGLE_PASSWORD'),
					]
				]
			]
		]);
		return json_decode($response->getBody()->getContents());
	}

	public function getListings( $status, $listing_type, $offset )
	{
		$result = $this->queryAPI($status, $listing_type, $offset);
		return json_decode($result->getBody()->getContents(), true);
	}

	public function getRelated($url)
	{
		$token = $this->getToken();
		$images = $this->client->get($url, [
			'headers' => [
				'Content-Type' => 'application/vnd.api+json',
				'Authorization' => $token->data->attributes->token
			]
		]);
		return json_decode($images->getBody()->getContents(), true);
	}

	public function queryAPI($status, $listing_type, $offset = 0)
	{
		$token = $this->getToken();

		$query = $this->client->get('https://www.eagleagent.com.au/api/v2/properties', [
			'headers' => [
				'Content-Type' => 'application/vnd.api+json',
				'Authorization' => $token->data->attributes->token
			],
			'query' => [
				'filter' => [
					'status' => $status,
					'listing_type' => $listing_type,
				],
				'page' => [
					'offset' => $offset
				]
			]
		]);
		return $query;
	}
}
