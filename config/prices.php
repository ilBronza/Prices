<?php

use IlBronza\Prices\Http\Controllers\Parameters\Datatables\PriceFieldsGroupParametersFile;
use IlBronza\Prices\Http\Controllers\Parameters\Fieldsets\PriceGenericFieldsetsParameters;
use IlBronza\Prices\Http\Controllers\Parameters\RelationshipsManagers\PriceRelationshipsManager;
use IlBronza\Prices\Http\Controllers\Prices\PriceCreateStoreController;
use IlBronza\Prices\Http\Controllers\Prices\PriceDestroyController;
use IlBronza\Prices\Http\Controllers\Prices\PriceEditUpdateController;
use IlBronza\Prices\Http\Controllers\Prices\PriceIndexController;
use IlBronza\Prices\Http\Controllers\Prices\PriceShowController;
use IlBronza\Prices\Models\Price;

return [
	'models' => [
		'price' => [
			'class' => Price::class,
			'model' => Price::class,
			'table' => 'prices__prices',
			'fieldsGroupsFiles' => [
                'index' => PriceFieldsGroupParametersFile::class,
			],
            'parametersFiles' => [
                'create' => PriceGenericFieldsetsParameters::class,
                'edit' => PriceGenericFieldsetsParameters::class,
                'show' => PriceGenericFieldsetsParameters::class
            ],
            'relationshipsManagerClasses' => [
                'show' => PriceRelationshipsManager::class
            ],
            'controllers' => [
                'index' => PriceIndexController::class,
                'create' => PriceCreateStoreController::class,
                'store' => PriceCreateStoreController::class,
                'show' => PriceShowController::class,
                'edit' => PriceEditUpdateController::class,
                'update' => PriceEditUpdateController::class,
                'destroy' => PriceDestroyController::class,
            ]
		]
	]
];