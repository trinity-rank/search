<?php

namespace Trinityrank\Search\Traits;

use Carbon\Carbon;
use ReflectionClass;
use Trinityrank\Shortcode\Shortcodes;

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


    public static function convert($item)
    {
        if (class_exists(Shortcodes::class)) {
            $item['title'] = Shortcodes::convert($item['title']);
        }
        if(isset($item['publish_at'])) {
            $item['publish_at'] = Carbon::parse($item['publish_at'])->timestamp;
        } else {
            $item['publish_at'] = Carbon::parse($item['created_at'])->timestamp;
        }

        return $item;
    }
}
