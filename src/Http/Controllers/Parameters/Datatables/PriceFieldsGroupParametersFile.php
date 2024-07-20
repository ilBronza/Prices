<?php

namespace IlBronza\Prices\Http\Controllers\Parameters\Datatables;

use IlBronza\Datatables\Providers\FieldsGroupParametersFile;

class PriceFieldsGroupParametersFile extends FieldsGroupParametersFile
{
	static function getFieldsGroup() : array
	{
		return [
            'translationPrefix' => 'vehicles::fields',
            'fields' => 
            [
                'mySelfPrimary' => 'primary',
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',

                'type' => [
                    'type' => 'links.link',
                    'function' => 'getShowUrl',
                    'textParameter' => 'name',
                    'target' => '_blank',
                    'icon' => false,
                    'width' => '65px'
                ],


                'sellableSuppliers_count' => 'flat',
                'sellable_suppliers_count' => 'flat',

                'name' => 'flat',
                'plate' => 'flat',
                'registered_at' => 'flat',

                'initial_km' => 'flat',
                'current_km' => 'flat',

                'mySelfDelete' => 'links.delete'
            ]
        ];
	}
}