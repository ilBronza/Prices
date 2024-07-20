<?php

namespace IlBronza\Prices\Http\Controllers\Prices;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class PriceDestroyController extends PriceCRUD
{
    use CRUDDeleteTrait;

    public $allowedMethods = ['destroy'];

    public function destroy($price)
    {
        $price = $this->findModel($price);

        return $this->_destroy($price);
    }
}