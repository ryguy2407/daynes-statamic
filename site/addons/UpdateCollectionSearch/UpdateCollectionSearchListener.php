<?php

namespace Statamic\Addons\UpdateCollectionSearch;

use Statamic\API\Config;
use Statamic\Data\Entries\Entry;
use Statamic\Extend\Listener;
use Statamic\API\Search;

class UpdateCollectionSearchListener extends Listener
{
    /**
     * Listen for entries being published and then update the search index
     *
     * @var array
     */
    public $events = ['cp.entry.published' => 'handleEntrySaved'];

    public function handleEntrySaved(Entry $entry)
    {
      $collection_name = $entry->collectionName();

      if ($this->shouldUpdateCollection($collection_name)) {
        $index = 'collections/' . $collection_name;
        foreach (Config::getLocales() as $locale) {
            Search::in($index, $locale)->update();
        }
      }
    }

     /**
     * Only update the collections if in the config
     *
     * @param $formset_name string
     *
     * @return bool
     */
    private function shouldUpdateCollection($collection_name)
    {
        return collect($this->getConfig('collection_to_index'))->contains($collection_name);
    }
}
