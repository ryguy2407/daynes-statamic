<?php

namespace Statamic\Addons\CRMListings\Repositories;

interface CRMInterface {
	public function getToken();
	public function getListings($criteria, $offset);
}