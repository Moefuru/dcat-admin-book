<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChapterUnlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_unlocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('book_id')->default('')->comment('书籍id');
            $table->text('chapter_id')->comment('章节id');
            $table->tinyInteger('is_all')->comment('是否全本解锁');
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
        Schema::dropIfExists('chapter_unlocks');
    }
}
