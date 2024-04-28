<?php

namespace App\Observers;
use App\Repositories\AccountRepository;
use App\Repositories\Models\User;
use App\Repositories\TransferenceRepository;

class UserObserver
{
    public function deleting(User $user)
    {
        app(AccountRepository::class)->customDelete('id_user', $user->id);
        app(TransferenceRepository::class)->customDelete('id_payer', $user->id);
        app(TransferenceRepository::class)->customDelete('id_payee', $user->id);
    }
}
