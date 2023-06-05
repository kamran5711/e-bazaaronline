<?php

namespace App\Models;
use App\Models\StoreMemberShip;
use Illuminate\Database\Eloquent\Model;

class StoreInvoice extends Model {

    // protected $table = 'user_verifies';
    protected $guarded = [];
    public function store() {
        return $this->belongsTo('App\StoreModal');
    }
    public function membership() {
        return $this->belongsTo(StoreMemberShip::class, 'store_id', 'store_id');
    }
}