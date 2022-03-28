<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_collections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid')->default('')->comment('用户id');
            $table->string('book_id')->default('')->comment('书籍id');
            $table->string('last_read_chapter_id')->default('')->comment('最后阅读章节');
            $table->string('list_order')->default('')->comment('顺序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_collections');
    }
}
