<?php

namespace App\Admin\Repositories;

use App\Models\HotSearch as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class HotSearch extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
