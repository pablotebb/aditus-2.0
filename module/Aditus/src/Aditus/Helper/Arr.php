<?php

namespace Aditus\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class Arr extends AbstractHelper
{
    public static function get($array, $element, $default = null)
    {
        return isset($array[$element]) ? $array[$element] : $default;
    }
}
