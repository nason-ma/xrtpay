<?php

use Mtownsend\XmlToArray\XmlToArray;
use Spatie\ArrayToXml\ArrayToXml;

function array_to_xml(array $array)
{
    foreach ($array as $key => $value) {
        $value = (string) $value;
        $array[$key] = ['_cdata' => $value];
    }
    $arrayToXml = new ArrayToXml($array, 'xml', true, 'UTF-8');
    $arrayToXml->dropXmlDeclaration()->prettify();

    return $arrayToXml->toXml();
}

function _xml_to_array($xml)
{
    return XmlToArray::convert($xml);
}
