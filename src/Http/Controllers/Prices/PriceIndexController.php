<?php

namespace IlBronza\Prices\Http\Controllers\Prices;

use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;

class PriceIndexController extends CRUD
{
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;

    public $configModelClassName = 'price';

    public function getRouteBaseNamePrefix() : ? string
    {
        return config('products.routePrefix');
    }

    public function setModelClass()
    {
        $this->modelClass = config("prices.models.{$this->configModelClassName}.class");
    }

    public function getRelatedFieldsArray()
    {
        return config('prices.models.price.fieldsGroupsFiles.index')::getFieldsGroup();
    }

}