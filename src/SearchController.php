<?php

namespace Trinityrank\Search;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use MeiliSearch\Client;
use Trinityrank\TailingSlash\UrlGenerator;
use Trinityrank\Shortcode\Shortcodes;
use MeiliSearch\Contracts\IndexesQuery;

class SearchController extends Controller
{
    public $client;
    public $baseController;
    public $multilang = false;

    public static $config = [];

    public function __construct()
    {
        self::$config = config('search');
        $this->client = new Client(env('MEILISEARCH_HOST'), env('MEILISEARCH_KEY'));
        $this->baseController = app(BaseController::class);
        // Multilanguage support
        $this->multilang = function_exists('multilang_route');
    }


    public function search($searchFor, $lang, $searchIndex = '')
    {
        /*
        - Because "new Client()" does not return any error status if there is no connection,
        it always teturn succerss

        - So here we need to check is it working or not.

        - If there is no Meilisearch server connection than return empty results,
        to prevent errors on frontend of your website.
        */
        try{
            $this->client->getAllRawIndexes();
        } catch(Exception $e) {
            return [];
        }

        $resultSet = [];
        foreach (self::$config as $index => $data) {
            if (!empty($searchIndex) && $index !== $searchIndex) {
                continue;
            }

            // Search Index
            $search_index = strtolower(config('app.name')).'_tenant_'.$data['index'].'_index';

            // Abort page if no indexes in search
            if (empty($this->client->getAllRawIndexes())) {
                abort(404);
            }

            // Prevent page to break if search-index is not found
            $indexes = collect($this->client->getAllIndexes((new IndexesQuery())->setLimit(1000000)))->map(function ($item, $key) {
                return $item->getUid();
            })->toArray();

            if (in_array($search_index, $indexes) === false) {
                continue;
            }

            // Get search results
            try {
                $filter = 'publish_at = false OR publish_at < '.time();
                if ($this->multilang) {
                    $filter = 'multilang_language = ' . $lang .' AND (publish_at = false OR publish_at < '.time() .')';
                }

                $hits = $this->client
                    ->index($search_index)
                    ->search($searchFor, [
                            'limit' => 1000,
                            'filter' => $filter
                        ])->getHits();
            } catch (\Throwable $th) {
                continue;
            }

            if (empty($hits)) {
                continue;
            }

            $resultSet[$index] = array_column($hits, 'id');
        }

        return $resultSet;
    }


    protected function map($items, $index)
    {
        return $items->map(function ($item) use ($index) {
            // field is too large and we don't use it
            unset($item['decorators']);
            $params = [];

            // Create route
            $route = self::$config[$index]['route'];

            // Category
            if (self::$config[$index]['category_in_slug'] === true) {
                $params[] = $item->categories->first()->slug;
            }

            // Category fixed word
            if (is_string(self::$config[$index]['category_in_slug'])) {
                $params[] = self::$config[$index]['category_in_slug'];
            }

            // We need parent if subcategory system is used
            if (self::$config[$index]['subcategory_in_slug'] === true) {
                // Post / Page with subcategory
                if (isset($item->categories)) {
                    $route = self::$config[$index]['route_subcategory'];
                    $params[] = $item->categories->first()->parent()->first()->slug;
                }
                // Category page with subcategory
                else {
                    if ($item->parent()->first()) {
                        $route = self::$config[$index]['route_subcategory'];
                        $params[] = $item->parent()->first()->slug;
                    } else {
                        // $params[] = $item->first()->slug;
                    }
                }
            }
            // Slug
            $params[] = $item->slug;

            // Test lines
            // dump($item->type);
            // dump("route - ". $route);
            // dump($params);
            // dump("--------");

            // Add href to every element in collection
            if ($this->multilang) {
                $item['href'] = multilang_route($route, $params);
            } else {
                $item['href'] = route($route, $params);
            }
        });
    }

    public function searchAjax($searchFor, $lang = null)
    {
        $search_data = [
            'resultSet' => [],
            'searchFor' => $searchFor,
        ];
        $search = $this->search($searchFor, $lang);

        foreach ($search as $index => $ids) {
            $ids_to_find = array_slice($ids, 0, 3);
            $items = self::$config[$index]['model']::whereIn('id', $ids_to_find)->get();

            $this->map($items, $index);

            $items->map(function ($item) {
                $item['title'] = Shortcodes::convert($item['title']);        
                return $item;
            });

            $items = $items->toArray();

            $search_data['resultSet'][ self::$config[$index]['title'] ] = [
                'results' => $items,
                'type' => $index,
                'count' => count($ids),
            ];
        }

        // dd($search_data);
        return $search_data;
    }

    public function singleViewAll($model = null, $pageNumber = null, $lang = null)
    {
        $lang = UrlGenerator::language($pageNumber, $lang);
        UrlGenerator::paginationCheck($pageNumber);

        $lang = $lang ?? config('app.locale');

        $request = FacadesRequest::all();

        if (!array_key_exists($model, self::$config)) {
            return abort('404');
        }

        $query = $request['q'] ?? null;
        if (!$query) {
            return abort('404');
        }

        $noindex = true;
        $title = self::$config[$model]['title'];
        $seo = $this->baseController->getSeoData('default');
        $search_data = $this->search($query, $lang, $model);

        $searchResults = self::$config[$model]['model']::whereIn('id', $search_data[$model])->paginate(12);

        $this->map($searchResults, $model);

        if ($searchResults->lastPage() < $searchResults->currentPage()) {
            abort(404);
        }

        return view('search.single', compact('searchResults', 'query', 'seo', 'title', 'noindex'));
    }


    public function joinedViewAll($lang = null)
    {
        $noindex = true;
        $request = FacadesRequest::all();
        $seo = $this->baseController->getSeoData('default');
        $total = 0;
        $searchResults = null;
        $query = $request['q'] ?? null;

        if (!$query) {
            return abort('404');
        }

        $search_data = $this->search($query, $lang);

        foreach ($search_data as $index => $ids) {
            $items = self::$config[$index]['model']::whereIn('id', $ids)->limit(8)->get();

            $this->map($items, $index);

            $total += count($ids);
            $searchResults[$index] = [
                'results' => $items,
                'title' => self::$config[$index]['title'],
                'total' => count($ids)
            ];
        }

        return view('search.all', compact('searchResults', 'query', 'seo', 'total', 'noindex'));
    }
}
