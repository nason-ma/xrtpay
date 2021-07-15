<?php


namespace Nason\Xrtpay;


class Xrtpay
{

    public static function pay(XrtpayInterface $xrtpay)
    {
        $payOptions = $xrtpay->getFullPayOptions();
        try {
            return Http::post($payOptions);
        } catch (Exceptions\HttpException $e) {
            throw $e;
        }
    }
}