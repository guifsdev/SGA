<?php

return [
	"crawler" => [
		"trigger" => [
			"limit" => 10,
			"measure" => 'months',
		]
	],
	"adjustment" => [
		"date" => [
			"open" => "2020-02-21 10:21:00",
			"close" => "2020-03-20 11:28:40"
		],
		"max_adjustments" => 5,
		"reasons_to_deny" => [
			"Não há vagas",
			"Não possui pré-requisito",
			"Horário em conflito",
			"Outro",
		]
	],
];
