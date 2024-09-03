<?php

namespace Captenmasin\InertiaSeo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Captenmasin\InertiaSeo\InertiaSeo
 */
class InertiaSeo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Captenmasin\InertiaSeo\InertiaSeo::class;
    }
}
