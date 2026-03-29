<?php

namespace IlBronza\Prices\Http\Middleware;

use IlBronza\CRUD\Middleware\CRUDBasePackageMiddlewareRolesPermissions;

/**
 * Resolves allowed roles for Prices routes from config (prices.defaultRoles / prices.routeRoles).
 */
class PricesMiddlewareRolesPermissions extends CRUDBasePackageMiddlewareRolesPermissions
{
    protected string $configPackageName = 'prices';
}
