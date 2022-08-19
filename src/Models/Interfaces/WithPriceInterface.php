<?php

namespace IlBronza\Prices\Models\Interfaces;

use Carbon\Carbon;
use IlBronza\Prices\Providers\PriceData;

interface WithPriceInterface
{
    //must calculate the final price
    public function _calculatePriceData(PriceData $priceData) : PriceData;

    //must calculate the final price
    public function _manageCalculationErrors(\Exception $e);

    //get first cost
    public function getCost();

    //get new price model base attributes to fill the price before its calculated
    public function getPriceBaseAttributes();

    /**
     * get the classname you need to relate in price table
     * expl your current model is App\Cardboards\PriceCalculations\Cardboard but you need to use App\Cardboards\PriceCalculations\Cardboard
     **/
    public function getPriceRelatedClassName();

    /**
     * get the model key you need to relate in price table
     * expl your current model is 172 but you need to use 34
     **/
    public function getPriceRelatedKey();

    public function getValidFrom() : ? Carbon;
    public function getValidTo() : ? Carbon;
}