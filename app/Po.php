<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
    protected $fillable = [
        'order_no', 'po', 'destination', 'quality', 'color', 'style_no', 'style_name', 'buyer_id', 'ship_date', 'order_quantity', 'po_type', 'plant_id', 'uploaded_by', 'actual_ship_date', 'actual_ship_quantity'
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id');
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_id');
    }

    public function tna()
    {
        return $this->belongsTo(Tna::class, 'tna_id');
    }

    public function po_tnas(){
        return $this->hasMany(PoTna::class,'po_id');
    }
}
