<?php

namespace App\Admin\Repositories;

use App\Models\BookChapter as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class BookChapter extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
