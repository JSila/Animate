<?php namespace JSila\Animate\Facades;

use Illuminate\Support\Facades\Facade;

class Animate extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'animate';
    }
} 