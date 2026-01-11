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

Breadcrumbs::for('admin.tour-categories.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage Tour Categories', route('admin.tour-categories.index'));
});

Breadcrumbs::for('admin.tour-categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.tour-categories.index');
    $trail->push('Add New Tour Category', route('admin.tour-categories.create'));
});

Breadcrumbs::for('admin.tour-categories.edit', function (BreadcrumbTrail $trail, $tourCategory) {
    $trail->parent('admin.tour-categories.index');
    $trail->push('Edit Tour Category', route('admin.tour-categories.edit', $tourCategory));
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

Breadcrumbs::for('admin.coupons.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage Coupons', route('admin.coupons.index'));
});

Breadcrumbs::for('admin.coupons.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.coupons.index');
    $trail->push('Add New Coupon', route('admin.coupons.create'));
});

Breadcrumbs::for('admin.coupons.edit', function (BreadcrumbTrail $trail, $coupon) {
    $trail->parent('admin.coupons.index');
    $trail->push('Edit Coupon', route('admin.coupons.edit', $coupon));
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

Breadcrumbs::for('admin.tour-reviews.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Reviews', route('admin.tour-reviews.index'));
});
Breadcrumbs::for('admin.tour-reviews.edit', function (BreadcrumbTrail $trail, $item) {
    $trail->parent('admin.tour-reviews.index');
    $trail->push($item->title ?? 'N/A', route('admin.tour-reviews.edit', $item->id));
});

Breadcrumbs::for('admin.orders.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Orders', route('admin.orders.index'));
});

Breadcrumbs::for('admin.orders.show', function (BreadcrumbTrail $trail, $order) {
    $trail->parent('admin.orders.index');
    $trail->push('Order ' . $order->order_number, route('admin.orders.show', $order->id));
});

Breadcrumbs::for('admin.travel-insurances.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Travel Insurance Bookings', route('admin.travel-insurances.index'));
});

Breadcrumbs::for('admin.travel-insurances.show', function (BreadcrumbTrail $trail, $insurance) {
    $trail->parent('admin.travel-insurances.index');
    $trail->push('Insurance ' . $insurance->insurance_number, route('admin.travel-insurances.show', $insurance->id));
});

Breadcrumbs::for('admin.countries.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage Countries', route('admin.countries.index'));
});

Breadcrumbs::for('admin.countries.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.countries.index');
    $trail->push('Add New Country', route('admin.countries.create'));
});

Breadcrumbs::for('admin.countries.edit', function (BreadcrumbTrail $trail, $country) {
    $trail->parent('admin.countries.index');
    $trail->push('Edit Country', route('admin.countries.edit', $country));
});

Breadcrumbs::for('admin.provinces.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage Provinces', route('admin.provinces.index'));
});

Breadcrumbs::for('admin.provinces.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.provinces.index');
    $trail->push('Add New Province', route('admin.provinces.create'));
});

Breadcrumbs::for('admin.provinces.edit', function (BreadcrumbTrail $trail, $province) {
    $trail->parent('admin.provinces.index');
    $trail->push('Edit Province', route('admin.provinces.edit', $province));
});

Breadcrumbs::for('admin.locations.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage Locations', route('admin.locations.index'));
});

Breadcrumbs::for('admin.locations.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.locations.index');
    $trail->push('Add New Location', route('admin.locations.create'));
});

Breadcrumbs::for('admin.locations.edit', function (BreadcrumbTrail $trail, $location) {
    $trail->parent('admin.locations.index');
    $trail->push('Edit Location', route('admin.locations.edit', $location));
});

Breadcrumbs::for('admin.hotels.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage Hotels', route('admin.hotels.index'));
});

Breadcrumbs::for('admin.hotels.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.hotels.index');
    $trail->push('Add New Hotel', route('admin.hotels.create'));
});

Breadcrumbs::for('admin.hotels.edit', function (BreadcrumbTrail $trail, $hotel) {
    $trail->parent('admin.hotels.index');
    $trail->push('Edit Hotel', route('admin.hotels.edit', $hotel));
});
