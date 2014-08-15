<?php

namespace Aditus\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class Num extends AbstractHelper
{
	public static function roundUpToNearest($number, $multiple=5 ){
	    return (round($number) % $multiple === 0) ? round($number) : round(($number + $multiple / 2) / $multiple) * $multiple;
	}
}
