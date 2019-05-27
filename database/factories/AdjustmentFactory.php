<?php

use Faker\Generator as Faker;

$factory->define(App\Adjustment::class, function (Faker $faker) {
    return [
    	'student_id' => $faker->numberBetween(1, 586),
        'email' => $faker->email,
        'subject_id' => $faker->numberBetween(1, 65),
        //randomElements($array = array ('a','b','c'), $count = 1) // array('c')
        'action' => $faker->randomElement(['incluir', 'excluir'], 1),
        'result' => 'Pendente',
    ];
});
