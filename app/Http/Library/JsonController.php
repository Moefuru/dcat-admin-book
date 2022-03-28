<?php
namespace App\Http\Library;

use Illuminate\Support\Facades\Log;
trait JsonController
{
    protected function returnJson($status = 1, $data = [], $msg = '', $errCode = 0, $extra = array())
    {
        $resp = [
            'status' => $status,
            'data' => $data,
            'msg' => $msg,
            'errorCode' => $errCode,
        ];

        $resp = array_merge($resp, $extra);

        $request = app('request');
        if ($request->input('format') == 'jsonp') {
            $callback = $request->input('callback', 'callback');
            return response()->json($resp)->setCallback($callback);
        } else {
            return response()->json($resp);
        }
    }

    protected function returnSuccess($data = array(), $extra = array())
    {
        return $this->returnJson(1, $data, '操作成功', 0, $extra);
    }


    protected function returnError($errCode = 1, $msg = '服务器错误')
    {
        //if(strpos($msg,'SQLSTATE') !== false){
        //    $msg = '数据库错误';
        //}
        Log::error('Api failed detected, error msg:' .$msg . ', request url:' . url() -> full());
        return $this->returnJson(0, [], $msg, $errCode);
    }
}
