<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class BookCollection extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'book_collections';

    public function book()
    {
        return $this->hasMany(Book::class, 'id', 'book_id');
    }

    public function chapter()
    {
        return $this->hasOne(BookChapter::class, 'id', 'last_read_chapter_id');
    }
}
