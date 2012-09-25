<?php
/**
 * Created by JetBrains PhpStorm.
 * User: grzybu
 * Date: 14.09.12
 * Time: 21:38
 * To change this template use File | Settings | File Templates.
 */
class BApp_Helper_Math
{
    public static function random_float($min, $max)
    {
        return ($min + lcg_value() * (abs($max-$min)));
    }

}
