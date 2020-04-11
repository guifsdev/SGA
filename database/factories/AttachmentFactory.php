<?php

use Faker\Generator as Faker;

$factory->define(App\Attachment::class, function (Faker $faker) {
	$ids = App\Call::all()->pluck('id')->toArray();

	$fileExtension = $faker->fileExtension;
	$originalName = join($faker->words(rand(2,5)), '_').'.'.$fileExtension;

	
    return [
        'call_id' => $ids[rand(0, count($ids) - 1)],
		//'directory' => storage_path('app/calls'),
		'file_name' => uniqid().'.'.$fileExtension,
		'file_original_name' => $originalName,
		'file_type' => $fileExtension,

    ];
});
