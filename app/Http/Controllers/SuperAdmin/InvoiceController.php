<?php
namespace App\Http\Controllers\SuperAdmin;
use Auth;
use App\User;
use App\Invoice;
use App\StoreModal;
use App\Models\StoreMemberShip;
use App\Models\StoreInvoice;
Use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{

    

    public function index()
    {
        
        $inoices = Invoice::where('user_id',Auth::id() )->get();
        return view('subscriber.inoice.index', compact('inoices'));
        //
    }
    public function store_invoices($id) {
        $store = StoreModal::with(['user', 'membership', 'store_invoices' => function($query){
            $query->orderBy('id', 'DESC');
        }])->where('id', $id)->first();
        return view('superadmin.Invoice.store_payments', compact('store'));
    
    }

    public function store_extend_membership(Request $request){
        $request->validate([
            'payment'    => ['string'],
            // 'payment'    => ['required', 'string'],
            'attachment' => 'image|mimes:jpg,jpeg,png,bmp,gif,svg,webp,pdf,docx|max:2024',  
        ]);
        $invoice_data = $request->except(['_token', 'member_ship_id', 'store_id']);
        if($request->has('attachment')){
            $attachment = $request->file('attachment');
            $extension = $attachment->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $extension;
            $attachment->move('images/store_invoices/', $fileName);
            $invoice_data['attachment'] = $fileName;
        }

        StoreInvoice::where('id', $request->member_ship_id)->update($invoice_data);
        session()->flash('success', 'Invoice successfully proceed to super admin.');
        return back();
    }

    public function invoice_create(Request $request){
        $request->validate([
            'payment'    => ['string'],
            // 'payment'    => ['required', 'string'],
        ]);
        $invoice_data = $request->except(['_token']);
        StoreInvoice::create($invoice_data);
        StoreMemberShip::where('store_id', $request->store_id)->update(['expiry_date' => $request->expiry_date, 'status' => 'active']);
        session()->flash('success', 'Invoice successfully generated.');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         
        $inoice = Invoice::where(['user_id'=>Auth::id(),'id'=>$id])->first();
      
        
        return view('subscriber.inoice.view',compact('inoice'));
    }
  
    public function invoiceReturn2(Request $request)
    {
       // dd($request->input('ppmpf_5'));

    
        $User = User::findOrFail($request->input('ppmpf_5'));
        
    
     // if ( strpos( $request -> pp_TxnRefNo , 'FLT' ) !== false ) {
      
      if (  $request -> pp_TxnCurrency =='PKR') {
          
           DB ::table( 'jazzcash_response' ) -> insert( [
            'pp_MerchantID' => $request -> pp_MerchantID ,
            'pp_ResponseCode' => $request -> pp_ResponseCode ,
            'pp_ResponseMessage' => $request -> pp_ResponseMessage ,
            'pp_Amount' => $request -> pp_Amount ,
            'pp_TxnDateTime' => $request -> pp_TxnDateTime ,
            'pp_TxnRefNo' => $request -> pp_TxnRefNo ,
            'created_at' => now()
        ] );


            $txn_ref_no = $request -> pp_TxnRefNo;
            //print_r($request->all());
            //if (  $request -> pp_TxnCurrency =='PKsR') {
            if ( $request -> pp_ResponseCode == 000 || $request -> pp_ResponseCode == 124 ) {
              
                $invoiceId = $request->input('ppmpf_5');
                
                //$invoiceId = 10;
                
                $invoice = Invoice::findOrFail($invoiceId);

                //print_r($invoice);exit;
                
                $invoice->status =1;
                
                $invoice->update(); 

                /*
                    Update User
                */

                //   print_r($invoice->user->id);exit;   

                $User = User::findOrFail($invoice->user->id);



                $User->paid =2;

                $User->update(); 
                
                $t_mail =$user->email;

                $agent_name = $user->person_name;
                 Mail::send('emails.makepayment',compact('t_mail','agent_name'), function ($message) use ($t_mail) {
                  $message->to($t_mail);
                  $message->subject('Make payment');
                });
                
               $t_mail = 'customer@zairaa.net';
        
                $agent_name ='Admin';   

                 Mail::send('emails.makepayment',compact('t_mail','agent_name'), function ($message) use ($t_mail) {
                  $message->to($t_mail);
                  $message->subject('Make payment');
                });
                

                Auth::login($User);

                return view('subscriber.invoice_success',compact('invoice'));
                //session()->flash('success', 'Profile Update successfully !');
                //return redirect('agent/dashboard');
                
            }
            else {

                $invoiceId = $request->input('ppmpf_5');
              
                $invoice = Invoice::findOrFail($invoiceId);




                $User = User::findOrFail($invoice->user->id);


                Auth::login($User);

                
                
                $error =$request -> pp_ResponseMessage;
                
                return view('subscriber.invoice_error',compact('invoice','error','invoiceId'));
     
                //return redirect('invoice/'.$invoiceId);
                
            }


        }else{
            return redirect('agent/dashboard');
        }

       
        

    }


    

    /**
    * Accept attahcment.
    *
    * @return \Illuminate\Http\Response
    */

    public function acceptAttachment($id)
    {


        $invoice = Invoice::findOrFail($id);

        $invoice->status = 1;

        $invoice->update();

        $user = User::findOrFail($invoice->user->id);

        $t_mail =  $user->email;

        $agent_name = $user->fname;

        $user->paid = 1;

        $user->update();


        Mail::send('emails.makepayment',compact('t_mail','agent_name'), function ($message) use ($t_mail) {
          $message->to($t_mail);

          $message->subject('Make payment');
        
        });
        
        
        $t_mail = 'info@ebazar.com';
        
        $agent_name ='Admin';   
        
        Mail::send('emails.makepayment',compact('t_mail','agent_name'), function ($message) use ($t_mail) {
          $message->to($t_mail);
          $message->subject('Make payment');
        });

        session()->flash('success', 'Invoice updated successfully !');
            
        return redirect('/invoices/list?status=paid');




    }
 

     /**
     * Display a listing of the invoice admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function store_pending_invoices(Request $request){
        $current_membership = StoreMemberShip::where('store_id', auth()->user()->store_id)->first();
        $invoices = StoreInvoice::where('status', 0)->get();
        return view('backend.invoices.store_pending_invoices', compact('invoices', 'current_membership'));
    }
    public function pending_invoices(Request $request){
        $invoices = StoreInvoice::with(['store:id,name', 'membership'])->where('status', 1)->orderBy('expiry_date', 'DESC')->get(); 
        return view('backend.invoices.pending_invoices', compact('invoices'));
    }
    public function invoicesList(Request $request){
        $invoices = StoreInvoice::with(['store:id,name', 'membership'])->orderBy('id', 'DESC')->paginate(15);
        return view('backend.invoices.index', compact('invoices'));
    }


    public function expired_memberships(Request $request){
        $expired_member_ships = StoreMemberShip::with(['store', 'store_invoices' => function($query){
                    $query->orderBy('id', 'DESC');
                }
            ])->whereDate('expiry_date', '<=', date('Y-m-d'))->where('status', 'inactive')->orderBy('id', 'DESC')->get();
        return view('backend.invoices.expired_membership', compact('expired_member_ships'));
    }
    public function membership_listing(Request $request){
        $member_ships = StoreMemberShip::with(['store', 'store_invoices'])->paginate(15);
        return view('backend.invoices.membership_index', compact('member_ships'));
    }

    public function membership_edit($id)
    {
        $membership = StoreMembership::findOrFail($id);
        return view('backend.invoices.membership_edit', compact('membership'));
    }

    public function membership_update(Request $request, $id)
    {
        $request->validate([
            'web_charges'    => ['required', 'string']
        ]);
        $membership_data = $request->except(['_token', '_method']);
        StoreMemberShip::where('id', $id)->update($membership_data);
        
        session()->flash('success', 'Invoice successfully updated!');
        return back();
    }
    



    /**
     * Display  invoice list for each agents  admin.
     *
     * @return \Illuminate\Http\Response
     */
     public function depositeAttachment(Request $request)
    {
       // dd($request->all());
        $data = $request->all();
        $Invoice = Invoice::where(['user_id'=>Auth::id(),'id'=>$request['id']])->first();

        if($request->hasFile('attachment')){
            $user_image = $request->file('attachment');
            $extension = $user_image->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $extension;
            $user_image->move('images/', $fileName);
            $data['attachment']= $fileName;
        }
        else {
            $data['attachment']='';
        }
        
       $status=$Invoice->fill($data)->update();
        
        if($status){
            session()->flash('success', 'bank deposite slip successfully uploaded !');
            return redirect('invoice/');
        }
       else{
           session()->flash('success', 'Try again!');
           return back();
       }

    }

    /**
     * Display  invoice list for each agents  admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function invoicesListAgents($id)
    {
        $status = request('status');
        $inoices = Invoice::where(['user_id'=>$id])->get();
        
        // print_r($inoices);exit();
        return view('superadmin.invoice.index',compact('inoices','status'));
        //
    }

     /**
     * Display Invoice for admin view.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoicedetailAgents($id)
    {

        $inoice = Invoice::findOrFail($id);
         
        return view('superadmin.invoice.view',compact('inoice'));


        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        $invoice = Invoice::findOrFail($id);
        return view('backend.invoices.edit', compact('invoice'));

        //
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
        $request->validate([
            'payment'    => ['required', 'string'],
            // 'payment'    => ['required', 'string'],
            'attachment' => 'image|mimes:jpg,jpeg,png,bmp,gif,svg,webp,pdf,docx|max:2024',  
        ]);
        $invoice_data = $request->except(['_token', '_method']);
        $new_invoice = StoreInvoice::where('id', $id)->update($invoice_data);
        session()->flash('success', 'Invoice successfully updated!');
        return redirect()->route('pending-invoices');
        // may be i use below code next time
        $invoice_data = [];
        if($request->has('attachment')){
            $attachment = $request->file('attachment');
            $extension = $attachment->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $extension;
            $attachment->move('images/store_invoices/', $fileName);
            $invoice_data['attachment'] = $fileName;

            $store_image__ = 'images/stores/'.$request->store_image;
            if(file_exists($file_path) && is_file($file_path)){
                unlink($file_path);
            }
        }
        $invoice_data['store_id'] = $request->store_id;
        $invoice_data['payment'] = $request->payment;
        $invoice_data['months'] = $request->expiry_date;
        $invoice_data['start_date'] = date('Y-m-d', strtotime($request->start_date));
        $invoice_data['expiry_date'] = date('Y-m-d', strtotime("+$request->expiry_date months", strtotime($request->start_date)));
        $new_invoice = StoreInvoice::where('id', $request->invoice_id)->update($invoice_data);
        if($new_invoice){
              $store = StoreModal::with('user')->find($request->store_id, ['id', 'name', 'email']);
            StoreModal::where('id', $request->store_id)->update(['status'=> '1']);
            User::where('store_id', $request->store_id)->update(['status'=> 'active']);
            $store_email = $store->email;
            StoreMemberShip::where('id', $request->member_ship_id)->update(['expiry_date' => $invoice_data['expiry_date'], 'status'=> 'active']);
            try {
                Mail::send('email.extend_membership', ['invoice' => $new_invoice, 'store' => $store], function ($message) use ($store_email) {
                    $message->to($store_email);
                    $message->subject('E-bazar Extend Your Membership');
                });
            } catch (\Throwable $th) {
                throw $th;
            }
            session()->flash('success', 'Invoice successfully updated!');
        }else{
            session()->flash('error', 'There is in error occur, pleas try again.');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Invoice = Invoice::findOrFail($id);
        $invoice_file = 'images/store_invoices/' . $Invoice->attachment;
        if (file_exists($invoice_file) && is_file($invoice_file))
            unlink($invoice_file);
        $Invoice->delete();
        session()->flash('success', 'Invoice successfully deleted.');
        return back();
    }
}
