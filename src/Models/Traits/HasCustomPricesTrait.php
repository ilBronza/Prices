<?php

namespace IlBronza\Prices\Models\Traits;


use Carbon\Carbon;
use Exception;
use IlBronza\Prices\Providers\PriceData;

trait HasCustomPricesTrait
{
	//	public function setPriceByCollection(string $collection, $price, string|MeasurementUnit $measurementUnit = null)
	//	{
	//		$price = $this->providePriceByCollectionId($collection);
	//
	//		if ($measurementUnit)
	//			$price->setMeasurementUnit($measurementUnit, false);
	//
	//		$price->price = $price;
	//
	//		$price->saveQuietly();
	//	}

	public function _calculatePriceData(PriceData $priceData) : PriceData
	{
		dd('risolvere');
	}

	//must calculate the final price

	public function _manageCalculationErrors(Exception $e)
	{
		//TODO manage errors
		dd('risolvere');
	}

	//get first cost

	public function getCost()
	{
		//TODO get first cost
		dd('risolvere');
	}

	//get new price model base attributes to fill the price before its calculated

	public function getPriceBaseAttributes()
	{
		return [];
	}


	/**
	 * example
	 *
	 * public function getPriceBaseAttributes()
	 * {
	 *      return [
	 *          'own_cost' => $this->getCost(),
	 *          'sequence' => $this->getPriceSequence(),
	 *      ];
	 * }
	 **/

	/**
	 * get the classname you need to relate in price table
	 * expl your current model is App\Cardboards\PriceCalculations\Cardboard but you need to use App\Cardboards\PriceCalculations\Cardboard
	 **/
	// public function getPriceRelatedClassName();

	/**
	 * get the model key you need to relate in price table
	 * expl your current model is 172 but you need to use 34
	 **/
	// public function getPriceRelatedKey();
	public function getPriceValidityFrom() : ?Carbon
	{
		return null;
	}

	public function getPriceValidityTo() : ?Carbon
	{
		return null;
	}

	//	public function companyDay()
	//	{
	//		return $this->morphOne(
	//			$this->getPriceModelClassName(), 'priceable'
	//		)->byCollection('companyDay')->latestOfMany();
	//	}

	//	public function grossDay()
	//	{
	//		return $this->morphOne(
	//			$this->getPriceModelClassName(), 'priceable'
	//		)->byCollection('grossDay')->latestOfMany();
	//	}
	//
	//	public function neatDay()
	//	{
	//		return $this->morphOne(
	//			$this->getPriceModelClassName(), 'priceable'
	//		)->byCollection('neatDay')->latestOfMany();
	//	}

	//	public function provideCompanyDayModelForExtraFields()
	//	{
	//		if (! $this->companyDay)
	//		{
	//			$price = $this->providePriceByCollectionId('companyDay');
	//			$price->setMeasurementUnit('day');
	//
	//			$this->setRelation('companyDay', $price);
	//		}
	//
	//		return $this->companyDay;
	//	}
	//
	//	public function provideGrossDayModelForExtraFields()
	//	{
	//		if (! $this->grossDay)
	//		{
	//			$price = $this->providePriceByCollectionId('grossDay');
	//			$price->setMeasurementUnit('day');
	//
	//			$this->setRelation('grossDay', $price);
	//		}
	//
	//		return $this->grossDay;
	//	}
	//
	//	public function provideDistancePriceModelForExtraFields()
	//	{
	//		if (! $this->grossDay)
	//		{
	//			$price = $this->providePriceByCollectionId('distancePrice');
	//			$price->setMeasurementUnit('km');
	//
	//			$this->setRelation('distancePrice', $price);
	//		}
	//
	//		return $this->grossDay;
	//	}
	//
	//	public function provideNeatDayModelForExtraFields()
	//	{
	//		if (! $this->neatDay)
	//		{
	//			$price = $this->providePriceByCollectionId('neatDay');
	//			$price->setMeasurementUnit('day');
	//
	//			$this->setRelation('neatDay', $price);
	//		}
	//
	//		return $this->neatDay;
	//	}
}