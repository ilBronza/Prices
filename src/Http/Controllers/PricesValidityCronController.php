<?php

namespace IlBronza\Prices\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

abstract class PricesValidityCronController extends Controller
{
	abstract public function parse();

	public $queryLimit = 200;

	public function getQuerylimit()
	{
		return $this->queryLimit;
	}

	public function getElementsToparse()
	{
		$elementsClass = $this->getElementsClassName();

		return $elementsClass::valid()
				->where('valid_from', '>', Carbon::now())
				->orWhere('valid_to', '<', Carbon::now())->get();
	}

	public function _parse()
	{
		$elements = $this->getElementsToparse(
			$this->getQuerylimit()
		);

		foreach($elements as $element)
			$element->checkTimingValidity();
	}
}