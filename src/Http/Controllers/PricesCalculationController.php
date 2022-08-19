<?php

namespace IlBronza\Prices\Http\Controllers;

use App\Http\Controllers\Controller;
use IlBronza\Prices\Models\Price;
use IlBronza\Prices\Providers\PriceCalculatorHelper;

class PricesCalculationController extends Controller
{
	public function forceCalculation(Price $price)
	{
		PriceCalculatorHelper::forcePriceCalculation($price);

		return back();
	}
}