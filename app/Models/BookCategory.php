<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'book_categorys';

    public function book_category()
    {
        return $this->hasMany(Book::class, 'cat_id', 'id');
    }

}
