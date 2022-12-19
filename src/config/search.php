<?php

return [
    // Categories
    'blog-category' => [
        'model' => 'App\Categories\Types\BlogCategory',
        'title' => 'Blog Category',
        'index' => 'blogcategory',
        'route' => 'resolve',
        'route_subcategory' => false,
        'category_in_slug' => false,
        'subcategory_in_slug' => false
    ],
    'news-category' => [
        'model' => 'App\Categories\Types\NewsCategory',
        'title' => 'News Category',
        'index' => 'newscategory',
        'route' => 'news.category',
        'route_subcategory' => false,
        'category_in_slug' => false,
        'subcategory_in_slug' => false
    ],
    'products-&-services-category' => [
        'model' => 'App\Categories\Types\MoneyPageCategory',
        'title' => 'Products & Services Category',
        'index' => 'moneypagecategory',
        'route' => 'resolve',
        'route_subcategory' => false,
        'category_in_slug' => false,
        'subcategory_in_slug' => false
    ],
    'review-category' => [
        'model' => 'App\Categories\Types\ReviewPageCategory',
        'title' => 'Review Category',
        'index' => 'reviewpagecategory',
        'route' => 'reviews.resolve',
        'route_subcategory' => false,
        'category_in_slug' => false,
        'subcategory_in_slug' => false
    ],
    'deal-category' => [
        'model' => 'App\Categories\Types\DealPageCategory',
        'title' => 'Deal Categories',
        'index' => 'dealpagecategory',
        'route' => 'deals.category',
        'route_subcategory' => false,
        'category_in_slug' => false,
        'subcategory_in_slug' => false
    ],

    // Articles
    'blog' => [
        'model' => 'App\Articles\Types\Blog',
        'title' => 'Blogs',
        'index' => 'blog',
        'route' => 'resolve.single',
        'route_subcategory' => false,
        'category_in_slug' => true,
        'subcategory_in_slug' => false
    ],
    'news' => [
        'model' => 'App\Articles\Types\News',
        'title' => 'News',
        'index' => 'news',
        'route' => 'news.single',
        'route_subcategory' => false,
        'category_in_slug' => true,
        'subcategory_in_slug' => false
    ],

    // Pages
    'products-&-services' => [
        'model' => 'App\Pages\Types\MoneyPage',
        'title' => 'Products & Services',
        'index' => 'moneypage',
        'route' => 'resolve.single',
        'route_subcategory' => false,
        'category_in_slug' => true,
        'subcategory_in_slug' => false
    ],
    'review-page' => [
        'model' => 'App\Pages\Types\ReviewPage',
        'title' => 'Reviews',
        'index' => 'reviewpage',
        'route' => 'reviews.resolve',
        'route_subcategory' => false,
        'category_in_slug' => false,
        'subcategory_in_slug' => false
    ],
    'deal-page' => [
        'model' => 'App\Pages\Types\DealPage',
        'title' => 'Deals',
        'index' => 'dealpage',
        'route' => 'deals.single',
        'route_subcategory' => false,
        'category_in_slug' => false,
        'subcategory_in_slug' => false
    ],
];
