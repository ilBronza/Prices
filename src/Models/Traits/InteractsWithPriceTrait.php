<?php

namespace IlBronza\Prices\Models\Traits;

use IlBronza\Prices\Models\Price;


trait InteractsWithPriceTrait
{
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

	public function prices()
	{
		return $this->morphMany(Price::class, 'priceable');
	}

	public function getCurrentPrice()
	{
		return $this->prices()->valid()->first();
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
}