<?php

namespace App\Http\Services;

use App\Http\Library\StatusTrait;
use App\Models\AppUser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

/**
 * Class UserService
 * @package App\Http\Services
 */
class UserService
{

    /**
     * @Note: 用户登录
     * @Author: zrh
     * @Date: 2022/2/10/010 9:15
     *
     * @return string
     * @throws \Exception
     */
    public function userLogin()
    {
        $platform = request()->platform;
        $code = request()->code;

        if ($platform == 'baidu') {
            BaiduService::set(Config::get('applet.baidu.appid'), Config::get('applet.baidu.secret'));
            $loginInfo = BaiduService::getSessionKey($code);
        } elseif ($platform == 'wechat') {
            WechatService::set(Config::get('applet.wechat.appid'), Config::get('applet.wechat.secret'));
            $loginInfo = WechatService::getSessionKey($code);
            if (!empty($loginInfo->errcode)) {
                throw new \Exception("登录失败! errcode: {$loginInfo->errcode}, errmsg: {$loginInfo->errmsg}");
            }
            //$loginInfo->openid = 'test';
        } else {
            throw new \Exception('暂时不支持' . $platform . '平台');
        }

        //生成token
        $token = $this->makeToken($loginInfo->openid);
        $id = $this->saveUserInfo($loginInfo->openid, $token);

        //获取用户信息
        $userInfo = $this->getUserInfo($id);
        $userInfo = array_merge((array)$userInfo, (array)$loginInfo);
        $userInfo['token_expire_time'] = time() + 7200;
        //用户信息存入缓存
        Cache::add($token, json_encode($userInfo), 7200);

        $res['token'] = $token;
        $res['userInfo'] = $userInfo;

        return $res;
    }

    /**
     * @Note: 保存用户信息
     * @Author: zrh
     * @Date: 2022/2/10/010 10:19
     *
     * @param string $openid
     * @param string $token
     * @return void
     */
    public function saveUserInfo(string $openid, string $token)
    {
        //查询用户是否存在
        $res = AppUser::where('openid', $openid)->select('id', 'last_token')->first();
        if ($res) {
            //更新token
            AppUser::where('id', $res->id)->update(['last_token' => $token]);
            //从缓存中删除之前的token
            Cache::forget($res->last_token);
            $id = $res->id;
        } else {
            //初始化用户信息
            $insert = [
                'nick_name' => '',
                'head_portrait' => '',
                'phone' => '',
                'openid' => $openid,
                'platform' => StatusTrait::$platform[request()->platform],
                'last_token' => $token,
                'created_at' => date('Y-m-d H:i:s', time())
            ];
            $id = AppUser::insertGetId($insert);
        }
        return $id;
    }

    /**
     * @Note: 保存用户信息
     * @Author: zrh
     * @Date: 2022/2/14/014 9:19
     *
     */
    public function updateUserInfo()
    {
        $uid = (new UserService())->getUidByToken();
        $update = [];
        if (request()->head_portrait) {
            $update[] = ['head_portrait' => request()->head_portrait];
        }
        if (request()->nick_name) {
            $update[] = ['nick_name' => request()->nick_name];
        }
        if (request()->phone) {
            $update[] = ['nick_name' => request()->phone];
        }
        return AppUser::where('id', $uid)->update($update);
    }

    /**
     * @Note: 获取用户信息
     * @Author: zrh
     * @Date: 2022/2/11/011 10:39
     *
     * @param $id
     * @return mixed
     */
    public function getUserInfo($id)
    {
        if (is_numeric($id)) {
            $where[] = ['id', '=', $id];
        } else {
            $where[] = ['openid', '=', $id];
        }
        $userInfo = AppUser::where('id', $id)->first()->toArray() ?? [];
        //绑定了手机号则查询改手机号绑定的所有的账号的id
        if (!empty($userInfo->phone)) {
            $userInfo['uid_list'] = AppUser::where('phone', $userInfo->phone)->select('id')->limit(3)->pluck('id')->toArray();
        } else {
            $userInfo['uid_list'] = $userInfo['id'];
        }
        return $userInfo;
    }

    /**
     * @Note: 生成token
     * @Author: zrh
     * @Date: 2022/2/10/010 10:18
     *
     * @param $openid
     * @return string
     */
    private function makeToken($openid)
    {
        $time = time();
        $end_time = time() + 3600 * 24; //设置24小时过期
        $info = $openid . '.' . $time . '.' . $end_time;
        //根据以上信息信息生成签名（密钥为 xinshengtai@2022)
        $signature = hash_hmac('md5', $info, 'xinshengtai@2022');
        return $signature;
    }

    /**
     * @Note: 获取Token
     * @Author: zrh
     * @Date: 2022/2/11/011 17:37
     *
     * @return array|string|null
     */
    public function getToken()
    {
        return Request::header('token');
    }

    /**
     * @Note: 通过token获取用户信息
     * @Author: zrh
     * @Date: 2022/2/11/011 17:08
     *
     * @return array
     */
    public function getUserInfoByToken()
    {
        $cache = Cache::get($this->getToken());
        return json_decode($cache, true);
    }

    /**
     * @Note: 通过Token获取uid
     * @Author: zrh
     * @Date: 2022/2/11/011 17:31
     *
     * @return mixed
     */
    public function getUidByToken()
    {
        $userInfo = $this->getUserInfoByToken($this->getToken());
        return $userInfo['id'];
    }
}
