<?php

namespace Nason\Xrtpay;

use GuzzleHttp\Client;
use Nason\Xrtpay\Exceptions\HttpException;

class Http
{
    protected static $url = 'http://pay.xrtpay.com/xrtpay/gateway';

    protected static $guzzleOptions = [
        'Content-Type' => 'text/xml; charset=UTF8',
    ];

    public static function getHttpClient()
    {
        return new Client(self::$guzzleOptions);
    }

    public static function setGuzzleOptions(array $options)
    {
        self::$guzzleOptions = $options;
    }

    public static function post(array $options)
    {
        $optionsXml = array_to_xml($options);

        try {
            $response = self::getHttpClient()
                ->post(self::$url, ['body' => $optionsXml])
                ->getBody()
                ->getContents();

            return _xml_to_array($response);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
