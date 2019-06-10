<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;


Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Authorization

// Home / Register
Breadcrumbs::for('register', function ($trail) {
    $trail->parent('home');
    $trail->push('Register', route('register'));
});

// Home / Login
Breadcrumbs::for('login', function ($trail) {
    $trail->parent('home');
    $trail->push('Login', route('login'));
});

// Home / Reset password
Breadcrumbs::for('password.request', function ($trail) {
    $trail->parent('home');
    $trail->push('Reset password', route('password.request'));
});

// Home / Reset password
Breadcrumbs::for('password.reset', function ($trail, $token) {
    $trail->parent('home');
    $trail->push('Reset password', route('password.reset', 'token'));
});

// Cabinet

// Home / Cabinet
Breadcrumbs::for('cabinet.dashboard.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Cabinet', route('cabinet.dashboard.index'));
});

// Home / Profile
Breadcrumbs::for('cabinet.profile.index', function ($trail) {
    $trail->parent('cabinet.dashboard.index');
    $trail->push('Profile', route('cabinet.profile.index'));
});

// Home / Profile / Edit
Breadcrumbs::for('cabinet.profile.edit', function ($trail) {
    $trail->parent('cabinet.profile.index');
    $trail->push('Edit', route('cabinet.profile.edit'));
});


// Admin panel

// Home / Admin
Breadcrumbs::for('admin.dashboard.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Admin', route('admin.dashboard.index'));
});

// Users

// Home / Admin / Users
Breadcrumbs::for('admin.users.index', function ($trail) {
    $trail->parent('admin.dashboard.index');
    $trail->push('Users', route('admin.users.index'));
});

// Home / Admin / Users / Create
Breadcrumbs::for('admin.users.create', function ($trail) {
    $trail->parent('admin.users.index');
    $trail->push('Create', route('admin.users.create'));
});

// Home / Admin / Users / {user}
Breadcrumbs::for('admin.users.edit', function ($trail, $user) {
    $trail->parent('admin.users.index');
    $trail->push($user->name, route('admin.users.edit', $user));
});

// Categories

// Home / Admin / Category
Breadcrumbs::for('admin.categories.index', function ($trail) {
    $trail->parent('admin.dashboard.index');
    $trail->push('Category', route('admin.categories.index'));
});

// Home / Admin / Category / [category]
Breadcrumbs::for('admin.categories.show', function ($trail, $category) {
    if ($parent = $category->parent) {
        $trail->parent('admin.categories.show', $parent);
    } else {
        $trail->parent('admin.categories.index');
    }
    $trail->push($category->name, route('admin.categories.show', $category));
});

// Home / Admin / Category / [category] / Add attribute
Breadcrumbs::for('admin.categories.attributes.create', function ($trail, $category) {
    $trail->parent('admin.categories.show', $category);
    $trail->push('Add attribute', route('admin.categories.attributes.create', $category));
});

// Home / Admin / Category / [category] / Edit attribute
Breadcrumbs::for('admin.categories.attributes.edit', function ($trail, $category, $attribute) {
    $trail->parent('admin.categories.show', $category);
    $trail->push('Edit attribute', route('admin.categories.attributes.edit', [$category, $attribute]));
});

// Home / Admin / Category / [category] / Edit
Breadcrumbs::for('admin.categories.edit', function ($trail, $category) {
    $trail->parent('admin.categories.show', $category);
    $trail->push('Edit', route('admin.categories.edit', $category));
});

// Home / Admin / Category / Create
Breadcrumbs::for('admin.categories.create', function ($trail) {
    $trail->parent('admin.categories.index');
    $trail->push('Create', route('admin.categories.create'));
});