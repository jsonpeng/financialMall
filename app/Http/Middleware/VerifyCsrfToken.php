<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'wechat',
        '/weixin',
        '/weixin_auth_callback',
        '/notify',
        '/notify_3rd',
        '/tixian_notify_3rd',
        '/alipay_notify',
        '/alipay_return',
        '/paysapi_return',
        '/paysapi_notify',
        '/api/pay_buy_alipay_nofity',
        '/loan_callback',
        '/xyk_callback',
        'jifen_callback',
        '/zcjy/qiniu_file_upload',
        '/alipay*'
    ];

}
