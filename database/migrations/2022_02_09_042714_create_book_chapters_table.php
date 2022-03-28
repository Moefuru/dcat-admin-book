<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_chapters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('book_id')->default('')->comment('书籍id');
            $table->string('title')->default('')->comment('标题');
            $table->string('content')->default('')->comment('章节内容');
            $table->tinyInteger('is_vip')->comment('是否vip章节');
            $table->tinyInteger('is_lock')->comment('是否锁定');
            $table->integer('list_order')->comment('排序');
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
        Schema::dropIfExists('book_chapters');
    }
}
