<?php

use Faker\Generator as Faker;

$factory->define(App\Student::class, function (Faker $faker) {
    return [
        //
        'name' => strtoupper($faker->name),
        'email' => $faker->email,
        'enrolment_number' => $faker->randomNumber($nbDigits = 9, $strict = false),
        'cpf' => $faker->regexify('([0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2})'),
        'celphone_number' => $faker->phoneNumber,
        'course' => 'administração',
        'locality' => 'niterói',
        'curriculum' => '2301004',
        'cr' => $faker->randomFloat($nbMaxDecimals = 1, $min = 0.0, $max = 10.0), // 48.8932
		'cha' => $faker->numberBetween($min = 0, $max = 3400),
		'chc' => $faker->numberBetween($min = 0, $max = 3400),
		'cht' => $faker->numberBetween($min = 0, $max = 3400),
		'chs' => $faker->numberBetween($min = 0, $max = 3400),
		'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', //secret
    ];
});
