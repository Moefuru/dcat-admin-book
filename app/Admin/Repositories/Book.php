<?php

namespace App\Admin\Repositories;

use App\Models\Book as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Book extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
