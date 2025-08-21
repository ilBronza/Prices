<?php

namespace IlBronza\Prices\Http\Controllers\Prices;

use IlBronza\CRUD\Http\Controllers\Traits\StandardTraits\PackageStandardIndexTrait;
use IlBronza\Prices\Http\Controllers\Prices\PriceCRUD;

class PriceIndexController extends PriceCRUD
{
    use PackageStandardIndexTrait;

    public $allowedMethods = ['index'];

    public function getIndexElementsRelationsArray() : array
    {
        return [];
    }

    public function getIndexElements()
    {
        ini_set('max_execution_time', '120');
        ini_set('memory_limit', "-1");

        return $this->getModelClass()::all();
    }
}