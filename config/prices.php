<?php

use IlBronza\Prices\Models\Price;

return [
	'models' => [
		'price' => [
			'model' => Price::class,
			'table' => 'prices'
		]
	]
];