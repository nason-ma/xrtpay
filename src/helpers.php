<?php

/*
 * This file is part of the nason/gw_supply_chain.
 *
 * (c) nason <mananxun99@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
