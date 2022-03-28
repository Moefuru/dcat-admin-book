<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\ChapterUnlock;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ChapterUnlockController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ChapterUnlock(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('book_id');
            $grid->column('chapter_id');
            $grid->column('is_all');
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
        return Show::make($id, new ChapterUnlock(), function (Show $show) {
            $show->field('id');
            $show->field('book_id');
            $show->field('chapter_id');
            $show->field('is_all');
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
        return Form::make(new ChapterUnlock(), function (Form $form) {
            $form->display('id');
            $form->text('book_id');
            $form->text('chapter_id');
            $form->text('is_all');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
