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
        'title' => 'Packages',
        'icon' => 'bx bxs-package',
        'submenu' => [
            [
                'title' => 'Package Categories',
                'icon' => 'bx bxs-category',
                'route' => route('admin.package-categories.index'),
            ],
            [
                'title' => 'Package Inquiries',
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
