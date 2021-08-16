<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TnaTerm extends Model
{
    protected $fillable = [
        'tna_id', 'tna_term', 'days', 'responsible_user_type', 'status'
    ];
}
