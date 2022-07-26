<?php

namespace IlBronza\Prices\Providers;

use Carbon\Carbon;

trait PriceCalculatorHelperSettersTrait
{
	public function setValidTo(Carbon $validTo) : self
	{
		$this->validTo = $validTo;

		return $this;
	}

	public function setCost(float $cost) : self
	{
		$this->cost = $cost;

		return $this;
	}

	public function setValidFrom(Carbon $validFrom) : self
	{
		$this->validFrom = $validFrom;

		return $this;
	}

	public function setImposedPrice(float $imposedPrice)
	{
		$this->imposedPrice = $imposedPrice;
	}
}