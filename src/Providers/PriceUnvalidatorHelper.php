<?php

namespace IlBronza\Prices\Providers;

use IlBronza\Prices\Models\Interfaces\WithPriceInterface;
use IlBronza\Prices\Providers\PriceHelpersPriceCreatorTrait;
use Illuminate\Support\Collection;

class PriceUnvalidatorHelper
{
	use PriceHelpersPriceCreatorTrait;

	public function __construct(WithPriceInterface $element)
	{
		$this->element = $element;

		$this->currentPrice = $element->getCurrentPrice();
	}

	public function unvalidatePrice()
	{
		$this->replicateAndArchiveCurrentPrice();

		return $this;
	}

	static function unvalidateBulk(Collection $elements)
	{
		foreach($elements as $element)
			(new self($element))->unvalidatePrice();
	}
}