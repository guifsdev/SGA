<?php

use Faker\Generator as Faker;

$factory->define(App\Attachment::class, function (Faker $faker) {
	$ids = App\Call::all()->pluck('id')->toArray();
	
    return [
        'call_id' => $ids[rand(0, count($ids) - 1)],
		'directory' => storage_path('app/calls'),
		'file_name' => uniqid(),
		'file_type' => $faker->fileExtension,

    ];
});
