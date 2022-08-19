<?php

Route::group([
	'middleware' => ['web', 'auth'],
	'prefix' => 'prices-manager',
	'namespace' => 'IlBronza\Prices\Http\Controllers'
], function()
{
	Route::get('prices/{price}/force-calculation', 'PricesCalculationController@forceCalculation')->name('prices.forceCalculation');
});