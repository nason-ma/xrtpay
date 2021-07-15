<?php


namespace Nason\Xrtpay;


class XrtpayReverse extends BaseXrtpay
{

    protected $service = 'unified.micropay.reverse';

    public function getPayOptions()
    {
        return $this->payOptions;
    }

    public function getService()
    {
        return $this->service;
    }

    public function reverse()
    {
        $options = $this->getPayOptions();
        $options['sign'] = $this->getSign();
        try {
            return Http::post($options);
        } catch (Exceptions\HttpException $e) {
            throw $e;
        }
    }
}