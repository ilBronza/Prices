<?php

namespace IlBronza\Prices\Http\Controllers\Prices;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
// use IlBronza\CRUD\Traits\CRUDShowTrait;

class PriceCreateStoreController extends PriceCRUD
{
    use CRUDCreateStoreTrait;
    // use CRUDShowTrait;
    use CRUDRelationshipTrait;

    public $allowedMethods = [
        'create',
        'store',
        // 'edit',
        // 'update',
        // 'show'
    ];

    public function getGenericParametersFile() : ? string
    {
        return config('prices.models.price.parametersFiles.create');
    }

    // public function getRelationshipsManagerClass()
    // {
    //     return config("prices.models.{$this->configModelClassName}.relationshipsManagerClasses.show");
    // }

    // public function show(string $price)
    // {
    //     $price = $this->findModel($price);

    //     return $this->_show($price);
    // }
}
