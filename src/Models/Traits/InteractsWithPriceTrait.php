<?php

namespace IlBronza\Prices\Models\Traits;

use Carbon\Carbon;
use IlBronza\Prices\Models\Price;
use IlBronza\Prices\Providers\PriceCreatorHelper;
use IlBronza\Prices\Providers\PriceData;
use Illuminate\Support\Collection;

use function array_filter;
use function dd;
use function strpos;

trait InteractsWithPriceTrait
{
	public function getPriceModelClassName() : string
	{
		return Price::getProjectClassName();
	}

	public function getPriceExtraFieldsCasts() : array
	{
		return array_filter($this->getCasts(), function ($item)
		{
			if (strpos($item, 'CastFieldPrice') !== false)
				return true;

			return false;
		});
	}

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

	public function getPriceByCollectionId(string $collectionId) : ? Price
	{
		if($this->relationLoaded('prices'))
		{
			if($price = $this->prices->where('collection_id', $collectionId)->first())
				return $price;

			return null;
		}

		if($result = $this->prices()->where('collection_id', $collectionId)->latest()->first())
		{
			$this->setRelation($collectionId, $result);

			return $result;
		}

		return null;
	}

	public function providePriceByCollectionId(string $collectionId) : ? Price
	{
		if($price = $this->getPriceByCollectionId($collectionId))
			return $price;

		$price = (new PriceCreatorHelper($this))->createPrice();

		$price->setCollectionId($collectionId);
		$price->save();

		$this->setRelation($collectionId, $price);

		return $price;
	}

	public function getPriceReplicateAttributes(Price $price)
	{
		$modelAttributes = $this->getPriceBaseAttributes();
		$priceAttributes = $price->getPriceReplicateAttributes();

		return $priceAttributes + $modelAttributes;
	}

	// public function getMorphClass()
	// {
	// 	return $this->getPriceRelatedClassName();
	// }

	public function directPrice()
	{
		return $this->belongsTo(
			$this->getPriceModelClassName(),
			'price_id'
		);
	}

	public function getDirectPrice() : ? Price
	{
		return $this->directPrice;
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

	public function getPrices() : Collection
	{
		return $this->prices;
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

	public function getDirectPriceValue()
	{
		return $this->getDirectPrice()?->getPrice();
	}

	public function getPriceValue()
	{
		if(! $this->price)
			return null;

		return $this->price->getPriceValue();
	}


	public function setPriceByCollectionId(string $collectionId, float $value = null)
	{
		$price = $this->providePriceByCollectionId($collectionId);

		$price->price = $value;

		$price->saveQuietly();
	}
}