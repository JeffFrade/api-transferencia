<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transference extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_payer',
        'id_payee',
        'value'
    ];
}
