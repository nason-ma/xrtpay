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

class Xrtpay
{
    public static function pay(XrtpayInterface $xrtpay)
    {
        $payOptions = $xrtpay->getFullPayOptions();

        try {
            $response = Http::post($payOptions);
            if (isset($response['pay_info'])) {
                $payInfo = json_decode($response['pay_info'], true);
                if (isset($payInfo['timeStamp'])) {
                    $payInfo['timestamp'] = $payInfo['timeStamp'];
                    unset($payInfo['timeStamp']);
                }
                $response['pay_info'] = $payInfo;
            }

            return $response;
        } catch (Exceptions\HttpException $e) {
            throw $e;
        }
    }

    public static function verifySign($key, array $data)
    {
        $sign = $data['sign'] ?? '';
        if (empty($data) || !$sign) {
            return false;
        }
        unset($data['sign']);
        ksort($data);
        $options = urldecode(http_build_query($data))."&key={$key}";
        $verifySign = strtoupper(md5($options));
        if ($sign === $verifySign) {
            return true;
        }

        return false;
    }
}
