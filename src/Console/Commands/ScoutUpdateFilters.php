<?php

namespace Trinityrank\Search\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Multitenancy\Models\Tenant;
use Trinityrank\Search\Traits\ShellExecuteCommand;
use MeiliSearch\Client;
use MeiliSearch\Contracts\IndexesQuery;

class ScoutUpdateFilters extends Command
{
    use ShellExecuteCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:update-filters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update search indexes';

    public function __construct()
    {
        parent::__construct();
        $this->client = new Client(env('MEILISEARCH_HOST', 'http://localhost:7700'), env('MEILISEARCH_KEY', null));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tenants = Tenant::get()->pluck('name')->toArray();
        $name = $this->choice('For which tenant would you like to update search filters?', $tenants);

        foreach ($this->client->getAllIndexes((new IndexesQuery())->setLimit(1000000)) as $index) {
            if (strpos($index->getUid(), $name) !== false) {
                $this->update_filters($index->getUid());
            }
        }

        $this->info('Search filters are successfully updated!');
    }

    public function update_filters($index)
    {
        $this->client
            ->index($index)
            ->updateFilterableAttributes(['multilang_language', 'publish_at']);

        $this->client
            ->index($index)
            ->updateSearchableAttributes(['title']);
    }
}
