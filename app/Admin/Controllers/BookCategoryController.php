<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\BookCategory;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class BookCategoryController extends AdminController
{
    protected $status = [
        'on' => ['value' => 1, 'text' => 'open', 'color' => 'primary'],
        'off' => ['value' => 0, 'text' => 'close', 'color' => 'default'],
    ];

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new BookCategory(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('list_order');
            $grid->column('is_show')->switch();
            $grid->column('cover')->image('',100,100);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name', '分类名称');
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
        return Show::make($id, new BookCategory(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('list_order');
            $show->field('is_show');
            $show->field('cover')->image();
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
        return Form::make(new BookCategory(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->number('list_order')->default(100);
            $form->switch('is_show');
            $form->image('cover');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
