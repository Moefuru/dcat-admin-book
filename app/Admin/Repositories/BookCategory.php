<?php

namespace App\Admin\Repositories;

use App\Models\BookCategory as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class BookCategory extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
