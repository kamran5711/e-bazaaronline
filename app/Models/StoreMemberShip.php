<?php

namespace App\Models;
use App\Models\StoreInvoice;
use Illuminate\Database\Eloquent\Model;

class StoreMemberShip extends Model {

    // protected $table = 'user_verifies';
    protected $guarded = [];
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function store() {
        return $this->belongsTo('App\StoreModal');
    }

    public function store_invoices(){
        return $this->hasMany(StoreInvoice::class, 'store_id', 'store_id')->orderBy('id', 'DESC');
    }
    
}