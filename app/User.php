<?php

namespace App;
use App\Models\Address;
use App\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $guarded=['id'];
    // protected $fillable = [
    //     'name', 'email', 'password','role','photo','status','provider','provider_id',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function address(){
        return $this->hasOne(Address::class, 'store_or_user_id', 'id');
    }

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    public function user_role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function isAdmin()
    {
        if($this->role->name=='Admin' && $this->is_active==1){
            return true;
        };
        return false;
    }

        public function isSubscriber()
    {
        if($this->role->name=='Subscriber' && $this->is_active==1){
            return true;
        };

        return false;
    }

     public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    public function store()
    {
        return $this->belongsTo('App\StoreModal', 'store_id', 'id');
    }
}
