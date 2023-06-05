<?php

namespace App\Http\Controllers\SuperAdmin;

use App\User;
use App\Search;
use Carbon\Carbon;
use App\StoreModal;
use App\SuperAdmin;
use App\Models\StoreMemberShip;
use App\Models\StoreInvoice;
use App\Models\Product;
use App\Models\EmailTemplate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class SuperAdminController extends Controller
{
    public function index(Request $request) {
        if ($request->search != null){
            if($request->type == 'store'){
                $userData = null;//User::get(); 
                $searchdata = DB::table('categories')->where('categories.title','LIKE', '%'.$request->search.'%')->first();
            
                if($searchdata){
                    Search::where('category_id', $searchdata->id)->delete();
                    $searchData = ['category_id' => $searchdata->id, 'store_id' => 0];
                    Search::create($searchData);
                }
                $companies = StoreModal::where('stores.name', 'LIKE', '%'.$request->search.'%')
                    ->where('status', '1')
                    ->get();
                $searchcompany = Search::pluck('category_id')->toArray();
                $categories = DB::table('categories')->whereIn('id', $searchcompany)-> orderBy('id','desc')->paginate(8);
                $search = $request->search;
                return view('store_searched', compact('companies', 'search', 'categories'));
            }
            if($request->type == 'product'){
                $products = Product::with(['productStock' => function ($query) {
                    $query->with(['color', 'size']);
                }, 'store'])
                ->orWhere('products.title', 'LIKE', '%'.$request->search.'%')
                ->where(array('status'=> 'active'))
                ->orderBy('price')
                ->get()
                ->groupBy('store_id');
                return view('product_searched' , compact('products'));
            }
            } else{
                $companies = StoreModal::inRandomOrder()->where('status', '1')->limit(16)->get();
                $searchcompany = Search::pluck('category_id')->toArray();
                // dd($searchcompany);
                $categories= DB::table('store_types')->whereIn('id',$searchcompany)->orderBy('id','desc')->paginate(8);
                // dd($companies);
                return view('welcome' , compact('companies','categories'));
            }
        
    }

    public function product_searched(Request $request){
        $new_products = Product::with(['productStock' => function ($query) {
            $query->with(['color', 'size']);
        }])
        ->where(array('status'=> 'active', 'store_id' => $request->store_id))
        ->whereIn('id', $request->product_ids)
        ->orderBy('id','DESC')
        ->get();
        $last_slug = $request->last_slug;
        return view('frontend.store_product_searched', compact('new_products', 'last_slug'));
    }

    public function superadmin_dashboard()
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::today()->startOfMonth()->subMonth($i);
            $check = "-".$i." month";
            $getMontval = date("m", strtotime($check));
            $getYearval = date("Y", strtotime($check));
            $get = StoreModal::whereYear('created_at', $getYearval)
            ->whereMonth('created_at',$getMontval)
            ->count();
            array_push($data, array(
                'month' => $month->monthName,
                'count' => $get,
            ));
        }
       $monthsdata = array_column($data,'month');
       $count = array_column($data,'count');
       $users =  null;
       return view('backend.super_admin_dashboard', compact('monthsdata','count', 'users'));
    //    return view('superadmin.dashboard.index',compact('monthsdata','count'));
    }
    public function stores()
    {
        $stores = StoreModal::with(['address' => function($query){
            $query->with(['country', 'state', 'city']);
        }, 'user', 'type'])->orderBy('id', 'DESC')->paginate(15);
        // dd($stores);
        return view('backend.users.all_stores')->with('stores',$stores);
    }

    public function show_user($user_id)
    {
        $user = User::with(['user_role', 'address', 'store' => function($query){
            $query->with(['address', 'membership', 'type']);
        }])->findOrFail($user_id);
        return view('superadmin.users.show',compact('user'));
    }

    public function newBusiness()
    {
        $stores = StoreModal::where(['stores.status' => '0'])->with(['address' => function($query){
            $query->with(['country', 'state', 'city']);
        }, 'user', 'type'])->orderBy('id', 'DESC')->get();
        return view('backend.users.pending_stores')->with('stores',$stores);
    }

    public function delete_store($id)
    {
        // delete images and other table data along store user and its records, faqs, pages, payments

        $store = StoreModal::find($id);
        $store_id = $store->id;
        DB::table('addresses')->where(['store_or_user_id'=> $store_id, 'type' => '2'])->delete();
        // banner delete along its photos
        $bannders = DB::table('banners')->where('store_id', $store_id)->get();
        foreach ($bannders as $banner) {
        // $user_image->move('', $fileName);
            $file_path = 'products/images/banners/' . $banner->attachment;
            if(file_exists($file_path) && is_file($file_path)){
                unlink($file_path);
            }
        }
        DB::table('banners')->where('store_id', $store_id)->delete();
        DB::table('brands')->where('store_id', $store_id)->delete();
        DB::table('categories')->where('store_id', $store_id)->delete();
        DB::table('coupons')->where('store_id', $store_id)->delete();
        DB::table('coupon_users')->where('store_id', $store_id)->delete();
        DB::table('discounts')->where('store_id', $store_id)->delete();
        DB::table('orders')->where('store_id', $store_id)->delete();
        DB::table('order_details')->where('store_id', $store_id)->delete();
        DB::table('order_shippings')->where('store_id', $store_id)->delete();
        $posts = DB::table('posts')->where('store_id', $store_id)->get();
        foreach ($posts as $post) {
            $file_path = 'images/posts/' . $post->photo;
            if(file_exists($file_path) && is_file($file_path)){
                unlink($file_path);
            }
            DB::table('post_tag_tags')->where('post_id', $post->id)->delete();           
        }
        DB::table('posts')->where('store_id', $store_id)->delete();
        DB::table('post_categories')->where('store_id', $store_id)->delete();
        DB::table('post_comments')->where('store_id', $store_id)->delete();
        DB::table('post_tags')->where('store_id', $store_id)->delete();
        $products = DB::table('products')->where('store_id', $store_id)->get();
        foreach ($products as $product) {
            $file_path = 'images/products/' . $product->photo;
            if(file_exists($file_path) && is_file($file_path)){
                unlink($file_path);
            }
            $product_images = DB::table('product_images')->where('product_id', $product->id)->get();
            foreach ($product_images as $product_image) {
                $file_path = 'products/images/' . $product_image->image;
                if(file_exists($file_path) && is_file($file_path)){
                    unlink($file_path);
                }
            }
            DB::table('product_images')->where('product_id', $product->id)->delete();
            DB::table('product_reviews')->where('product_id', $product->id)->delete();
            DB::table('product_stocks')->where('product_id', $product->id)->delete();
            DB::table('return_orders')->where('product_id', $product->id)->delete();
        }
        DB::table('shippings')->where('store_id', $store_id)->delete();            
        DB::table('products')->where('store_id', $store_id)->delete();
        DB::table('sizes')->where('store_id', $store_id)->delete();
        DB::table('social_links')->where('store_id', $store_id)->delete();

        StoreMemberShip::where('store_id', '=', $store_id)->delete();
        $invoices = StoreInvoice::where('store_id', $store_id)->get();
        foreach ($invoices as $invoice) {
            $file_path = 'images/store_invoices/' . $invoice->attachment;
            if(file_exists($file_path) && is_file($file_path)){
                unlink($file_path);
            }
        }
        StoreInvoice::where('store_id', $store_id)->delete();
        DB::table('taxes')->where('store_id', $store_id)->delete();
        DB::table('users')->where('store_id', $store_id)->delete();
        StoreModal::where('id', $store_id)->delete();
        $user = User::where('store_id', $store_id)->first();
        if($user){
            $user_id = $user->id;
            $user->delete();
        }
        return back()->with('success', 'Store has been deleted along its all related data.');
    }

    public function disable_store($id)
    {
        $store = StoreModal::find($id);
        $store->status = '2';
        $store->update();
        $user = User::where('store_id', $id)->firstOrFail();
        $user->status = 'inactive';
        $user->update();
        $store_membership = StoreMemberShip::where('store_id', $id)->first();
        if ($store_membership !== null) {
            $store_membership->status = 'inactive';
            $store_membership->update();
        }
        return back()->with('success', 'Store has been disabled along its user.');
    }

    public function enable_store($id)
    {
        $store = StoreModal::find($id);
        $store->status = '1';
        $store->update();
        $user = User::where('store_id', $id)->firstOrFail();
        $user->status = 'active';
        $user->update();
        $store_membership = StoreMemberShip::where('store_id', $id)->first();
        if ($store_membership !== null) {
            $store_membership->status = 'active';
            $store_membership->update();
        }
        return back()->with('success', 'Store has been enable along its user');
    }

    

    public function disableUser($id)
    {
        $user = StoreModal::find($id);
        $user->status='0';
        $user->update();
        return back()->with('success', 'User has been Disabled');
    }

    public function enableUser(Request $request, $id) {
        // dd($request->all());
        $modules = [
            'shop' => 0,
            'app' => 0,
        ];
        if($request->has('shop') ):
            $modules['shop'] = 1;
        endif;
        if($request->has('app') ):
            $modules['app'] = 1;
        endif;
    
        $store = StoreModal::find($id);
        $store->status = $request->is_active;
        $store->modules = $modules;
        $store->update();

        $user = User::where('store_id', $store->id)->first()->update(['status' => 'active']);

        $charges = [];
        $charges['store_id'] = $store->id;
        $charges['web_charges'] = $request->web_charges;
        $charges['app_charges'] = $request->app_charges;
        $charges['shop_charges'] = $request->shop_charges;
        $charges['setup_charges'] = $request->setup_charges;
        $charges['software_charges'] = $request->software_charges;
        $charges['free_trail'] = $request->free_trail;
        $charges['invoice_terms'] = $request->invoice_terms;
        $membership_total_time = $request->free_trail * $request->invoice_terms;
        if($request->invoice_terms != 1){
            $membership_total_time = $membership_total_time - 1;
        }
        $charges['expiry_date'] = date(("Y-m-t"), strtotime(" +$membership_total_time months"));
        StoreMemberShip::updateOrCreate($charges);
        $start_date = date("Y-m-01");
        $start_date = date(("Y-m-01"), strtotime($start_date." +1 months"));
        $total = 0;

        if(!empty($request->setup_charges))
            $total = $total + $request->setup_charges;
        if(!empty($request->software_charges))
            $total = $total + $request->software_charges;

        $invoice_amount = $total;
        $invoice_terms = $request->invoice_terms;        
        $invoice_terms = $invoice_terms - 1;

        for ($i = 0; $i < $request->free_trail; $i++) {
            $invoice = [];
            $invoice['store_id'] = $id;
            $invoice['payment'] = $invoice_amount;
            $invoice['start_date'] = date(("Y-m-01"), strtotime($start_date));
            $invoice['status'] = 2;
            $invoice['expiry_date'] = date(("Y-m-t"), strtotime($start_date." +$invoice_terms months"));//date(("Y-m-t"), strtotime($start_date));
            StoreInvoice::updateOrCreate($invoice);
            $invoice_amount = 0;
            $start_date = $invoice['expiry_date'];//date(("Y-m-01"), strtotime($start_date." +1 months"));
        }
        $user = User::where('store_id', $store->id)->first()->toArray();
        $t_mail = $store->email;
        $template_data = EmailTemplate::find(2);
        try {
          Mail::send('email.register', ['name'=> $user->name, 'template_data'=> $template_data], function ($message) use ($t_mail , $template_data) {
            $message->to($t_mail);
            $message->subject($template_data->subject);
           });
        } catch (\Throwable $th) {
            throw $th;
        }
        return back()->with('success', 'User and store has been Enabled successfully.');
    }

        /*
    Admin Profile 
    */
    public function profileAdmin()
    {
        
        $user = SuperAdmin::findOrFail(auth('superadmin')->user()->id); 
        return view('superadmin.profile',compact('user'));   
    }


    public function store_registration_email() {
        $title = "Store Registration Email";
        $record = EmailTemplate::find(1);
        return view('backend.email_pages.store_registration_email', compact('record', 'title'));
    }

    public function store_varification_email(){
        $title = "Store Varification Email";
        $record = EmailTemplate::find(2);
        return view('backend.email_pages.store_registration_email', compact('record', 'title'));
    }

    public function order_placement_email(){
        $title = "Order Placement Email";
        $record = EmailTemplate::find(3);
        return view('backend.email_pages.store_registration_email', compact('record', 'title'));
    }

    public function order_status_change_email(){
        $title = "Order Status Change Email";
        $record = EmailTemplate::find(4);
        return view('backend.email_pages.store_registration_email', compact('record', 'title'));
    }

    public function update_email_template(Request $request)
    {
        // dd($request->all());
        $dataToUpdate = [];
        $dataToUpdate['subject'] = $request->subject;
        $dataToUpdate['contents'] = $request->contents;
        $dataToUpdate['mention_receiver_name'] = false;
        if($request->has('mention_receiver_name')){
            $dataToUpdate['mention_receiver_name'] = $request->mention_receiver_name;
        }
        EmailTemplate::where('id', $request->record_id)->update($dataToUpdate);
        return back()->with('success', 'Email template data updated successfully.');
    }
    /*
        Update Profile Admin

    */
     public function updateAdminProfile(Request $request){
        $get = auth('superadmin')->user();
        $this->validate($request,[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins,id,'.$get->id,
        ]);
        $user = SuperAdmin::findOrFail($get->id);
        $user->username = $request->name;
        $user->email = $request->email;
        if($request->password){
            $this->validate($request,[
                'password' => 'min:6|confirmed',
            ]);
            $user->password = bcrypt($request->password);
        }
        $user->save();
        session()->flash('message', 'Your profile is updated successfully');
        return redirect('superadmin/profile');
    }
}
