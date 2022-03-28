<?php

namespace App\Http\Controllers\Api;

use App\Http\Services\CollectionService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Library\JsonController;
use Illuminate\Support\Facades\Validator;

/**
 * Class CollectionController
 * @package App\Http\Controllers\Api
 */
class CollectionController extends BaseController
{
    use JsonController;

    /**
     * @Note: 添加收藏
     * @Author: zrh
     * @Date: 2022/2/11/011 17:03
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCollection(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'book_id' => 'required|int'
        ]);

        if ($validate->fails()) {
            $msg = $validate->errors()->first();
            return $this->returnError(1, $msg);
        }

        try {
            $res = (new CollectionService())->addCollection();
        } catch (\Exception $e) {
            return $this->returnError(1, $e->getMessage());
        }
        return $this->returnSuccess($res);
    }

    /**
     * @Note: 移除收藏
     * @Author: zrh
     * @Date: 2022/2/14/014 10:27
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCollection(Request $request){
        $validate = Validator::make($request->all(), [
            'id' => 'required|int'
        ]);

        if ($validate->fails()) {
            $msg = $validate->errors()->first();
            return $this->returnError(1, $msg);
        }

        try {
            $res = (new CollectionService())->addCollection();
        } catch (\Exception $e) {
            return $this->returnError(1, $e->getMessage());
        }
        return $this->returnSuccess($res);
    }

    /**
     * @Note: 获取收藏
     * @Author: zrh
     * @Date: 2022/2/14/014 10:39
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCollection(Request $request){
        $validate = Validator::make($request->all(), [
            'pageSize' => 'int'
        ]);

        if ($validate->fails()) {
            $msg = $validate->errors()->first();
            return $this->returnError(1, $msg);
        }

        try {
            $res = (new CollectionService())->getCollection();
        } catch (\Exception $e) {
            return $this->returnError(1, $e->getMessage());
        }
        return $this->returnSuccess($res);
    }
}
