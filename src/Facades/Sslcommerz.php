<?php 
namespace Imtiaz\Sslcommerz\Facades;

use Illuminate\Support\Facades\Facade;

/**
 
 *  @see \Imtiaz\Sslcommerz\Sslcommerz
 */
class Sslcommerz extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sslcommerz';
    }
}