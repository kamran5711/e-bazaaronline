<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Faq;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class PagesSettingsController extends Controller
{
    public function about_us()
    {
        $record = Page::where('user_id', auth()->user()->id)->where('type','1')->first();
        return view('backend.pages.about_us',compact('record'));
    }

    public function save_about_us(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $data = [
            'title' => trim($request->title),
            'content' => $request->content,
            'user_id' => auth()->user()->id,
        ];

        Page::updateOrCreate(['type' => '1','user_id' => auth()->user()->id],$data);
        return back()->with('success','About Us Page Updated Successfully');
    }

    public function social_links()
    {
        $record = SocialLink::where('store_id', auth()->user()->store_id)->first();
        return view('backend.pages.social_links',compact('record'));
    }

    public function save_social_links(Request $request)
    {
        $request->validate([
            'facebook_name' => 'required',
            'facebook_link' => 'required',
            'twitter_name' => 'required',
            'twitter_link' => 'required',
            'instagram_name' => 'required',
            'instagram_link' => 'required',

        ]);

        $data = [
            'store_id' => auth()->user()->store_id,
            'facebook_name' => trim($request->facebook_name),
            'facebook_link' => trim($request->facebook_link),
            'twitter_name' => trim($request->twitter_name),
            'twitter_link' => trim($request->twitter_link),
            'instagram_name' => trim($request->instagram_name),
            'instagram_link' => trim($request->instagram_link)
        ];

        SocialLink::updateOrCreate(['store_id' => auth()->user()->id], $data);
        return back()->with('success','Social media links successfully saved.');
    }

    public function payment_methods()
    {
        $record = Page::where('user_id',auth()->user()->id)->where('type','4')->first();
        return view('backend.pages.payment_methods',compact('record'));
    }

    public function save_payment_methods(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $data = [
            'title' => trim($request->title),
            'content' => $request->content,
            'user_id' => auth()->user()->id,
        ];

        Page::updateOrCreate(['type' => '4','user_id' => auth()->user()->id],$data);
        return back()->with('success','Payment methods Page Updated Successfully');
    }

    public function money_back()
    {
        $record = Page::where('user_id',auth()->user()->id)->where('type','5')->first();
        return view('backend.pages.money_back',compact('record'));
    }

    public function save_money_back(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $data = [
            'title' => trim($request->title),
            'content' => $request->content,
            'user_id' => auth()->user()->id,
        ];

        Page::updateOrCreate(['type' => '5','user_id' => auth()->user()->id],$data);
        return back()->with('success','Money Back Page Updated Successfully');
    }

    public function returns()
    {
        $record = Page::where('user_id',auth()->user()->id)->where('type','6')->first();
        return view('backend.pages.returns_',compact('record'));
    }

    public function save_returns(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $data = [
            'title' => trim($request->title),
            'content' => $request->content,
            'user_id' => auth()->user()->id,
        ];

        Page::updateOrCreate(['type' => '6','user_id' => auth()->user()->id],$data);
        return back()->with('success','Returns Page Updated Successfully');
    }


    public function shipping()
    {
        $record = Page::where('user_id',auth()->user()->id)->where('type','7')->first();
        return view('backend.pages.shipping',compact('record'));
    }

    public function save_shipping(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $data = [
            'title' => trim($request->title),
            'content' => $request->content,
            'user_id' => auth()->user()->id,
        ];

        Page::updateOrCreate(['type' => '7','user_id' => auth()->user()->id],$data);
        return back()->with('success','Shipping Page Updated Successfully.');
    }


    public function terms()
    {
        $record = Page::where('user_id',auth()->user()->id)->where('type','2')->first();
        return view('backend.pages.terms',compact('record'));
    }

    public function save_terms(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $data = [
            'title' => trim($request->title),
            'content' => $request->content,
            'user_id' => auth()->user()->id,
        ];

        Page::updateOrCreate(['type' => '2','user_id' => auth()->user()->id],$data);
        return back()->with('success','Terms & Conditions Page Updated Successfully');
    }

    public function privacy_policy()
    {
        $record = Page::where('user_id',auth()->user()->id)->where('type','3')->first();
        
        return view('backend.pages.privacy_policy',compact('record')); 
    }

    public function save_privacy_policy(Request $request){
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $data = [
            'title' => trim($request->title),
            'content' => $request->content,
            'user_id' => auth()->user()->id,
        ];

        Page::updateOrCreate(['type' => '3','user_id' => auth()->user()->id],$data);
        return back()->with('success','Privacy Policy Page Updated Successfully');
    }


    public function faqs(){
        $faqs = Faq::where('user_id',auth()->user()->id)->paginate(15);
        return view('backend.faqs.index', compact('faqs'));
    }

    public function faq_create(){
        return view('backend.faqs.create');
    }

    public function faq_store(Request $request)
    {
        $this->validate($request,[
            'question'=>'string|required',
            'answer'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        $status = Faq::create($data);
        if($status){
            request()->session()->flash('success','FAQS successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred while adding FAQS');
        }
        return redirect()->route('faq.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function faq_edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('backend.faqs.edit')->with('faq',$faq);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function faq_update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $this->validate($request,[
            'question'=>'string|required',
            'answer'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        $status = $faq->fill($data)->save();
        if($status){
            request()->session()->flash('success','FAQS successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating FAQS');
        }
        return redirect()->route('faq.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function faq_destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $status= $faq->delete();
        if($status){
            request()->session()->flash('success','FAQS successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting FAQS');
        }
        return redirect()->route('faq.index');
    }

}
