<?php
/**
 * Created by PhpStorm.
 * User: framato
 * Date: 30/11/14
 * Time: 21:13
 */

namespace Whopa\Ldapsearch\Facades;

use Illuminate\Support\Facades\Facade;

class Ldapsearch extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'ldapsearch'; }


} 