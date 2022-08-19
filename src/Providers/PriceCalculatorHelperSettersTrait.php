<?php

namespace IlBronza\Prices\Providers;

use Carbon\Carbon;
use IlBronza\Prices\Models\Price;

trait PriceCalculatorHelperSettersTrait
{
	public function setValidTo(Carbon $validTo = null) : self
	{
		$this->validTo = $validTo;

		return $this;
	}

	public function setCost(float $cost) : self
	{
		$this->cost = $cost;

		return $this;
	}

	public function setValidFrom(Carbon $validFrom = null) : self
	{
		$this->validFrom = $validFrom;

		return $this;
	}

	public function setImposedPrice(float $imposedPrice) : self
	{
		$this->imposedPrice = $imposedPrice;

		return $this;
	}

	public function setNewPrice(Price $newPrice) : self
	{
		$this->newPrice = $newPrice;

		return $this;
	}
}