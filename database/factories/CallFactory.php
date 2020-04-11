<?php

use Faker\Generator as Faker;
use App\Call;
//use App\Lib\Settings;

$factory->define(Call::class, function (Faker $faker) {

	$settings = app(App\Lib\Settings::class);

	$issues = $settings->get('calls')['issues'];
	$status = ['Pendente', 'Resolvido', 'Aguardando documentos'];
	$status = $status[rand(0, count($status) - 1)];
	$resolvedAt = $status == 'Resolvido' ? $faker->dateTime() : null;
	$ids = App\Student::all()->pluck('id')->toArray();
    return [
		'student_id' => $ids[rand(0, count($ids) - 1)],
		'issue' => $issues[rand(0, count($issues) - 1)],
		'title' => $faker->sentence($nbWords = 8, $variableNbWords = true),
		'description' => $faker->text($maxNbChars = 200),
		'status' => $status,
		'resolved_at' => $resolvedAt,
    ];
});
