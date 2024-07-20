<?php

namespace IlBronza\Prices\Http\Controllers\Parameters\RelationshipsManagers;

use IlBronza\CRUD\Providers\RelationshipsManager\RelationshipsManager;

class PriceRelationshipsManager Extends RelationshipsManager
{
	public  function getAllRelationsParameters() : array
	{
		$element = $this->getModel()->getElement();

		$configPrefix = $element->getPackageConfigPrefix();
		$modelPrefix = $element->getModelConfigPrefix();

		$relations['element'] = config("{$configPrefix}.models.{$modelPrefix}.controllers.show");

		return [
			'show' => [
				'relations' => $relations
			]
		];
	}
}