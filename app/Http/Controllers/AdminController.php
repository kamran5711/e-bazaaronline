<?php

namespace App\Http\Controllers;
use Hash;
use App\User;
use Carbon\Carbon;
use App\StoreModal;
use App\StoreType;
use App\Models\Country;
use App\Models\Address;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    public function index()
    {
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->where('store_id',auth()->user()->store_id)
        ->orderBy('day')
        ->get();
     $array[] = ['Name', 'Number'];
     foreach($data as $key => $value)
     {
       $array[++$key] = [$value->day_name, $value->count];
     }
     return view('backend.index')->with('users', json_encode($array));
    }

    public function profile(){
        $user_id = Auth()->user()->id;
        $profile = User::with(['address'=> function($query){
            $query->with('country', 'state', 'city');
        }, 'store' => function($query1){
            $query1->with(['address'=> function($query2){
                $query2->with('country', 'state', 'city');
            }]);
        }])->where('id', $user_id)->first();
        $countries = Country::all();
        $categories = StoreType::all();
        // dd($profile);
        return view('backend.users.profile', compact('profile', 'countries', 'categories'));
    }

    public function profileUpdate(Request $request, $id){
        // dd($request->all());
        $user_data = [];
        $user_address = [];
        $store_data = [];
        $store_address = [];
 
        $user = User::findOrFail($id);
        $user_address_m = Address::findOrFail($request->user_address_id);
        $store = StoreModal::findOrFail($request->store_id);
        $store_address_m = Address::findOrFail($request->store_address_id);

        $user_data['name'] = $request->name;
        $user_data['email'] = $request->email;
        $user_data['phone'] = $request->phone;
        if($request->hasFile('photo')){
            $user_image = $request->file('photo');
            $extension = $user_image->getClientOriginalExtension();
            $fileName = Str::random(20) . '.' . $extension;
            $user_image->move('images/profile/', $fileName);
            $user_data['photo']= $fileName;
            $user_image__ = 'images/profile/'.$request->user_image;
            if (file_exists($user_image__) && is_file($user_image__))
                unlink($user_image__);
        }
        $user_status = $user->fill($user_data)->update();

        $user_address['country_id'] = $request->country_id;
        $user_address['state_id'] = $request->state_id;
        $user_address['city_id'] = $request->city_id;
        $user_address['address1'] = $request->address1;
        if($request->has('address2'))
            $user_address['address2'] = $request->address2;
        if($request->has('postcode'))
            $user_address['postcode'] = $request->postcode;

        $user_address_status = $user_address_m->fill($user_address)->update();

        $store_data['name'] = $request->name;
        $store_data['email'] = $request->store_email;
        $store_data['phone'] = $request->store_phone_number;
        $store_data['category_id'] = $request->store_type;
        if($request->hasFile('store_photo')){
            $user_image = $request->file('store_photo');
            $extension = $user_image->getClientOriginalExtension();
            $fileName = Str::random(20) . '.' . $extension;
            $user_image->move('images/stores/', $fileName);
            $store_data['image']= $fileName;
            $store_image__ = 'images/stores/'.$request->store_image;
            if (file_exists($store_image__) && is_file($store_image__))
                unlink($store_image__);
        }
        if($request->has('long_description'))
            $store_data['long_description'] = $request->long_description;
        if($request->has('short_description'))
            $store_data['short_description'] = $request->short_description;
        
        $store_status = $store->fill($store_data)->update();

        $store_address['country_id'] = $request->store_country_id;
        $store_address['state_id'] = $request->store_state_id;
        $store_address['city_id'] = $request->store_city_id;
        $store_address['address1'] = $request->store_address_1;
        if($request->has('store_address_2'))
            $store_address['address2'] = $request->store_address_2;
        if($request->has('store_post_code'))
            $store_address['postcode'] = $request->store_post_code;

        $store_address_m_status  = $store_address_m->fill($user_address)->update();

        if($store_status || $user_status || $store_address_m_status || $user_address_status ){
            request()->session()->flash('success','Successfully updated your profile');
            return redirect()->back()->with('success','Successfully updated your profile');
        }
        else{
            request()->session()->flash('error','Please try again!');
            return redirect()->back()->with('error', 'Please try again!');
        }
    }

    public function changePassword(){
        return view('backend.layouts.changePassword');
    }

    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return redirect()->route('admin')->with('success','Password successfully changed');
    }

    // Pie chart
    public function userPieChart(Request $request){
        // dd($request->all());
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
     $array[] = ['Name', 'Number'];
     foreach($data as $key => $value)
     {
       $array[++$key] = [$value->day_name, $value->count];
     }
     return view('backend.index')->with('course', json_encode($array));
    }
}
