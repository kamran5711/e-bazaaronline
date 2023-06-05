<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];
    public $table = 'store_invoices';
    
    public function user(){

        return $this->belongsTo('App\User');
    
    }


}
