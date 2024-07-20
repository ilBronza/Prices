<?php

namespace IlBronza\Prices\Http\Controllers\Prices;

use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;

class PriceShowController extends PriceCRUD
{
    use CRUDShowTrait;
    use CRUDRelationshipTrait;

    public $allowedMethods = ['show'];

    public function getGenericParametersFile() : ? string
    {
        return config('prices.models.price.parametersFiles.show');
    }

    public function show(string $price)
    {
        $price = $this->findModel($price);

        return $this->_show($price);
    }
}
