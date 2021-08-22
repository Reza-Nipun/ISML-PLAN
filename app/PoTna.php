<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoTna extends Model
{
    public function po()
    {
        return $this->belongsTo(Po::class, 'po_id');
    }

    public function tna_term()
    {
        return $this->belongsTo(TnaTerm::class, 'tna_term_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
