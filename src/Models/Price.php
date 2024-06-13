<?php

namespace IlBronza\Prices\Models;

use Auth;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Model\CRUDCreatedByTrait;
use IlBronza\CRUD\Traits\Model\CRUDModelsSequenceTrait;
use IlBronza\CRUD\Traits\Model\CRUDValidityTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use IlBronza\MeasurementUnits\Models\MeasurementUnit;
use Illuminate\Foundation\Auth\User;

class Price extends BaseModel
{
	use CRUDValidityTrait;
	use CRUDCreatedByTrait;
	use PackagedModelsTrait;

	use CRUDModelsSequenceTrait;

	static $packageConfigPrefix = 'prices';
	static $modelConfigPrefix = 'price';

	protected $fillable = [
		'priceable_type',
		'priceable_id',
		'own_cost',
		'sequence',
		'price',
		'data',
		'message',
		'calculated',
		'calculated_at',
	];

	static $brotherhoodFields = [
		'priceable_type',
		'priceable_id'
	];

	protected $dates = [
		'deleted_at',
		'calculated_at',
		'valid_from',
		'valid_to',
		'validated_at',
		'unvalidated_at'
	];

	protected $casts = [
		'data' => 'array',
	];

	public function getPriceReplicateAttributesNames()
	{
		return [
			'priceable_type',
			'priceable_id',
			'imposed_price'
		];
	}

	public function element()
	{
		return $this->morphTo('priceable');
	}

	public function measurementUnit()
	{
		return $this->belongsTo(MeasurementUnit::getProjectClassname());
	}

	public function setMeasurementUnit(string|MeasurementUnit $measurementUnit, bool $save = false) : static
	{
		if((is_string($measurementUnit))&&($savedString = $measurementUnit))
			if(! $measurementUnit = MeasurementUnit::getProjectClassname()::findCachedField('name', $measurementUnit))
				throw new \Exception('Measurement unit ' . $savedString . ' not found');

		$this->measurementUnit()->associate($measurementUnit);

		if($save)
			$this->save();

		return $this;
	}

	public function getPriceReplicateAttributes()
	{
		$attributes = $this->getPriceReplicateAttributesNames();

		return $this->only($attributes);
	}

	public function scopeWithoutRestrictions($query)
	{
		return $query->withoutGlobalScopes();
	}

	public function scopeToCalculate($query)
	{
		return $query->whereBooleanNotTrue('calculated');
	}

	public function getSequence()
	{
		return $this->sequence;
	}

	public function getSequenceAttribute($value)
	{
		if(is_null($value))
			return 0;

		return $value;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function hasCalculatingErrorMessages()
	{
		return !! $this->getMessage();
	}

	public function canBeValid()
	{
		return $this->calculated || ((! $this->calculated) && (! $this->calculated_at));

		// return $this->calculated;
		// return $this->calculated && ! $this->hasCalculatingErrorMessages();
	}

	public function isCalculated() : bool
	{
		return !! $this->calculated;
	}

	public function getImposedPrice() : ? float
	{
		return $this->imposed_price;
	}


	///// DEPRECATED
	public function getFinalPrice()
	{
		return $this->getPriceValue();
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function getPriceValue()
	{
		if($imposed = $this->getImposedPrice())
			return $imposed;

		return $this->price;
	}

	public function _prettyPrintTranslatedDataString($data)
	{
		if(! is_array($data))
			return $data;

		$result = [];

		foreach($data as $name => $parameters)
			$result[__('prices.fields' . $name)] = $this->_prettyPrintTranslatedDataString($parameters);

		return $result;
	}

	public function prettyPrintTranslatedDataString()
	{
		if(! $this->data)
			return ;

		$result = $this->_prettyPrintTranslatedDataString($this->data);

		return "<pre>" . json_encode($result, JSON_PRETTY_PRINT) . "</pre>";
	}

	public function getOwnCost()
	{
		return $this->own_cost;
	}
}