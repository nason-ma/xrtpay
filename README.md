<h1 align="center"> xrtpay </h1>

<p align="center"> 信瑞泰支付.</p>

![StyleCI build status](https://github.styleci.io/repos/386177299/shield)
![GitHub](https://img.shields.io/github/license/nason-ma/xrtpay?label=license)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/nason-ma/xrtpay)

## 安装

```shell
$ composer require nason/xrtpay -vvv
```

## 配置

在使用本扩展之前，需要获取到信瑞泰支付的相关秘钥，需要开通微信支付。

## 使用

```php
use Nason\Xrtpay\Weixin\WeixinJsPay;
use Nason\Xrtpay\Xrtpay;

$payOptions = [
    'mch_id'        => 'xxxxxxxxxx', // 信瑞泰商户号
    'sub_appid'     => 'xxxxxxxxxx', // 微信公众号或者微信小程序 appid
    'notify_url'    => 'http://127.0.0.1/notify', // 接收支付回调通知的url，需绝对路径，255字符内
    'out_trade_no'  => 'xxxxxxxxxx', // 商户订单号
    'body'          => '测试商品', // 商品描述
    'sub_openid'    => 'xxxxxxxxxx', // 用户 openid
    'total_fee'     => '123', // 支付金额，单位：分
    'mch_create_ip' => '127.0.0.1', // 订单生成的机器 IP
];
// 信瑞泰密钥
$key = 'xxxxxxxxxx'; 

$weixinJsPay = new WeixinJsPay($key, $payOptions);
// 可设置其他非必需参数
$weixinJsPay->attach('product')->raw()->limitCreditPay();

try {
    $result = Xrtpay::pay($weixinJsPay);
} catch (\Exception $e) {
    // todo
}
```

## 获取公众账号 JS 支付 url

```php
use Nason\Xrtpay\Weixin\WeixinJsPay;

$jsUrl = WeixinJsPay::getJsPayUrl($tokenId);
```

## 关闭支付订单

```php
use Nason\Xrtpay\XrtpayReverse;

$options = [
    'mch_id'       => 'xxxxxxxxxx', // 信瑞泰商户号
    'out_trade_no' => 'xxxxxxxxxx', // 商户订单号
];
// 信瑞泰密钥
$key = 'xxxxxxxxxx';

$xrtpayReverse = new XrtpayReverse($key, $options);
$result = $xrtpayReverse->reverse();
```

## 支付回调验签

```php
use Nason\Xrtpay\Xrtpay;

// 信瑞泰密钥
$key = 'xxxxxxxxxx'; 
// 信瑞泰回调通知数据
$notifyData = [];

// true or false
$result = Xrtpay::verifySign($key, $notifyData);
```

## 其他

- 自己看着代码用吧，反正也就几个文件。

## 参考

- [信瑞泰支付文档](http://doc.xrtinfo.com/docs/trade_and_orders/trade_and_orders-1bnl0kibtrvd6)

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/nason/xrtpay/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/nason/xrtpay/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT