# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/trinityrank/search-multitenancy.svg?style=flat-square)](https://packagist.org/packages/trinityrank/search-multitenancy)
[![Total Downloads](https://img.shields.io/packagist/dt/trinityrank/search-multitenancy.svg?style=flat-square)](https://packagist.org/packages/trinityrank/search-multitenancy)

This package manage all data for search:
- import
- update
- delete)
- retrive data on frontend

This package will work work with multilanguage on your website ONLY if you are using our [trinity-rank/multilanguage](https://github.com/trinity-rank/multilanguage) package 

# Installation

## - Backend

### Step 1: Install package

To get started with Laravel Search Multitenancy, use Composer command to add the package to your composer.json project's dependencies:

```shell
    composer require trinityrank/search-multitenancy
```


### Step 2: Namespaces

- In every tenant config add theese namespaces to include posts/pages/categories in your search

```shell
    ...
    // Include for search (articles, pages, categories...)
    'search' => [
        'App\\\Categories\\\Types\\\BlogCategory',
        'App\\\Categories\\\Types\\\NewsCategory',
        'App\\\Categories\\\Types\\\MoneyPageCategory',
        'App\\\Categories\\\Types\\\ReviewPageCategory',
        'App\\\Categories\\\Types\\\DealPageCategory',
        'App\\\Articles\\\Types\\\Blog',
        'App\\\Articles\\\Types\\\News',
        'App\\\Pages\\\Types\\\MoneyPage',
        'App\\\Pages\\\Types\\\ReviewPage',
        'App\\\Pages\\\Types\\\DealPage',
    ],
    ...
```


### Step 3: Add .env params

- Put your *host* and secret key into this variables

```shell
    SCOUT_QUEUE=false
    SCOUT_DRIVER=meilisearch
    MEILISEARCH_HOST=http://127.0.0.1:7700/
    MEILISEARCH_KEY=null
```


### Step 4: Update config

- Add this in config/scout.php at the end (if already exist ignore this step)

```shell
    ...
    'meilisearch' => [
        'host' => env('MEILISEARCH_HOST', 'http://localhost:7700'),
        'key' => env('MEILISEARCH_KEY', null),
    ],
    ...
```


### Step 5: Database

- You need to publish migration file from package

```shell
    php artisan vendor:publish --provider="Trinityrank\Search\SearchServiceProvider" --tag="search-migration"
```

And then you need to run migration for all tenants

```shell
    php artisan tenant:artisan "migrate"
```

Or only for one speciffic tenant

```shell
    php artisan tenant:artisan "migrate" --tenant=[--TENANT-ID--]
```


### Step 7: Import search data

- First delete all existing data and old indexes and then do fresh import data and update filters

```shell
    // delete
    php artisan search:delete
    php artisan search:delete-index

    // import
    php artisan search:import

    // update
    php artisan search:update-filters
```


## - Frontend


### Step 1: Install package

Install this two packages
    - trinityrank/search-multitenancy: latest version
    - meilisearch/meilisearch-php: ^0.24.1 or latest

```shell
    composer require meilisearch/meilisearch-php
    composer require trinityrank/search-multitenancy
```


### Step 2: Add .env params

Put your **host** and secret **key** into this variables

```shell
    MEILISEARCH_HOST=http://127.0.0.1:7700/
    MEILISEARCH_KEY=null
```


### Step 3: Publishing

- You need to publish files from package (config and js file)

```shell
    php artisan vendor:publish --provider="Trinityrank\Search\SearchServiceProvider" --tag="search-config"
```


### Step 4: JS

- Include compiled JS file in your js mix

```shell
    ...
    .copy(
        'vendor/trinityrank/search-multitenancy/src/public/js/search.js',
        'public/js'
    )
    ...
```

- Than xecute 
```shell
    npm run dev
```


- In your Blade file add this directive to include javascript 
    - If you are adding into component add yhis part of code:

    ```shell
        @once
            @push('your-stack-name')
                @searchJs
            @endpush
        @endonce
    ```

    - If you are adding into layout you can add like this:

    ```shell
        @searchJs
    ```