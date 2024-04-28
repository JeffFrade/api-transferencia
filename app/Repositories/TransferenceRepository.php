<?php

namespace App\Repositories;

use App\Core\Support\AbstractRepository;
use App\Repositories\Models\Transference;
use Illuminate\Support\Facades\DB;

class TransferenceRepository extends AbstractRepository
{
    public function __construct(Transference $model)
    {
        $this->model = $model;
    }

    public function startTransaction()
    {
        DB::beginTransaction();
    }

    public function commitTransaction()
    {
        DB::commit();
    }

    public function rollbackTransaction()
    {
        DB::rollBack();
    }
}
