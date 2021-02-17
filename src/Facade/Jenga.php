<?php
namespace Finserve\Jenga\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class Jenga
 * @package Finserve/
 * @author gituyu
 *
 */
class Jenga extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Jenga';
    }


}