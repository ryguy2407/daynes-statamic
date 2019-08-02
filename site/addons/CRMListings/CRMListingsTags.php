<?php

namespace Statamic\Addons\CRMListings;

use Illuminate\Pagination\LengthAwarePaginator;
use Statamic\Addons\CRMListings\Repositories\CRMInterface;
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
        //Query the API and return the results
        $result = $this->crm->getListings(null, $this->offset(request('page')))['result'];

        $pagination = new LengthAwarePaginator($result['rows'], $result['total'], $this->limit);

        $listings = $result['rows'];
        //$data[1]['pagination'] = $pagination->render();

        return $this->parseLoop([
            [
                'listings' => $listings
            ],
            [
                'pagination' => $pagination
            ]
        ]);
    }

    public function pagination()
    {
        return 'paginator';
    }

    private function offset($page)
    {
        return $page * $this->limit;
    }
}
