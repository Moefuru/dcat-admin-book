<?php

namespace App\Admin\Repositories;

use App\Models\BookCollection as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class BookCollection extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
