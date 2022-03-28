<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class HotSearch extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'hot_searchs';
    
}
