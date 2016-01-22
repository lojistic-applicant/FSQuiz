<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\JobOpening::class, function (Faker\Generator $faker) {
    return [
        'title'          => str_replace(',', '', $faker->sentence(mt_rand(2, 4))),
        'is_available'   => mt_rand(0, 3) ? 1 : 0 // 75% chance to be open
    ];
});

$factory->define(App\Applicant::class, function (Faker\Generator $faker) {
    $githubId = str_replace('.', '', $faker->sentence(1) . " " . mt_rand(333,999));
    return [
        'name'             => $faker->name,
        'email'            => $faker->email,
        'phone'            => $faker->phoneNumber,
        'github_id'        => strtolower(str_replace(" ", "-", $githubId)),
        'position_id'      => mt_rand(2, 5),
        'invitation_date'  => $faker->dateTimeBetween('-1 month', 'now'),
        'submission_date'  => $faker->dateTimeBetween('-1 month', 'now')
    ];
});
