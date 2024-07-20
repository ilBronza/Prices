<?php

namespace IlBronza\Prices\Http\Controllers;

use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Http\Controllers\BasePackageTrait;

class CRUDPricesPackageController extends CRUD
{
    use BasePackageTrait;

    static $packageConfigPrefix = 'prices';
}
