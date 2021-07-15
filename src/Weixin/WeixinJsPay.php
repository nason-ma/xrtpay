<?php

/*
 * This file is part of the nason/gw_supply_chain.
 *
 * (c) nason <mananxun99@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Nason\Xrtpay\Weixin;

use Nason\Xrtpay\BaseXrtpay;
use Nason\Xrtpay\XrtpayInterface;

class WeixinJsPay extends BaseXrtpay implements XrtpayInterface
{
    const JS_PAY_URL = 'http://pay.xrtpay.com/pay/jspay';

    protected $service = 'pay.weixin.jspay';

    protected $jsPayOptions = [
        'out_trade_no' => '',
        'body' => '',
        'sub_openid' => '',
        'total_fee' => '',
        'mch_create_ip' => '',
    ];

    public function __construct($key, array $options)
    {
        parent::__construct($key, $options);
        $this->jsPayOptions = array_intersect_key($options, $this->jsPayOptions);
    }

    protected function setPayOption($key, $value)
    {
        if (!$value) {
            return;
        }
        $this->jsPayOptions[$key] = $value;
    }

    public function getPayOptions()
    {
        return array_merge($this->payOptions, $this->jsPayOptions);
    }

    public function raw()
    {
        $this->setPayOption('is_raw', 1);

        return $this;
    }

    public function minipg()
    {
        $this->setPayOption('is_minipg', 1);

        return $this;
    }

    public function getService()
    {
        return $this->service;
    }

    public function getFullPayOptions()
    {
        $payOptions = $this->getPayOptions();
        $payOptions['sign'] = $this->getSign();
        ksort($payOptions);

        return $payOptions;
    }

    public static function getJsPayUrl($tokenId)
    {
        return self::JS_PAY_URL."?token_id={$tokenId}";
    }
}
