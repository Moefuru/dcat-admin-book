<?php

namespace App\Admin\Controllers\Api;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Library\JsonController;

/**
 * Class BookController
 * @package App\Http\Controllers\Api
 */
class BookController extends BaseController
{
    use JsonController;
    public function bookListSelect(Request $request)
    {
        $q = request()->q;
        return Book::where('is_show',1)->where('name','like',"%$q%")->paginate(null, ['id', 'name as text']);
    }
}
