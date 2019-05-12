<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;


Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push('Панель управления', route('admin.dashboard'));
});

Breadcrumbs::for('admin.users.index', function ($trail) {
    $trail->push('Пользователи', route('admin.users.index'));
});

Breadcrumbs::for('admin.users.edit', function ($trail, $user) {
    $trail->parent('admin.users.index');
    $trail->push($user->name, route('admin.users.edit', $user));
});