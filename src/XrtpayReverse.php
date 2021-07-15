<?php

/*
 * This file is part of the nason/gw_supply_chain.
 *
 * (c) nason <mananxun99@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
