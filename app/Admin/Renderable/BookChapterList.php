<?php

namespace App\Admin\Renderable;

use App\Admin\Controllers\BookChapterController;
use App\Admin\Widgets\Charts\Bar;
use App\Models\BookChapter;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class BookChapterList extends LazyRenderable
{
    ///**
    // * @var mixed|null
    // */
    //private $id;
    //
    //public function render()
    //{
    //    // 获取外部传递的参数
    //    $id = $this->id;
    //
    //    // 查询数据逻辑
    //    //$data = BookChapter::where('book_id',$id)->get('id','title')->toArray();
    //    ////dd($data);
    //    //// 这里可以返回内置组件，也可以返回视图文件或HTML字符串
    //    //return Bar::make($data);
    //    return (new BookChapterController)->grid();
    //}

    public function grid(): Grid
    {
        // TODO: Implement grid() method.
        return (new BookChapterController)->tableList();
    }
}
