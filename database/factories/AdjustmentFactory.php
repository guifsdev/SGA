<?php

use Faker\Generator as Faker;
use App\Subject;

$factory->define(App\Adjustment::class, function (Faker $faker) {
	$subject = Subject::all()->random();
    return [
    	'student_id' => $faker->numberBetween(1, 16),
		'subject_code' => $subject['code'],
		'subject_class_name' => $subject['class_name'],
        'action' => $faker->randomElement(['Incluir', 'Excluir'], 1),
		'signature' => md5(uniqid(rand(), true)),
        'result' => 'Pendente',
    ];
});
