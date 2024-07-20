<?php

namespace IlBronza\Prices\Http\Controllers\Prices;

use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use Illuminate\Http\Request;

class PriceEditUpdateController extends PriceCRUD
{
    use CRUDEditUpdateTrait;

    public $allowedMethods = ['edit', 'update'];

    public function getGenericParametersFile() : ? string
    {
        return config('prices.models.price.parametersFiles.create');
    }

    public function edit(string $price)
    {
        $price = $this->findModel($price);

        return $this->_edit($price);
    }

    public function update(Request $request, $price)
    {
        $price = $this->findModel($price);

        return $this->_update($request, $price);
    }
}
