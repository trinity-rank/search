<?php
namespace Trinityrank\Search\Fields;

use Laravel\Nova\Fields\Boolean;

class SearchExclude
{
    public static function make($name = 'Exclude from search')
    {
        return Boolean::make($name, 'search_exclude')
            ->trueValue('1')
            ->falseValue('0');
    }
}
