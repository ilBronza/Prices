<?php

Route::group([
	'middleware' => ['web', 'auth'],
	'prefix' => 'prices-manager',
	'namespace' => 'IlBronza\Prices\Http\Controllers'
], function()
{
	Route::get('prices/{price}/force-calculation', 'PricesCalculationController@forceCalculation')->name('prices.forceCalculation');
});


Route::group([
	'middleware' => ['web', 'auth'],
	'prefix' => 'prices-management',
	'as' => config('prices.routePrefix')
	],
	function()
	{
		Route::get('', [Prices::getController('price', 'index'), 'index'])->name('prices.index');
		Route::get('create', [Prices::getController('price', 'create'), 'create'])->name('prices.create');
		Route::post('', [Prices::getController('price', 'store'), 'store'])->name('prices.store');
		Route::get('{price}', [Prices::getController('price', 'show'), 'show'])->name('prices.show');
		Route::get('{price}/edit', [Prices::getController('price', 'edit'), 'edit'])->name('prices.edit');
		Route::put('{price}', [Prices::getController('price', 'edit'), 'update'])->name('prices.update');

		Route::delete('{price}/delete', [Prices::getController('price', 'destroy'), 'destroy'])->name('prices.destroy');		
	});