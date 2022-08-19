<?php

namespace IlBronza\Prices\Providers;

use Carbon\Carbon;
use IlBronza\Prices\Models\Interfaces\WithPriceInterface;
use IlBronza\Prices\Models\Price;
use IlBronza\Prices\Providers\PriceCalculatorHelper;
use IlBronza\Prices\Providers\PriceCalculatorHelperComputationsTrait;
use IlBronza\Prices\Providers\PriceCalculatorHelperGettersTrait;
use IlBronza\Prices\Providers\PriceCalculatorHelperSettersTrait;
use IlBronza\Prices\Providers\PriceHelpersPriceCreatorTrait;

class PriceCalculatorHelper
{
	use PriceHelpersPriceCreatorTrait;
	use PriceCalculatorHelperSettersTrait;
	use PriceCalculatorHelperGettersTrait;
	use PriceCalculatorHelperComputationsTrait;

	public $element;

	//cost of element before price rule application
	public $cost;

	public $validFrom;
	public $validTo;

	//price in current validity period
	public $currentPrice;

	//new price to calculate
	public $newPrice;

	public $imposedPrice;

	public function __construct(WithPriceInterface $element)
	{
		$this->element = $element;

		$this->currentPrice = $element->getCurrentPrice();
	}

	static function forcePriceCalculation(Price $price)
	{
		$priceCalculator = (new PriceCalculatorHelper($price->element));

		$priceCalculator->setNewPrice($price);

		if($validFrom = $price->element->getValidFrom($price->element))
			$priceCalculator->setValidFrom($validFrom);

		if($validTo = $price->element->getValidTo($price->element))
			$priceCalculator->setValidTo($validTo);

		$priceCalculator->ensureNewPriceModelExists();
	}
}