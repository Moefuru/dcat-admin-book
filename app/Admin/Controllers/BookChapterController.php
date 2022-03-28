<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\BookChapter;
use App\Models\Book;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class BookChapterController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    public function grid()
    {
        return Grid::make(new BookChapter(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('book_id')->display(function (){
                return $this->book->name;
            });
            $grid->column('title');
            //$grid->column('content');
            $grid->column('is_vip')->status()->switch();
            $grid->column('is_lock')->status()->switch();
            $grid->column('list_order');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('title');
            });
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    public function tableList()
    {
        return Grid::make(new BookChapter(), function (Grid $grid) {
            $grid->column('id')->sortable();
            //$grid->column('book_id')->display(function (){
            //    return $this->book->name;
            //});
            $grid->column('title');
            //$grid->column('content');
            //$grid->column('is_vip')->status()->switch();
            //$grid->column('is_lock')->status()->switch();
            $grid->column('list_order');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('title');
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
        return Show::make($id, new BookChapter(), function (Show $show) {
            $show->field('id');
            $show->field('book_id')->as(function () {
                return $this->book->name;
            });;
            $show->field('title');
            $show->content()->as(function ($content) {
                return $content;
            });
            $show->field('is_vip');
            $show->field('is_lock');
            $show->field('list_order');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new BookChapter(), function (Form $form) {
            $form->display('id');
            $book = Book::where('is_show', 1)->pluck('name','id');
            $form->select('book_id')->options($book)->required();
            //$form->text('book_id');
            $form->text('title');
            $form->textarea('content');
            $form->switch('is_vip');
            $form->switch('is_lock');
            $form->number('list_order')->default(0);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
