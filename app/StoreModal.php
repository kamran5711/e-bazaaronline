<?php

namespace App;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Address;
use App\Models\SocialLink;
use App\Models\StoreMemberShip;
use App\Models\StoreInvoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreModal extends Model
{
    protected $table = 'stores';
    // protected $primaryKey = 'id';
    // protected $fillable = ['name','email','phone','building','city','area','address1','address2','domain_link','status'];
    // protected $casts = [
    //     'modules' => 'array',
    // ];
    protected $guarded = [];
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($store) {
            $store->slug = $store->createSlug($store->name);
            $store->save();
        });
    }

    /** 
     * Write code on Method
     *
     * @return response()
     */
    private function createSlug($name){
        if (static::whereSlug($slug = Str::slug($name))->exists()) {
            $max = static::whereName($name)->latest('id')->skip(1)->value('slug');
            if (is_numeric(@$max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
  
            return "{$slug}-2";
        }
  
        return $slug;
    }


    public function user()
    {
        return $this->hasOne(User::class, 'store_id', 'id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'store_or_user_id','id');
    }

    public function social_links()
    {
        return $this->hasOne(SocialLink::class, 'store_id','id');
    }

    public function type()
    {
        return $this->belongsTo(StoreType::class, 'category_id', 'id');
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'store_id', 'id');
    }

    public function membership()
    {
        return $this->hasOne(StoreMemberShip::class, 'store_id', 'id');
    }
    public function store_invoices()
    {
        return $this->hasMany(StoreInvoice::class, 'store_id', 'id');
    }

}
