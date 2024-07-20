<?php

namespace IlBronza\Prices\Http\Controllers\Parameters\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class PriceGenericFieldsetsParameters extends FieldsetParametersFile
{
    public function _getFieldsetsParameters() : array
    {
        return [
            'package' => [
                'translationPrefix' => 'prices::fields',
                'fields' => [
                    'price' => ['number' => 'numeric|required|min:0'],
                    'own_cost' => ['number' => 'numeric|nullable|min:0'],
                    'cost' => ['number' => 'numeric|nullable|min:0'],
                    'imposed_price' => ['number' => 'numeric|nullable|min:0']
                ],
                'width' => ["1-3@l", '1-2@m']
            ]
        ];
    }
}
