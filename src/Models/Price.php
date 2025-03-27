<?php

namespace IlBronza\Prices\Models;

use Auth;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Model\CRUDCreatedByTrait;
use IlBronza\CRUD\Traits\Model\CRUDModelsSequenceTrait;
use IlBronza\CRUD\Traits\Model\CRUDValidityTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use IlBronza\MeasurementUnits\Models\MeasurementUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Price extends BaseModel
{
	use CRUDValidityTrait;
	use CRUDCreatedByTrait;
	use PackagedModelsTrait;

	use CRUDModelsSequenceTrait;

	static $deletingRelationships = [];

	static $packageConfigPrefix = 'prices';
	static $modelConfigPrefix = 'price';

	protected $fillable = [
		'measurement_unit_id',
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

	protected $casts = [
		'data' => 'array',
		'deleted_at' => 'datetime',
		'calculated_at' => 'datetime',
		'valid_from' => 'datetime',
		'valid_to' => 'datetime',
		'validated_at' => 'datetime',
		'unvalidated_at' => 'datetime'
	];

	public function getPriceReplicateAttributesNames()
	{
		return [
			'priceable_type',
			'priceable_id',
			'imposed_price'
		];
	}

	public function getCollectionId()
	{
		return $this->collection_id;
	}

	public function setCollectionId(string $collectionId) : self
	{
		$this->collection_id = $collectionId;

		return $this;
	}

	public function getTranslatedCollectionId() : ? string
	{
		if (! $collectionId = $this->getCollectionId())
			return null;

		return trans('prices::prices.' . $collectionId);
	}

	public function getName() : ?string
	{
		if (! $collectionId = $this->getTranslatedCollectionId())
		{
			if (! $measurementUnit = $this->getMeasurementUnitId())
				return $this->price;

			return "{$this->price}/{$measurementUnit}";
		}

		if (! $measurementUnit = $this->getMeasurementUnitId())
			return "{$collectionId} {$this->price}";

		return "{$collectionId} {$this->price}/{$measurementUnit}";
	}

	public function getMeasurementUnitId()
	{
		return $this->measurement_unit_id;
	}

	public function element()
	{
		return $this->morphTo('priceable');
	}

	public function getElement() : ?Model
	{
		return $this->element;
	}

	public function measurementUnit()
	{
		return $this->belongsTo(MeasurementUnit::getProjectClassName());
	}

	public function setMeasurementUnit(string|MeasurementUnit $measurementUnit, bool $save = false) : static
	{
		if ((is_string($measurementUnit)) && ($savedString = $measurementUnit))
			if (! $measurementUnit = MeasurementUnit::getProjectClassName()::findCachedField('name', $measurementUnit))
				throw new \Exception('Measurement unit ' . $savedString . ' not found');

		$this->measurementUnit()->associate($measurementUnit);

		if ($save)
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

	public function scopeByCollection($query, string $collectionId)
	{
		return $query->where('collection_id', $collectionId);
	}

	public function getSequence()
	{
		return $this->sequence;
	}

	public function getSequenceAttribute($value)
	{
		if (is_null($value))
			return 0;

		return $value;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function hasCalculatingErrorMessages()
	{
		return ! ! $this->getMessage();
	}

	public function canBeValid()
	{
		return $this->calculated || ((! $this->calculated) && (! $this->calculated_at));

		// return $this->calculated;
		// return $this->calculated && ! $this->hasCalculatingErrorMessages();
	}

	public function isCalculated() : bool
	{
		return ! ! $this->calculated;
	}

	public function getImposedPrice() : ?float
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

	public function getPriceDescriptionString()
	{
		if ($string = $this->getTranslatedCollectionId())
			$string .= ' ';

		if (! $this->getMeasurementUnitId())
			return $string . $this->getPrice() . '€/';

		return $string . $this->getPrice() . '€/' . $this->getMeasurementUnitId();
	}

	public function getPriceValue()
	{
		if ($imposed = $this->getImposedPrice())
			return $imposed;

		return $this->price;
	}

	public function _prettyPrintTranslatedDataString($data)
	{
		if (! is_array($data))
			return $data;

		$result = [];

		foreach ($data as $name => $parameters)
			$result[__('prices.fields' . $name)] = $this->_prettyPrintTranslatedDataString($parameters);

		return $result;
	}

	public function prettyPrintTranslatedDataString()
	{
		if (! $this->data)
			return;

		$result = $this->_prettyPrintTranslatedDataString($this->data);

		return "<pre>" . json_encode($result, JSON_PRETTY_PRINT) . "</pre>";
	}

	public function getOwnCost()
	{
		return $this->own_cost;
	}
}