<?php

namespace Trinityrank\Search\Traits;

use ReflectionClass;

trait Search
{
    public function searchableAs()
    {
        return app('currentTenant')['name'].'_tenant_'. strtolower((new ReflectionClass($this))->getShortName()) .'_index';
    }

    public function shouldBeSearchable()
    {
        return ($this->status == 1 && $this->search_exclude == 0);
    }
}
