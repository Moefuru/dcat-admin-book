<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\BookCollection;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class BookCollectionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new BookCollection(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('uid');
            $grid->column('book_id');
            $grid->column('last_read_chapter_id');
            $grid->column('list_order');
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
        return Show::make($id, new BookCollection(), function (Show $show) {
            $show->field('id');
            $show->field('uid');
            $show->field('book_id');
            $show->field('last_read_chapter_id');
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
        return Form::make(new BookCollection(), function (Form $form) {
            $form->display('id');
            $form->text('uid');
            $form->text('book_id');
            $form->text('last_read_chapter_id');
            $form->text('list_order');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
