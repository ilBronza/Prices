<?php

namespace IlBronza\Prices\Providers\DatatablesFields;

use IlBronza\Datatables\DatatablesFields\DatatableField;

class DatatableFieldPricesList extends DatatableField
{
	public $function = 'getAssignBulkSellableSupplierToQuotationrowUrl';
	public ?string $translationPrefix = 'products::datatableFields';

	public function transformValue($value)
	{
		if(! $value)
			return ;

		$result = [];

		foreach($value as $price)
			$result[$price->collection_id] = $price->collection_id . ': ' . $price->price;

		return implode('<br />', $result);
	}

}