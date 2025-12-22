<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

Breadcrumbs::for('admin.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage Users', route('admin.users.index'));
});

Breadcrumbs::for('admin.newsletters.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Newsletter', route('admin.newsletters.index'));
});

Breadcrumbs::for('admin.inquiries.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Inquiries', route('admin.inquiries.index'));
});

Breadcrumbs::for('admin.banners.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage Banners', route('admin.banners.index'));
});

Breadcrumbs::for('admin.banners.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.banners.index');
    $trail->push('Add New Banner', route('admin.banners.create'));
});

Breadcrumbs::for('admin.banners.edit', function (BreadcrumbTrail $trail, $banner) {
    $trail->parent('admin.banners.index');
    $trail->push('Edit Banner', route('admin.banners.edit', $banner));
});

Breadcrumbs::for('admin.package-categories.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage Package Categories', route('admin.package-categories.index'));
});

Breadcrumbs::for('admin.package-categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.package-categories.index');
    $trail->push('Add New Package Category', route('admin.package-categories.create'));
});

Breadcrumbs::for('admin.package-categories.edit', function (BreadcrumbTrail $trail, $packageCategory) {
    $trail->parent('admin.package-categories.index');
    $trail->push('Edit Package Category', route('admin.package-categories.edit', $packageCategory));
});

Breadcrumbs::for('admin.package-inquiries.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Package Inquiries', route('admin.package-inquiries.index'));
});

Breadcrumbs::for('admin.package-inquiries.show', function (BreadcrumbTrail $trail, $packageInquiry) {
    $trail->parent('admin.package-inquiries.index');
    $trail->push('Inquiry Details', route('admin.package-inquiries.show', $packageInquiry));
});
