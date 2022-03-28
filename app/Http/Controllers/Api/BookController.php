<?php

namespace App\Http\Controllers\Api;

use App\Http\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Library\JsonController;
use Illuminate\Support\Facades\Validator;

/**
 * Class BookController
 * @package App\Http\Controllers\Api
 */
class BookController extends BaseController
{
    use JsonController;

    /**
     * @Note:获取书籍分类
     * @Author: zrh
     * @Date: 2022/2/9/009 15:51
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategory(Request $request)
    {
        //$validate = Validator::make($request->all(), [
        //
        //]);
        //
        //if($validate->fails())
        //{
        //    $msg = $validate->errors()->first();
        //    return $this->returnError(1,$msg) ;
        //}

        try {
            $res = (new BookService)->getCategory($request);
        } catch (\Exception $e) {
            return $this->returnError(1, $e->getMessage());
        }
        return $this->returnSuccess($res);
    }

    /**
     * @Note: 获取书籍列表
     * @Author: zrh
     * @Date: 2022/2/9/009 16:04
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBookList(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'cat_id' => 'int',
        ]);

        if ($validate->fails()) {
            $msg = $validate->errors()->first();
            return $this->returnError(1, $msg);
        }
        try {
            $res = (new BookService)->getBookList($request);
        } catch (\Exception $e) {
            return $this->returnError(1, $e->getMessage());
        }
        return $this->returnSuccess($res);
    }

    /**
     * @Note: 获取章节列表
     * @Author: zrh
     * @Date: 2022/2/9/009 17:14
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChapterList(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'book_id' => 'required|int',
        ]);

        if ($validate->fails()) {
            $msg = $validate->errors()->first();
            return $this->returnError(1, $msg);
        }
        try {
            $res = (new BookService)->getChapterList($request);
        } catch (\Exception $e) {
            return $this->returnError(1, $e->getMessage());
        }
        return $this->returnSuccess($res);
    }


    /**
     * @Note: 获取章节详情
     * @Author: zrh
     * @Date: 2022/2/9/009 17:22
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChapterDetail(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'int',
        ]);

        if ($validate->fails()) {
            $msg = $validate->errors()->first();
            return $this->returnError(1, $msg);
        }
        try {
            $res = (new BookService)->getChapterDetail($request);
        } catch (\Exception $e) {
            return $this->returnError(1, $e->getMessage());
        }
        return $this->returnSuccess($res);
    }

    /**
     * @Note: 章节解锁
     * @Author: zrh
     * @Date: 2022/2/9/009 17:22
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlockChapter(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'book_id' => 'required|int',
            'chapter_id' => 'required|int',
        ]);

        if ($validate->fails()) {
            $msg = $validate->errors()->first();
            return $this->returnError(1, $msg);
        }
        try {
            $res = (new BookService)->unlockChapter($request);
        } catch (\Exception $e) {
            return $this->returnError(1, $e->getMessage());
        }
        return $this->returnSuccess($res);
    }

    public function getHotSearch()
    {
        try {
            $res = (new BookService)->getHotSearch();
        } catch (\Exception $e) {
            return $this->returnError(1, $e->getMessage());
        }
        return $this->returnSuccess($res);
    }
}
