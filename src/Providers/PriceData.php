<?php

namespace IlBronza\Prices\Providers;

class PriceData
{
	public $price;
	public $data;
	public $message;
	public $calculated;
	public $calculatedAt;

	public function toArray()
	{
		return [
			'price' => $this->price,
			'data' => $this->data,
			'message' => $this->message,
			'calculated' => $this->calculated,
			'calculated_at' => $this->calculatedAt
		];
	}
}