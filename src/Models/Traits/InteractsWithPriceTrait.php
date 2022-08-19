<?php

namespace IlBronza\Prices\Models\Traits;

use Carbon\Carbon;
use IlBronza\Prices\Models\Price;
use IlBronza\Prices\Providers\PriceData;

trait InteractsWithPriceTrait
{
	abstract function getPriceModelClassName() : string;

	public function calculatePriceData() : PriceData
	{
		$priceData = new PriceData();

		try
		{
			$priceData = $this->_calculatePriceData($priceData);

			$priceData->calculated = true;
		}
		catch(\Throwable $e)
		{
			$this->_manageCalculationErrors($e);

			$priceData->message = $e->getMessage();
			$priceData->price = null;
		}

		$priceData->calculatedAt = Carbon::now();

		return $priceData;
	}

	public function getPriceReplicateAttributes(Price $price)
	{
		$modelAttributes = $this->getPriceBaseAttributes();
		$priceAttributes = $price->getPriceReplicateAttributes();

		return $priceAttributes + $modelAttributes;
	}

	public function getMorphClass()
	{
		return $this->getPriceRelatedClassName();
	}

	public function price()
	{
		return $this->morphOne(
			$this->getPriceModelClassName(),
			'priceable'
		)->valid();
	}

	public function priceToCalculate()
	{
		return $this->morphOne(
			$this->getPriceModelClassName(),
			'priceable'
		)->toCalculate();
	}

	public function prices()
	{
		return $this->morphMany(
			$this->getPriceModelClassName(),
			'priceable'
		);
	}

	public function getCurrentPrice()
	{
		return $this->price ?? $this->priceToCalculate;
	}

	private function getLastSequence() : int
	{
		if($price = $this->prices()->withoutRestrictions()->orderBy('sequence', 'DESC')->first())
			return $price->getSequence();

		return 0;
	}

	public function getPriceSequence()
	{
		return $this->getLastSequence() + 1 ;
	}

	public function getPriceValue()
	{
		if(! $this->price)
			return null;

		return $this->price->getPriceValue();
	}
}