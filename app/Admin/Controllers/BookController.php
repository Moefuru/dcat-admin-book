<?php

namespace App\Admin\Controllers;

use App\Admin\Renderable\BookChapterList;
use App\Admin\Repositories\Book;
use App\Http\Library\StatusTrait;
use App\Models\BookCategory;
use App\Models\BookChapter;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Lazy;

class BookController extends AdminController
{
    protected $eloquentClass = BookCategory::class;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Book(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('cover')->image('',100,100);
            $category = BookCategory::all()->pluck('name','id');
            //$grid->column('cat_id');
            $grid->column('cat_id')->display(function () {
                return $this->category->name;
            })->sortable();
            $grid->column('description');
            $grid->column('getChapter')->display('章节')
                ->modal('章节列表', function(){
                    $chart = BookChapterList::make()->payload(['id' => $this->id]);
                    //$data = BookChapter::where('book_id',$this->id)->get('id','title')->toArray();
                    //dd($data);
                    return $chart;
                    //return $this->view(Lazy::make($chart));
                });
            $grid->column('author');
            $grid->column('status')->display(function (){
                return StatusTrait::$bookStatus[$this->status];
            });
            $grid->column('price')->editable();
            //$grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) use ($category) {
                $filter->equal('id');
                $filter->like('name', '书籍名称');
                $filter->like('author', '作者');
                $filter->equal('cat_id', '分类')->select($category);
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Book(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('cover')->image();
            $show->field('cat_id')->as(function (){
                return $this->category->name;
            });
            $show->field('description');
            $show->field('author');
            $show->field('price');
            $show->field('status')->as(function ($value){
                return StatusTrait::$bookStatus[$value];
            });
            $show->field('created_at');
            $show->field('updated_at');
            $show->field('chapter')->as(function (){
                return $this->chapter->pluck('title','id');
            })->label();

            // 传入闭包
            //$show->html(function () {
            //    // 获取字段信息
            //    $day = date('d',time());
            //    return view('calendar', ['day' => $day]);
            //});
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Book(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('cover');
            $category = BookCategory::where('is_show', 1)->pluck('name','id');
            $form->select('cat_id')->options($category);

            $form->textarea('description');
            $form->text('author');
            $form->select('status')->options(StatusTrait::$bookStatus);
            $form->text('price');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
