<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('user.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('user.dashboard'));
});

Breadcrumbs::for('user.profile.changePassword', function (BreadcrumbTrail $trail) {
    $trail->parent('user.dashboard');
    $trail->push('Change Password', route('user.profile.changePassword'));
});

Breadcrumbs::for('user.orders.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user.dashboard');
    $trail->push('My Orders', route('user.orders.index'));
});

Breadcrumbs::for('user.orders.show', function (BreadcrumbTrail $trail, $order) {
    $trail->parent('user.orders.index');
    $trail->push($order->order_number, route('user.orders.show', $order->id));
});

Breadcrumbs::for('user.orders.pay-again', function (BreadcrumbTrail $trail, $order) {
    $trail->parent('user.orders.show', $order);
    $trail->push('Pay Now', route('user.orders.pay-again', $order->id));
});
