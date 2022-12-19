<?php

namespace Trinityrank\Search\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Multitenancy\Models\Tenant;
use Trinityrank\Search\Traits\ShellExecuteCommand;

class ScoutDelete extends Command
{
    use ShellExecuteCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all search data such as posts, pages and categories';


    public function __construct()
    {
        parent::__construct();
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
        $id = Tenant::where('name', $name)->first()->id;
        $models = config('tenants.'. $name .'.search');

        foreach ($models as $model) {
            $this->shell_execute("php artisan tenants:artisan 'scout:flush ". $model ."' --tenant=". $id);
        }

        $this->info('All search data for "'. $name .'" are successfully deleted!');

    }
}
