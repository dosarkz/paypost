<?php
/**
 * Created by PhpStorm.
 * User: dosar
 * Date: 27.11.2018
 * Time: 10:48
 */

namespace Dosarkz\PayPost\Facade;


use Dosarkz\PayPost\PayPostService;
use Illuminate\Support\Facades\Facade;

class PayPost extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return PayPostService::class;
    }
}