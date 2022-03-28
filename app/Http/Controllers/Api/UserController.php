<?php

namespace App\Http\Controllers\Api;

use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Library\JsonController;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    use JsonController;

    /**
     * @Note: 用户登录
     * @Author: zrh
     * @Date: 2022/2/11/011 17:02
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userLogin(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'code' => 'required|string',
            'platform' => 'required|string'
        ]);

        if ($validate->fails()) {
            $msg = $validate->errors()->first();
            return $this->returnError(1, $msg);
        }

        try {
            $res = (new UserService())->userLogin();
        } catch (\Exception $e) {
            return $this->returnError(1, $e->getMessage());
        }
        return $this->returnSuccess($res);
    }


    /**
     * @Note: 更新用户信息
     * @Author: zrh
     * @Date: 2022/2/14/014 9:07
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserInfo(Request $request){
        $validate = Validator::make($request->all(), [
            'nick_name' => 'string',
            'head_portrait' => 'string',
            'phone' => 'string',
        ]);

        if ($validate->fails()) {
            $msg = $validate->errors()->first();
            return $this->returnError(1, $msg);
        }

        try {
            $res = (new UserService())->updateUserInfo();
        } catch (\Exception $e) {
            return $this->returnError(1, $e->getMessage());
        }
        return $this->returnSuccess($res);
    }
}
