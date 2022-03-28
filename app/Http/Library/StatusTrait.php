<?php

/**
 * Created by PhpStorm.
 * User: sheeran
 * Date: 2020/7/6
 * Time: 11:29
 */

namespace App\Http\Library;


class StatusTrait
{
    //登录平台
    public static $platform = [
        '1' => '微信小程序',
        '2' => '百度小程序',
        '3' => '网站平台',
        'wechat' => 1,
        'baidu' => 2,
        'web' => 3
    ];

    public static $bookStatus = [
      '0' => '已完结',
      '1' => '连载中'
    ];
}
