<?php

namespace IlBronza\Prices\Providers;

use Carbon\Carbon;
use IlBronza\Prices\Models\Price;
use IlBronza\Prices\Providers\PriceCreatorHelper;

trait PriceCalculatorHelperGettersTrait
{
	public function getImposedPrice()
	{
		return $this->imposedPrice;
	}

	public function hasImposedPrice() : bool
	{
		return !! $this->getImposedPrice();
	}

	public function getValidFrom() : ? Carbon
	{
		return $this->validFrom;
	}

	public function getValidTo() : ? Carbon
	{
		return $this->validTo;
	}

	// /**
	//  * provide new price replicating the closest old valid one or creating a brand new one
	//  *
	//  * @return Price
	//  **/
	// private function provideNewPrice() : Price
	// {
	// 	if($this->newPrice = $this->replicateAndArchiveCurrentPrice())
	// 		return $this->newPrice;

	// 	return $this->newPrice = $this->createPrice();
	// }

	// private function createPrice() : Price
	// {
	// 	return (new PriceCreatorHelper($this->element))
	// 			->createPrice();
	// }

	// private function replicateAndArchiveCurrentPrice() : ? Price
	// {
	// 	if(! $this->currentPrice)
	// 		return null;

	// 	return (new PriceCreatorHelper($this->element))
	// 			->replicateAndArchivePrice($this->currentPrice);
	// }

	public function getFinalPrice()
	{
		return $this->newPrice->getFinalPrice();
	}
}