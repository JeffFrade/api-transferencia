<?php

namespace App\Repositories;

use App\Core\Support\AbstractRepository;
use App\Repositories\Models\Transference;

class TransferenceRepository extends AbstractRepository
{
    public function __construct(Transference $model)
    {
        $this->model = $model;
    }
}
