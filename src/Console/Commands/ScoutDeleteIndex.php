<?php

namespace Trinityrank\Search\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Multitenancy\Models\Tenant;
use Trinityrank\Search\Traits\ShellExecuteCommand;
use MeiliSearch\Client;
use MeiliSearch\Contracts\IndexesQuery;

class ScoutDeleteIndex extends Command
{
    use ShellExecuteCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:delete-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all search indexes';


    public function __construct()
    {
        parent::__construct();
        $this->client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tenants = Tenant::get()->pluck('name')->toArray();
        $name = $this->choice('For which tenant would you like to delete all search data?', $tenants);

        foreach ($this->client->getAllIndexes((new IndexesQuery())->setLimit(1000000)) as $index) {
            if (strpos($index->getUid(), $name) !== false) {
                // Delete index
                $this->client->deleteIndex($index->getUid());

                // Write message
                $this->info($index->getUid() ." - deleted");
            }
        }

        $this->info('All search indexes for "'. $name .'" are successfully deleted!');
    }
}
