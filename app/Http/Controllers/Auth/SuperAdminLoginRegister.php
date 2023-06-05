<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\StoreType;
use App\StoreModal;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class SuperAdminLoginRegister extends Controller
{
    public function login_view()
    {
        return view('superadmin.login');
    }

    public function login_process(Request $request)
    {
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required'
      ]);
      
      if (auth()->guard('superadmin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        return redirect()->intended(route('superadmin.dashboard'));
      } 

      return back() ->withInput()
      ->withErrors(['message_error'=>'Email or password is incorrect']);
    }

    public function register_view(){
        $category  = StoreType::get();
        $countries = Country::get(["id", "name"]);
        return view('superadmin.register',compact('category', 'countries'));
    }

    public function get_states_by_country_id($id) {
        $states = State::where('country_id', $id)->select("id", "name")->get();
        return response()->json($states);
    }

    public function get_cities_by_state_id($id) {
        $cities = City::where('state_id', $id)->select("id", "name")->get();
        return response()->json($cities);
    }

    public function test()
    {
      try {
        Mail::send('email.register', ['user'=> $user], function ($message) use ($t_mail ,$user) {
          $message->to($t_mail);
           $message->subject('Registration');
         });
      } catch (\Throwable $th) {
        
      }
    }

    public function register(Request $request)
    {
      $request->validate([
        // 'domain'      => ['required','min:3','unique:stores,domain_link'], 
        'domain' => ['required'],
        // 'address'     => ['required', 'string'],
        // 'building'    => ['required', 'string'],
        'address1'    => ['required', 'string'],
        // 'area'        => ['required'],
        // 'city'         => ['required', 'string'],
        // 'postcode'     => ['required'],process_signup
        'business_contact_number'     => ['required'],
        'email'        => ['required', 'email', 'max:255', 'unique:users,email'],
        'person_name'  => ['required', 'string'],
        'person_tel'   => ['required'],
        'password'     => ['required', 'string', 'min:8', 'confirmed'],
        'short_description'=> ['required'], 
        // 'long_description' => ['required'],
        'image' => 'image|mimes:jpg,jpeg,png,bmp,gif,svg,webp,pdf,docx|max:2024',  
    ]);


    //  $recaptcha = $request['g-recaptcha-response'];
    // $res = $this->reCaptcha($recaptcha);
    
    // if(!$res['success']){
        
    //        return back()->with('error', 'Please check the recaptcha');
    //        exit;
    //   // Error
    // }
    $store_image = $user_image = '';
    if($request->has('image')){
      $user_image = $request->file('image');
      $extension = $user_image->getClientOriginalExtension();
      $fileName = uniqid() . '.' . $extension;
      $store_image = $user_image->move('images/stores', $fileName);
      copy($store_image, 'images/profile/'.$fileName);
      // $user_image = $user_image->move('images/profile', $fileName);
      $store_image = $user_image = $fileName;
    }
    // create store
    $storeData = [
      'name' => $request->input('domain'),
      'motto' => $request->input('domain'),
      'email' => $request->input('email'),
      'short_description' => $request->input('short_description'),
      'long_description' => $request->input('long_description'),
      'phone'    => $request->input('business_contact_number'),
      'image'    => $store_image,
      'category_id' => $request->input('category_id'),
      'modules' => json_encode(['shop' => 0, 'app' => 0]),
      'domain_link' => null, 
      'status' => '0',
    ];

    if($request->has('tax_dep_nu'))
      $storeData['tax_department_number'] = $request->input('tax_dep_nu');
    if($request->has('company_reg_no'))
      $storeData['registration_number'] = $request->input('company_reg_no');
    if($request->has('your_business'))
      $storeData['bussiness_type'] = $request->input('your_business');

    if($request->hasFile('company_reg_cerf')){
        $user_image = $request->file('company_reg_cerf');
        $extension = $user_image->getClientOriginalExtension();
        $fileName = uniqid() . '.' . $extension;
        $user_image->move('images/stores', $fileName);
        $storeData['registration_certificate'] = $fileName;
    }
    if($request->hasFile('tax_dep_cerf')){
        $user_image = $request->file('tax_dep_cerf');
        $extension = $user_image->getClientOriginalExtension();
        $fileName = uniqid() . '.' . $extension;
        $user_image->move('images/stores', $fileName);
        $storeData['tax_department_certificate'] = $fileName;
    }
  
    if($request->hasFile('other_reg_docu')){
        $user_image = $request->file('other_reg_docu');
        $extension = $user_image->getClientOriginalExtension();
        $fileName = uniqid() . '.' . $extension;
        $user_image->move('images/stores', $fileName);
        $storeData['other_registeration_ducoment'] = $fileName;
    }
  
    $store = StoreModal::create($storeData);
    $userArray = [
      'store_id'          => $store->id,
      'role_id'           => 2,
      'is_active'         => 1,
      'role'              => 'bussiness',
      'name'              => $request->input('person_name'),
      'email'             => $request->input('email'),
      'phone'             => $request->input('person_tel'),
      'photo'             => $user_image,
      'password'          => Hash::make($request->input('password'))
    ];   
    $user = User::create($userArray);
    $address_array = [
      'store_or_user_id' => $store->id,
      'type' => 2,
      'postcode' => $request->input('postcode'),
      'country_id' => $request->input('country_id'),
      'state_id' => $request->input('state_id'),
      'city_id' => $request->input('city_id'),
      'address1' => $request->input('address1'),
      'address2' => $request->input('address2'),
    ];
    Address::create($address_array);
    $address_array['store_or_user_id'] = $user->id;
    $address_array['type'] = 1;
    Address::create($address_array);

    $t_mail = $request->input('email');
    $template_data = EmailTemplate::find(1);
    try {
      Mail::send('email.register', ['name'=> $user->name, 'template_data'=> $template_data], function ($message) use ($t_mail , $template_data) {
        $message->to($t_mail);
        $message->subject($template_data->subject);
       });
    } catch (\Throwable $th) {
        throw $th;
    }
 
    $business = Crypt::encryptString($request->input('your_business'));
    $name = Crypt::encryptString($request->input('person_name'));
    $contact = Crypt::encryptString($request->input('person_tel'));
    session()->flash('message', 'Your are register successfully. Please login ');
    return redirect()->route('register_success',['business'=> $business,'name'=>$name,'contact' => $contact]);

    }

  public function register_success($business,$name,$contact)
  {
    $business = Crypt::decryptString($business);
    $name = Crypt::decryptString($name);
    $contact = Crypt::decryptString($contact);
    return view('superadmin.register_success')->with(['business' => $business,'name'=> $name,'contact'=>$contact]);
  }
}
