<?php

namespace IlBronza\Prices\Models\Traits;

use function class_basename;

trait UpdatePricesOnSaveTrait
{
	public static function bootUpdatePricesOnSaveTrait()
	{
		static::saved(function ($model)
		{
			if( ! $model->mustAutomaticallyUpdatePrices())
				return ;

			$model->updatePricesAfterSave();
		});
	}
}