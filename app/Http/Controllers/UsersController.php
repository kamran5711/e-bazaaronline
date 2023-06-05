<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::where('store_id',auth()->user()->store_id)->orderBy('id','ASC')->paginate(10);
        return view('backend.users.index')->with('users',$users);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

       
  function reCaptcha($recaptcha){
  $secret = "6Lfj_CQeAAAAAPnvt2gDUQAtGlmcGIyNdHhjHwO1";
  $ip = $_SERVER['REMOTE_ADDR'];

  $postvars = array("secret"=>$secret, "response"=>$recaptcha, "remoteip"=>$ip);
  $url = "https://www.google.com/recaptcha/api/siteverify";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
  $data = curl_exec($ch);
  curl_close($ch);

  return json_decode($data, true);
}
    public function store(Request $request)
    {
        
        $data=$request->all();
        $this->validate($request,
        [
            'name'=>'string|required|max:30',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'confirmed'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'building'=>'required',
            'address1'=>'required',
            'area'=>'required',
            'city'=>'required',
            'postcode'=>'required',
            'role'=>'required|in:admin,user,operator',
            'status'=>'required|in:active,inactive',
           // 'photo'=>'nullable|string',
        ]);
        $recaptcha = $request['g-recaptcha-response'];
        $res = $this->reCaptcha($recaptcha);
        
        if(!$res['success']){
            
               return back()->with('error', 'Please check the recaptcha');
               exit;
          // Error
        }
        if($request->hasFile('photo')){
            $user_image = $request->file('photo');
            $extension = $user_image->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $extension;
            $user_image->move('products/images/profile', $fileName);
            $data['photo']= $fileName;
            }
            else {
                $photo='';
            }
        $data['store_id'] = auth()->user()->store_id;
        $data['password']=Hash::make($request->password);
        $status=User::create($data);
        if($status){
            request()->session()->flash('success','Successfully added user');
        }
        else{
            request()->session()->flash('error','Error occurred while adding user');
        }
        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
        return view('backend.users.edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $this->validate($request,
        [
          'name'=>'string|required|max:30',
            'building'=>'required',
            'address1'=>'required',
            'area'=>'required',
            'city'=>'required',
            'postcode'=>'required',
            'role'=>'required|in:admin,user,operator',
            'status'=>'required|in:active,inactive',
          //  'photo'=>'nullable|string',
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
       //dd($data);
       if($request->hasFile('photo')){
        $user_image = $request->file('photo');
        $extension = $user_image->getClientOriginalExtension();
        $fileName = uniqid() . '.' . $extension;
        $user_image->move('products/images/profile', $fileName);
        $data['photo']= $fileName;
        }
        else {
            $photo='';
        }
        //dd($user);
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated');
        }
        else{
            request()->session()->flash('error','Error occured while updating');
        }
        return redirect()->route('users.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete=User::findorFail($id);
        $status=$delete->delete();
        if($status){
            request()->session()->flash('success','User Successfully deleted');
        }
        else{
            request()->session()->flash('error','There is an error while deleting users');
        }
        return redirect()->route('users.index');
    }
}
