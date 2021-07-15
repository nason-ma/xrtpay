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

use Nason\Xrtpay\Exceptions\InvalidArgumentException;
use PragmaRX\Random\Random;

abstract class BaseXrtpay
{
    protected $key;

    protected $payOptions = [
        'mch_id' => '',
        'sub_appid' => '',
        'notify_url' => '',
    ];

    public function __construct($key, array $options)
    {
        $options = array_filter($options);
        $payOptions = $this->getPayOptions();
        foreach ($payOptions as $name => $value) {
            if (!isset($options[$name]) || empty($options[$name])) {
                throw new InvalidArgumentException("参数: {$name} 必需且不能为空");
                break;
            }
        }
        $this->key = $key;
        $this->payOptions = array_intersect_key($options, $this->payOptions);
        $this->payOptionsInit();
    }

    protected function payOptionsInit()
    {
        $this->payOptions['service'] = $this->getService();
        $this->payOptions['nonce_str'] = $this->getNonceStr();
    }

    protected function setPayOption($key, $value)
    {
        if (!$value) {
            return;
        }
        $this->payOptions[$key] = $value;
    }

    public function version($version)
    {
        $this->setPayOption('version', $version);

        return $this;
    }

    public function charset($charset)
    {
        $this->setPayOption('charset', $charset);

        return $this;
    }

    public function signType($signType)
    {
        $this->setPayOption('sign_type', $signType);

        return $this;
    }

    public function deviceInfo($deviceInfo)
    {
        $this->setPayOption('device_info', $deviceInfo);

        return $this;
    }

    public function attach($attach)
    {
        $this->setPayOption('attach', $attach);

        return $this;
    }

    public function timeStart($timeStart)
    {
        $this->setPayOption('time_start', $timeStart);

        return $this;
    }

    public function timeExpire($timeExpire)
    {
        $this->setPayOption('time_expire', $timeExpire);

        return $this;
    }

    public function limitCreditPay()
    {
        $this->setPayOption('limit_credit_pay', 1);

        return $this;
    }

    protected function getNonceStr()
    {
        return (new Random())->size(32)->get();
    }

    protected function getSign()
    {
        $payOptions = array_filter($this->getPayOptions());
        ksort($payOptions);
        $payOptions = urldecode(http_build_query($payOptions))."&key={$this->key}";

        return strtoupper(md5($payOptions));
    }

    abstract public function getPayOptions();

    abstract public function getService();
}
