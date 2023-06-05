<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class WishlistController extends Controller
{
    protected $product=null;
    var $store_id;
    public function __construct(Product $product){
        // dd(!auth()->check());
        
        $this->product=$product;
        $this->store_id = (request()->has('k')) ?  Crypt::decrypt(request()->get('k')) : 0;
    }

    public function wishlist(Request $request){
        if(!auth()->check()):
            // redirect()->back()->with('error','You need to login first');
            return back()->with('error','You need to login first');
        endif;
        // dd($request->all());
        if (empty($request->slug)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }        
        $product = Product::where('slug', $request->slug)->first();
        // return $product;
        if (empty($product)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }

        $already_wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id',null)->where('product_id', $product->id)->first();
        // return $already_wishlist;
        if($already_wishlist) {
            request()->session()->flash('error','Product already placed in wishlist');
            return back();
        }else{
            
            $wishlist = new Wishlist;
            $wishlist->user_id = auth()->user()->id;
            $wishlist->product_id = $product->id;
            $wishlist->price = ($product->price-($product->price*$product->discount)/100);
            $wishlist->quantity = 1;
            $wishlist->amount=$wishlist->price*$wishlist->quantity;
            if ($wishlist->product->stock < $wishlist->quantity || $wishlist->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
            $wishlist->save();
        }
        request()->session()->flash('success','Product successfully added to wishlist');
        return back();       
    }  
    
    public function wishlistDelete(Request $request){
        $wishlist = Wishlist::find($request->id);
        if ($wishlist) {
            $wishlist->delete();
            request()->session()->flash('success','Wishlist successfully removed');
            return back();  
        }
        request()->session()->flash('error','Error please try again');
        return back();       
    }     
}
