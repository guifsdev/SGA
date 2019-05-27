<?php

use Faker\Generator as Faker;

$factory->define(App\Student::class, function (Faker $faker) {
    return [
        //
        'nome' => strtoupper($faker->name),
        'matricula' => $faker->randomNumber($nbDigits = 9, $strict = false),
        'cpf' => $faker->regexify('([0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2})'),
        'cr' => $faker->randomFloat($nbMaxDecimals = 1, $min = 0.0, $max = 10.0), // 48.8932
        'localidade' => 'Niterói',
        'curriculo' => '23.01.004',
        'curso' => 'ADMINISTRAÇÃO',
        'email' => $faker->email,
        'tel' => $faker->phoneNumber,
    ];
});
