<?php

namespace App\Repositories;

use App\Core\Support\AbstractRepository;
use App\Repositories\Models\Account;

class AccountRepository extends AbstractRepository
{
    public function __construct(Account $model)
    {
        $this->model = $model;
    }

    public function index(?int $idUser = null)
    {
        $model = $this->model;

        if (!is_null($idUser)) {
            $model = $model->where('id_user', $idUser);
        }

        return $model->get();
    }
}
