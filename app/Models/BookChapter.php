<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BookChapter extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'book_chapters';

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    public function collection()
    {
        return $this->belongsTo(BookCollection::class, 'last_read_chapter_id', 'id');
    }
}
