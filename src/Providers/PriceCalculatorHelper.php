<?php

namespace IlBronza\Prices\Providers;

use Carbon\Carbon;
use IlBronza\Prices\Models\Interfaces\WithPriceInterface;
use IlBronza\Prices\Providers\PriceCalculatorHelperGettersTrait;
use IlBronza\Prices\Providers\PriceCalculatorHelperSettersTrait;
use IlBronza\Prices\Providers\PriceHelpersPriceCreatorTrait;

class PriceCalculatorHelper
{
	use PriceHelpersPriceCreatorTrait;
	use PriceCalculatorHelperSettersTrait;
	use PriceCalculatorHelperGettersTrait;

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

	/**
	 * if no newPrice exists, create it by replicating old one or creating a brand new one
	 *
	 * @return void
	+*/
	public function ensureNewPriceModelExists() : void
	{
		if(! $this->newPrice)
			$this->provideNewPrice();
	}

	private function manageImposedPrice()
	{
		if(! $this->hasImposedPrice())
			return ;

		$this->newPrice->imposed_price = $this->getImposedPrice();
		$this->newPrice->calculated = true;
		$this->newPrice->calculated_at = Carbon::now();
	}

	private function calculatePrice() : void
	{
		$this->newPrice->fill(
			$this->element->calculatePriceData()
				->toArray()
		);

		$this->manageImposedPrice();

		$this->newPrice->save();
	}

	private function setValidity(bool $save = false)
	{
		if($validTo = $this->getValidTo())
			$this->newPrice->valid_to = $validTo;

		if($validFrom = $this->getValidFrom())
			$this->newPrice->valid_from = $validFrom;

		if($save)
			$this->newPrice->save();

		$this->newPrice->checkTimingValidity();
	}

	public function calculate() : ? float
	{
		$this->ensureNewPriceModelExists();

		$this->calculatePrice();

		$this->setValidity($save = true);

		return $this->getFinalPrice();
	}

	public function assignImposedPrice(float $imposedPrice)
	{
		$this->setImposedPrice($imposedPrice);

		return $this->calculate();
	}
}