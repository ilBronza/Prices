<?php

namespace IlBronza\Prices\Providers;

use IlBronza\Prices\Models\Interfaces\WithPriceInterface;
use IlBronza\Prices\Models\Price;

use Auth;

class PriceCreatorHelper
{
	public $element;

	public function __construct(WithPriceInterface $element)
	{
		$this->element = $element;
	}

	public function replicateAndArchivePrice(Price $price) : ? Price
	{
		$newPrice = Price::make();

		$newPrice->fill(
			$this->element->getPriceReplicateAttributes($price)
		);

		$newPrice->setPreviousKey($price);
		$newPrice->save();

		if($price->isValid())
			$price->setUnvalid();

		$price->setNext($newPrice);

		return $newPrice;
	}

	public function mustAssociateUser()
	{
		return Auth::user();
	}

	public function associateUser()
	{
		$user = Auth::user();

		$this->price->created_by_type = get_class($user);
		$this->price->created_by_id = $user->getKey();
	}

	public function associateElement()
	{
		$this->price->priceable_type = $this->element->getPriceRelatedClassName();
		$this->price->priceable_id = $this->element->getPriceRelatedKey();
	}

	public function createPrice() : Price
	{
		$this->price = Price::make();

		$this->price->fill(
			$this->element->getPriceBaseAttributes()
		);

		if($this->mustAssociateUser())
			$this->associateUser();

		$this->associateElement();

		return $this->price;
	}
}