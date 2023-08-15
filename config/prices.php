<?php

use IlBronza\Prices\Models\Price;

return [
	'models' => [
		'price' => [
			'class' => Price::class,
			'model' => Price::class,
			'table' => 'prices',
			'fieldsGroupsFiles' => [
                'index' => PriceFieldsGroupParametersFile::class,
			]
		]
	]
];