<?php

namespace App\Http\Services;

use App\Models\Book;
use App\Models\BookCollection;

/**
 * Class CollectionService
 * @package App\Http\Services
 */
class CollectionService
{
    /**
     * @Note: 获取收藏的书籍
     * @Author: zrh
     * @Date: 2022/2/11/011 17:42
     *
     */
    public function getCollection()
    {
        $pageSize = request()->pageSize;
        $uid = (new UserService())->getUidByToken();

        $list = BookCollection::with(['book' => function ($query) {
            $query->select('id', 'name', 'author');
        },'chapter' => function ($query){
            $query->select('id','title');
        }
        ])
            ->where('uid', $uid)
            ->select('*')
            ->simplePaginate($pageSize)
            ->toArray();

        $res['list'] = $list['data'];
        $res['total'] = $list['to'];
        return $res;
    }

    /**
     * @Note: 添加收藏
     * @Author: zrh
     * @Date: 2022/2/11/011 17:42
     *
     */
    public function addCollection()
    {
        $book_id = request()->book_id;
        $uid = (new UserService())->getUidByToken();

        //查询是否重复收藏
        $bool = BookCollection::where('uid',$uid)->where('book_id',$book_id)->value('id');

        if($bool){
            throw new \Exception('已经收藏过该书籍');
        }

        return BookCollection::insertGetId([
            'uid' => $uid,
            'book_id' => $book_id,
            'last_read_chapter_id' => 0,
            'list_order' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * @Note: 移除收藏
     * @Author: zrh
     * @Date: 2022/2/11/011 17:42
     *
     */
    public function removeCollection()
    {
        $id = request()->id;
        $uid = (new UserService())->getUidByToken();
        return BookCollection::where('id', $id)->where('uid', $uid)->delete();
    }

}
