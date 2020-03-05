<?php

use Faker\Generator as Faker;
use App\Call;

$factory->define(Call::class, function (Faker $faker) {
	$status = ['Pendente', 'Resolvido', 'Aguardando documentos'];
	$ids = App\Student::all()->pluck('id')->toArray();
    return [
		'student_id' => $ids[rand(0, count($ids) - 1)],
		'issue' => $faker->sentence($nbWords = 6, $variableNbWords = true),
		'title' => $faker->sentence($nbWords = 8, $variableNbWords = true),
		'description' => $faker->text($maxNbChars = 200),
		'status' => $status[rand(0, count($status) - 1)],
		'resolved_at' => $faker->dateTime(),
    ];
});
