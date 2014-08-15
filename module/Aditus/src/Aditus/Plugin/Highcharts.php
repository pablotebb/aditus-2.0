<?php
namespace Aditus\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Highcharts extends AbstractPlugin
{
    public function __construct()
    {

    }

    public function encodedSvgToPng($id, $svg)
    {
        $encodeData = $svg;
        $encodeData = substr($encodeData, strpos($encodeData, ',') + 1); //strip the URL of its headers
        $decodeData = base64_decode($encodeData);
        $filename = sprintf($id.'-encoded-%d.png', time());
        $handle = fopen(ROOTPATH.'/public/img/temp/'.$filename, 'x+');
        fwrite($handle, $decodeData);
        fclose($handle);

        return $filename;
    }
}
