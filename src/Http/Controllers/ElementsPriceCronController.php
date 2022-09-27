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
				->with('priceToCalculate')
				->whereHas('priceToCalculate');

		return $this->getWithLimit($elementsQuery);
	}

	public function addValidations(WithPriceInterface $element)
	{
		if($validFrom = $this->getValidFrom($element))
			$this->price->setValidFrom($validFrom);

		if($validTo = $this->getValidTo($element))
			$this->price->setValidTo($validTo);
	}

	// public function parseNew()
	public function parseNewPrices()
	{
		$elements = $this->getNewElementsToParse();

		foreach($elements as $element)
		{
			$this->price = (new PriceCalculatorHelper($element))
					->setNewPrice($element->priceToCalculate);

			$this->addValidations($element);

			$this->price->calculate();
		}
	}

	public function parseMissing()
	{
		$elements = $this->getMissingElementsToParse();

		foreach($elements as $element)
		{
			$this->price = (new PriceCalculatorHelper($element));

			$this->addValidations($element);

			$this->price->calculate();
		}
	}
}
