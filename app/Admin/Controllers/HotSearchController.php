<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\HotSearch;
use App\Models\Book;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class HotSearchController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new HotSearch(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('keyword');
            $grid->column('book_id')->display(function (){
                return $this->book_id;
            });
            $grid->column('list_order')->editable();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

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
        return Show::make($id, new HotSearch(), function (Show $show) {
            $show->field('id');
            $show->field('keyword');
            $show->field('book_id');
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
        return Form::make(new HotSearch(), function (Form $form) {
            $form->display('id');
            $form->text('keyword');
            $form->select('book_id')->options(function ($id){
                $book = Book::find($id);
                if($book){
                    return [$book->id => $book->name];
                }
            })->ajax('/book-list-select');
            $form->number('list_order')->default(100);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
