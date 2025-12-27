<?php

return [
    [
        'title' => 'Dashboard',
        'icon' => 'bx bxs-home',
        'route' => route('admin.dashboard'),
    ],
    [
        'title' => 'Users',
        'icon' => 'bx bxs-group',
        'route' => route('admin.users.index'),
    ],
    [
        'title' => 'Newsletter',
        'icon' => 'bx bxs-envelope',
        'route' => route('admin.newsletters.index'),
    ],
    [
        'title' => 'Inquiries',
        'icon' => 'bx bxs-message-dots',
        'route' => route('admin.inquiries.index'),
    ],
    [
        'title' => 'Banners',
        'icon' => 'bx bxs-image-alt',
        'route' => route('admin.banners.index'),
    ],
    [
        'title' => 'Tours',
        'icon' => 'bx bx-world',
        'submenu' => [
            [
                'title' => 'All Tours',
                'icon' => 'bx bx-world',
                'route' => route('admin.tours.index'),
            ],
            [
                'title' => 'Categories',
                'icon' => 'bx bxs-category',
                'route' => route('admin.tour-categories.index'),
            ],
            [
                'title' => 'Sync Tours',
                'icon' => 'bx bx-refresh',
                'route' => route('admin.tours.sync'),
            ],
        ],
    ],
    [
        'title' => 'Packages',
        'icon' => 'bx bxs-package',
        'submenu' => [
            [
                'title' => 'All Packages',
                'icon' => 'bx bxs-package',
                'route' => route('admin.packages.index'),
            ],
            [
                'title' => 'Categories',
                'icon' => 'bx bxs-category',
                'route' => route('admin.package-categories.index'),
            ],
            [
                'title' => 'Inquiries',
                'icon' => 'bx bxs-message-dots',
                'route' => route('admin.package-inquiries.index'),
            ],
        ],
    ],
    [
        'title' => 'Layout',
        'icon' => 'bx bxs-cog',
        'submenu' => [
            [
                'title' => 'Logo Management',
                'icon' => 'bx bx-image',
                'route' => route('admin.settings.logo'),
            ],
            [
                'title' => 'Configuration',
                'icon' => 'bx bxs-contact',
                'route' => route('admin.settings.details'),
            ],
        ],
    ],
];
