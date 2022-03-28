<?php

namespace App\Admin\Repositories;

use App\Models\ChapterUnlock as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ChapterUnlock extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
