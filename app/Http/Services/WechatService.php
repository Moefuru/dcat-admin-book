<?php

/**
 * @name WechatService
 * @desc 微信小程序服务
 * @author  zrh
 */

namespace App\Http\Services;

class WechatService
{
    private static $appId = '';
    private static $appSecret = '';
    public static $OK = 0;
    public static $IllegalAesKey = -41001;
    public static $IllegalIv = -41002;
    public static $IllegalBuffer = -41003;
    public static $DecodeBase64Error = -41004;

    public static function set($appId, $appSecret)
    {
        self::$appId = $appId;
        self::$appSecret = $appSecret;
    }

    public static function getAccessToken()
    {

    }

    /**
     * 获取 SessionKey
     * @param $code string 登录code
     * @return string
     */

    public static function getSessionKey($code)
    {
        $url = 'https://api.weixin.qq.com/sns/jscode2session';
        $params['appid'] = self::$appId;
        $params['js_code'] = $code;
        $params['secret'] = self::$appSecret;
        $params['grant_type'] = 'authorization_code';
        $res = sendHttp($url, $params, 'GET');
        return json_decode($res);
    }

    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $sessionKey string 回话密钥
     *
     * @return int 成功0，失败返回对应的错误码
     * @throws \Exception
     */
    public static function decryptData($encryptedData, $iv, $sessionKey)
    {
        if (strlen($sessionKey) != 24) {
            return self::$IllegalAesKey;
        }
        $aesKey = base64_decode($sessionKey);

        if (strlen($iv) != 24) {
            return self::$IllegalIv;
        }
        $aesIV = base64_decode($iv);

        $aesCipher = base64_decode($encryptedData);

        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        $dataObj = json_decode($result);
        if (empty($dataObj)) {
            throw new \Exception("解密失败");
        }

        return $dataObj;

    }

}
