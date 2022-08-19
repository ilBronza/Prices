<?php

namespace IlBronza\Prices\Providers;

use IlBronza\Prices\Models\Price;
use IlBronza\Prices\Providers\PriceCreatorHelper;

trait PriceHelpersPriceCreatorTrait
{
	/**
	 * provide new price replicating the closest old valid one or creating a brand new one
	 *
	 * @return Price
	 **/
	private function provideNewPrice() : Price
	{
		if(($this->currentPrice)&&(! $this->currentPrice->isCalculated()))
			return $this->newPrice = $this->currentPrice;

		if($this->newPrice = $this->replicateAndArchiveCurrentPrice())
			return $this->newPrice;

		return $this->newPrice = $this->createPrice();
	}

	private function createPrice() : Price
	{
		return (new PriceCreatorHelper($this->element))
				->createPrice();
	}

	private function replicateAndArchiveCurrentPrice() : ? Price
	{
		if(! $this->currentPrice)
			return null;

		return (new PriceCreatorHelper($this->element))
				->replicateAndArchivePrice($this->currentPrice);
	}
}