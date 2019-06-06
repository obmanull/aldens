<?php

use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Entities\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\Entities\User::class, function (Faker $faker) {
    $active = false;
    return [
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$12$eSyuSRBTxi42WJqem4XIXOejvSMsbm8rUPLKzxQGkKj1CNf0PIXJa', // 12345678
        'remember_token' => str_random(10),
        'role' => User::ROLE_USER
    ];
});