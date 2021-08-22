<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TnaTerm extends Model
{
    protected $fillable = [
        'tna_id', 'tna_term', 'days', 'responsible_user_type', 'status'
    ];

    public function responsible_users_type()
    {
        return $this->belongsTo('App\UserType', 'responsible_user_type');
    }
}
