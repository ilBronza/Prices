<?php

namespace IlBronza\Prices\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use IlBronza\Prices\Models\Interfaces\WithPriceInterface;
use IlBronza\Prices\Providers\PriceCalculatorHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

abstract class ElementsPriceCronController extends Controller
{
	abstract public function getValidFrom(WithPriceInterface $element) : ? Carbon;
	abstract public function getValidTo(WithPriceInterface $element) : ? Carbon;
	abstract public function elementQuery() : Builder;

	abstract public function parse();

	public $queryLimit = 200;
	public $calculatedAtDelaySeconds = 3600 * 24;

	public function getQuerylimit() : ? int
	{
		return $this->queryLimit;
	}

	public function getCalculatedAtSecondsDelay() : int
	{
		return $this->calculatedAtDelaySeconds;
	}

	public function getCalculatedAtDate() : Carbon
	{
		return Carbon::now()->subSeconds(
			$this->getCalculatedAtSecondsDelay()
		);
	}

	public function getWithLimit(Builder $elementsQuery) : Collection
	{
		if($queryLimit = $this->getQuerylimit())
			$elementsQuery->take($queryLimit);

		return $elementsQuery->get();
	}

	public function getMissingElementsToParse() : Collection
	{
		$elementsQuery = $this->elementQuery()
				->doesntHave('price');

		return $this->getWithLimit($elementsQuery);
	}

	public function getNewElementsToParse() : Collection
	{
		$elementsQuery = $this->elementQuery()
				->whereHas('price', function($query)
				{
					return $query->toCalculate();
					// return $query->where(function($_query)
					// 	{
					// 		return $_query->where('calculated', false)
					// 					->orWhereNull('calculated');
					// 	});
					//->where('calculated_at', '>', $this->getCalculatedAtDate());
				});

		return $this->getWithLimit($elementsQuery);
	}


	// public function getElementsToParse(int $queryLimit = null)
	// {
	// 	$elementsClass = $this->getElementsClassName();

	// 	$elementsQuery = $elementsClass::inRandomOrder()
	// 			->with('manufacturer.manufacturerWaves', 'cardboard.wave')
	// 			->doesntHave('price')
	// 			->orWhereHas('price', function($query)
	// 			{
	// 				return $query->where(function($_query)
	// 					{
	// 						return $_query->where('calculated', false)
	// 									->orWhereNull('calculated');	
	// 					})->where('calculated_at', '>', $this->getCalculatedAtDate());
	// 			});

	// 	if($queryLimit)
	// 		$elementsQuery->take($queryLimit);

	// 	return $elementsQuery->get();
	// }

	// public function _parse()
	// {
	// 	$elements = $this->getElementsToParse();

	// 	foreach($elements as $element)
	// 	{
	// 		$price = (new PriceCalculatorHelper($element));

	// 		if($validFrom = $this->getValidFrom($element))
	// 			$price->setValidFrom($validFrom);

	// 		if($validTo = $this->getValidTo($element))
	// 			$price->setValidTo($validTo);

	// 		$price->calculate();
	// 	}
	// }

	public function parseNew()
	{
		$elements = $this->getNewElementsToParse();

		mori($elements);
	}

	public function parseMissing()
	{
		$elements = $this->getMissingElementsToParse();

		foreach($elements as $element)
		{
			$price = (new PriceCalculatorHelper($element));

			if($validFrom = $this->getValidFrom($element))
				$price->setValidFrom($validFrom);

			if($validTo = $this->getValidTo($element))
				$price->setValidTo($validTo);

			$price->calculate();
		}		
	}
}
