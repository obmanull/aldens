<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;


Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->parent('home');
    $trail->push('Admin', route('admin.dashboard'));
});


// Users

Breadcrumbs::for('admin.users.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Users', route('admin.users.index'));
});

Breadcrumbs::for('admin.users.edit', function ($trail, $user) {
    $trail->parent('admin.users.index');
    $trail->push($user->name, route('admin.users.edit', $user));
});

// Categories

Breadcrumbs::for('admin.categories.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Category', route('admin.categories.index'));
});

Breadcrumbs::for('admin.categories.show', function ($trail, $category) {
    if ($parent = $category->parent) {
        $trail->parent('admin.categories.show', $parent);
    } else {
        $trail->parent('admin.categories.index');
    }
    $trail->push($category->name, route('admin.categories.show', $category));
});

Breadcrumbs::for('admin.categories.edit', function ($trail, $category) {
    $trail->parent('admin.categories.index');
    $trail->push($category->name, route('admin.categories.edit', $category));
});

Breadcrumbs::for('admin.categories.create', function ($trail) {
    $trail->parent('admin.categories.index');
    $trail->push('Create', route('admin.categories.create'));
});