<?php

namespace IlBronza\Prices\Providers;

use Auth;
use IlBronza\Prices\Models\Interfaces\WithPriceInterface;
use IlBronza\Prices\Models\Price;

class PriceCreatorHelper
{
	public $element;
	public ?Price $price;

	public function __construct(WithPriceInterface $element)
	{
		$this->element = $element;
	}

	public function replicateAndArchivePrice(Price $price) : ?Price
	{
		$newPrice = $this->makePrice();

		$newPrice->fill(
			$this->element->getPriceReplicateAttributes($price)
		);

		$newPrice->setPreviousKey($price);
		$newPrice->save();

		if ($price->isValid())
			$price->setUnvalid();

		$price->setNext($newPrice);

		return $newPrice;
	}

	public function associateElement()
	{
		$this->price->element()->associate($this->element);
		$this->price->save();
	}

	public function makePrice() : Price
	{
		return Price::getProjectClassName()::make();
	}

	public function createPrice(array $parameters = []) : Price
	{
		$this->price = $this->makePrice();

		$this->price->fill(
			$this->element->getPriceBaseAttributes()
		);

		$this->associateElement();

		return $this->price;
	}
}