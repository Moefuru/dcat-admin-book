<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AppUser;
use App\Http\Library\StatusTrait;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class AppUserController extends AdminController
{

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AppUser(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('nick_name');
            $grid->column('head_portrait')->image('',100,100);;
            $grid->column('phone');
            $grid->column('platform')->display(function ($value) {
                return StatusTrait::$platform[$value];
            });
            $grid->column('last_token');
            $grid->column('last_login_time');
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
        return Show::make($id, new AppUser(), function (Show $show) {
            $show->field('id');
            $show->field('nick_name');
            $show->field('head_portrait')->image();
            $show->field('phone');
            $show->field('platform')->as(function ($value) {
                return StatusTrait::$platform[$value];
            });
            $show->field('last_token');
            $show->field('last_login_time');
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
        return Form::make(new AppUser(), function (Form $form) {
            $form->display('id');
            $form->text('nick_name');
            $form->image('head_portrait');
            $form->text('phone');
            $form->select('platform')->options(StatusTrait::$platform);
            $form->text('last_token');
            $form->text('last_login_time');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
