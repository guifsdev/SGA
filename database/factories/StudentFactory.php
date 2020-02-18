<?php

use Faker\Generator as Faker;

$factory->define(App\Student::class, function (Faker $faker) {
	$percentageCompleted = $faker->randomFloat(2, 0, 100);
    return [
        //
        'enrolment_number' => $faker->randomNumber($nbDigits = 9, $strict = false),
        'first_name' => strtoupper($faker->firstName),
        'last_name' => strtoupper($faker->lastName),
        'cpf' => $faker->regexify('([0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2})'),
        'cell_phone_number' => $faker->phoneNumber,
        'email_primary' => $faker->email,
        'email_secondary' => $faker->email,
        'curriculum' => '2301004',
		'total_workload' => 3000,
		'obtained_workload' => $faker->numberBetween($min = 0, $max = 3000),
		'attended_workload' => $faker->numberBetween($min = 0, $max = 3000),
		'percentage_completed' => $percentageCompleted,
		'performance_coeficient' => $faker->randomFloat(2, 0, 10),
		'current_status' => $percentageCompleted < 100 ? 'Cursando' : 'Formado',
		'crawled_at' => $faker->dateTime(),
    ];
});
