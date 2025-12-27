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

Breadcrumbs::for('admin.tours.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage Tours', route('admin.tours.index'));
});

Breadcrumbs::for('admin.tours.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.tours.index');
    $trail->push('Add New Tour', route('admin.tours.create'));
});

Breadcrumbs::for('admin.tours.edit', function (BreadcrumbTrail $trail, $tour) {
    $trail->parent('admin.tours.index');
    $trail->push('Edit Tour', route('admin.tours.edit', $tour));
});

Breadcrumbs::for('admin.tours.sync', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Sync Tours', route('admin.tours.sync'));
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

Breadcrumbs::for('admin.packages.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage Packages', route('admin.packages.index'));
});

Breadcrumbs::for('admin.packages.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.packages.index');
    $trail->push('Add New Package', route('admin.packages.create'));
});

Breadcrumbs::for('admin.packages.edit', function (BreadcrumbTrail $trail, $package) {
    $trail->parent('admin.packages.index');
    $trail->push('Edit Package', route('admin.packages.edit', $package));
});
