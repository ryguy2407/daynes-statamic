<?php

namespace Statamic\Addons\CRMListings\Repositories;

interface CRMInterface {
	public function getToken();
	public function getListings($status, $listing_type, $offset);
	public function getImages($url);
}