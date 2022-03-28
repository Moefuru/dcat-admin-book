<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'books';

    public function category()
    {
        return $this->belongsTo(BookCategory::class,'cat_id', 'id');
    }

    public function chapter()
    {
        return $this->hasMany(BookChapter::class,'book_id', 'id');
    }

    public function collection()
    {
        return $this->belongsTo(BookCollection::class,'book_id', 'id');
    }
}
