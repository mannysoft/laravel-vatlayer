<?php 

namespace Mannysoft\VatLayer\Facades;

use Illuminate\Support\Facades\Facade;

class VatLayerFacade extends Facade {
    /**
     * Return facade accessor
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'vat-layer';
        return 'monopond-fax';
    }
}