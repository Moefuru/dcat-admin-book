<?php

namespace App\Http\Services;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookChapter;
use App\Models\ChapterUnlock;
use App\Models\HotSearch;

/**
 * Class BookService
 * @package App\Http\Services
 */
class BookService
{

    public function getCategory()
    {
        $category = BookCategory::where('is_show', 1)->orderBy('list_order', 'asc')->get()->toArray();
        return $category;
    }

    public function getBookList()
    {
        $cat_id = request()->cat_id;
        $pageSize = request()->page_size ?? 15;
        $keyword = request()->keyword;

        $where[] = ['is_show', '=', 1];
        if ($cat_id) {
            $where[] = ['cat_id', '=', $cat_id];
        }
        if ($keyword) {
            $where[] = [function ($query) use ($keyword) {
                return $query->where('name', 'like', "%$keyword%")->orWhere('author', 'like', "%$keyword%");
            }];
        }

        $list = Book::with(['category' => function($query){
            $query->select('id','name');
        }])
            ->where($where)
            ->select('id','name','cat_id','cover','description','author','price','created_at','updated_at')
            ->simplePaginate($pageSize)
            ->toArray();
        //dd($list);

        $res['list'] = $list['data'];
        $res['total'] = $list['to'];
        return $res;
    }

    public function getChapterList()
    {
        $book_id = request()->book_id;
        //$pageSize = request()->page_size ?? 15;
        $where[] = ['book_id', '=', $book_id];
        $list = BookChapter::where($where)->select('id','title')->get()->toArray();
        $res['list'] = $list;
        $res['total'] = count($list);
        return $res;
    }

    public function getChapterDetail()
    {
        $id = request()->id;
        $where[] = ['id', '=', $id];
        $res = BookChapter::where($where)->first();

        //开启传输压缩
        if ($res->content) {
            //$res->content = strip_tags($res->content);
            //$res->content =iconv('utf-8','gbk//IGNORE',$res->content);
            //$res->content = mb_convert_encoding($res->content,'UTF-8','GBK');
            $res->content = base64_encode(gzencode($res->content));
        }
        return $res;
    }

    public function unlockChapter()
    {
        $book_id = request()->book_id;
        $chapter_id = request()->chapter_id;
        $user_id = 1;
        //查询章节是否存在
        $bool = BookChapter::where('book_id', $book_id)->where('id', $chapter_id)->value('id');
        if (!bool) {
            throw new \Exception('解锁的书籍章节不存在');
        }

        //查询当前解锁的书籍信息
        $unlockInfo = ChapterUnlock::where('book_id', $book_id)->where('user_id', $user_id)->select('chapter_id', 'is_all')->first();

        if (!$unlockInfo) {
            //记录信息
            $unlockInfo = [
                'user_id' => $user_id,
                'book_id' => $book_id,
                'chapter_id' => '',
                'is_all' => 0,
                'create_at' => date('Y-m-d H:i:s'),
                'update_at' => date('Y-m-d H:i:s')
            ];
            ChapterUnlock::insert($unlockInfo);
            $chapter_id = '';
        } else {
            $chapter_id = $unlockInfo->chapter_id;
        }

        //进入支付环节

        //成功支付解锁章节
        ChapterUnlock::where('book_id', $book_id)->where('user_id', $user_id)->update(['chapter_id' => $chapter_id]);

    }

    public function getHotSearch(){
        return HotSearch::where([])->orderBy('list_order','asc')->select('id','keyword')->get();
    }
}
