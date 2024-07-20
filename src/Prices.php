<?php

namespace IlBronza\Prices;

use IlBronza\CRUD\Providers\RouterProvider\RoutedObjectInterface;
use IlBronza\CRUD\Traits\IlBronzaPackages\IlBronzaPackagesTrait;

class Prices implements RoutedObjectInterface
{
    use IlBronzaPackagesTrait;

    static $packageConfigPrefix = 'prices';

    public function manageMenuButtons()
    {
        return ;
        // if(! $menu = app('menu'))
        //     return;

        // $settingsButton = $menu->provideButton([
        //         'text' => 'generals.settings',
        //         'name' => 'settings',
        //         'icon' => 'gear',
        //         'roles' => ['administrator']
        //     ]);

        // $vehiclesManagerButton = $menu->createButton([
        //     'name' => 'vehiclesManager',
        //     'icon' => 'truck-moving',
        //     'text' => 'vehicles::vehicles.vehiclesManager',
        // ]);

        // $settingsButton->addChild($vehiclesManagerButton);

        // $vehiclesManagerButton->addChild(
        //     $menu->createButton([
        //         'name' => 'vehicles.list',
        //         'icon' => 'truck-moving',
        //         'text' => 'vehicles::vehicles.list',
        //         'href' => IbRouter::route($this, 'vehicles.index')
        //     ])
        // );

        // $vehiclesManagerButton->addChild(
        //     $menu->createButton([
        //         'name' => 'vehicles.types.list',
        //         'icon' => 'gear',
        //         'text' => 'vehicles::vehicles.types',
        //         'href' => IbRouter::route($this, 'types.index')
        //     ])
        // );
        // $vehiclesManagerButton->addChild(
        //         $menu->createButton([
        //         'name' => 'vehicles.kmreadings.list',
        //         'icon' => 'bookmark',
        //         'text' => 'vehicles::vehicles.kmreadings',
        //         'href' => IbRouter::route($this, 'kmreadings.index')
        //     ])
        // );
    }

    public function getRoutePrefix() : ? string
    {
        return config('prices.routePrefix');
    }

}