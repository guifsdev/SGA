<?php

use Faker\Generator as Faker;

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

$factory->define(App\Requerimento::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'matricula' => $faker->unique()->randomDigit,
        'disciplina' => $faker->randomElement(['Teorias da Administração', 'Processo Decisório', 'Economia', 'Politica']),
        'periodo' => $faker->randomElement([1,2,3,4,5,6,7,8]),
        'acao' => $faker->randomElement(['incluir','excluir'])

    ];
});
