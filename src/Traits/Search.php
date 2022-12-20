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


    public static function convert($that)
    {
        if (class_exists(Shortcodes::class)) {
            $that->title = Shortcodes::convert($that->title);
        }
        $that->publish_at = Carbon::parse($that->publish_at)->timestamp;

        return $that;
    }
}
