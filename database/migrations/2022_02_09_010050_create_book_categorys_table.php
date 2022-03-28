<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookCategorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_categorys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('分类名');
            $table->integer('list_order')->default('100')->comment('排序');
            $table->tinyInteger('is_show')->default('1')->comment('状态');
            $table->string('cover')->nullable()->comment('封面');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_categorys');
    }
}
