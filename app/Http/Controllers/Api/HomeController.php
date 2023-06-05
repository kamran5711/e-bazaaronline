<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Traits\SendResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    use SendResponseTrait;
    public function index(Request $request)
    {
        try{
            $data['category'] = Category::with('sub_category')->get();
            $data['banner'] = Banner::select('*',DB::raw('CONCAT("'.asset('products/images/banners').'/",photo) as photo'))->where('status','active')->get();
            $data['product'] = Product::select('*',DB::raw('CONCAT("'.asset('products/images/products').'/",photo) as photo'))->with('store')->where('stock','>',0)->limit(10)->get();
            return $this->SendResponse(true, 'success', $data);
        } catch(\Exception $e){
            return $this->SendResponse(false,$e->getMessage(), []);
        }
    }

    public function search(Request $request)
    {
        try {
            $data['brands'] = Brand::where('status','active')->get();
            $data['size'] = Size::get();
            $products = Product::query();
            if($request->has('search')):
                $products->where('title', 'like', '%'.$request->search.'%');
            endif;

            if($request->has('category_id')):
                $products->where('cat_id', $request->category_id);
            endif;

            if($request->has('size_id')):
                $products->where('size_option', $request->category_id);
            endif;

            if($request->has('choice_id')):
                $products->where('choice_option', $request->category_id);
            endif;
            if($request->has('price_range')):
                $price_range = explode('-', $request->price_range);
                $products->whereBetween('selling_gross', $price_range);
            endif;
            
            $data['product'] = $products->where('stock','>',0)->paginate(5);
            return $this->SendResponse(true, 'search', $data);
        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }


    public function detail(Request $request)
    {
        // return auth('sanctum')->check(); exit;
        try {
           $product_details = Product::with('store')
                ->with('size','choice','rel_prods','getReview');
            if(auth('sanctum')->check()):
                $product_details->with(['wishlist' => function($query) {
                    $query->where('user_id', auth('sanctum')->id());
                }]);
            endif;
            $product_details = $product_details->find($request->product_id);
                $data['product'] = $product_details;
            return $this->SendResponse(true, 'product_details', $data);
        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }

    public function add_to_cart(Request $request)
    {
        try {
            if(!auth('sanctum')->check()):
                return response(['success' => false,'message' => 'please login to procceed','status' => 401],401);
            endif;
            if (empty($request->product_id)) {
                request()->session()->flash('error','Invalid Products');
                return back();
            }        

                $productInfo = Product::find($request->product_id);
                $cartData = [
                    'product_id' => $request->product_id,
                    'size_id' => $request->size_id,
                    'choice_id' => $request->choice_id,
                    'quantity' => $request->qty,
                    'price'    => $productInfo->selling_gross,
                    'amount'    => $productInfo->selling_gross * $request->qty,
                    'user_id' => auth('sanctum')->user()->id,
                    'status' => 'new',
                    'store_id' => $request->store_id,

                ];
                $checkdata = [
                    'product_id' => $request->product_id,
                ];
                $check = Cart::where($checkdata);
                if((int) $request->qty == 0):
                    $check->delete();
                    return $this->SendResponse(true, 'Successfully removed from cart', []);
                endif;
                if($check->first()):
                    $cartData['quantity'] = $check->first()->quantity + $request->qty;
                    $cartData['amount'] = $check->first()->amount + ($productInfo->selling_gross * $cartData['quantity']);
                    // return $cartData;
                    $check->update($cartData);
                else:
                    Cart::create($cartData);
                endif;
               
            return $this->SendResponse(true, 'Successfully added to cart', []);


        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }

    public function cart_index()
    {
        try {
            if(!auth('sanctum')->check()):
                return response(['success' => false,'message' => 'please login to procceed','status' => 401],401);
            endif;
            $data['cart'] = Cart::with(['product' => function($q){
                $q->select('id','title',DB::raw('CONCAT("'.asset('products/images/products/').'",photo) as photo'),'selling_gross');
                
            }])
            ->with('choice','size')
            ->where('user_id',auth('sanctum')->user()->id)
                ->get();
            return $this->SendResponse(true, 'cart_index', $data);
        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }

    ///// favourite section start /////

    public function add_to_wishlist()
    {
        try {
            if(!auth('sanctum')->check()):
                return response(['success' => false,'message' => 'please login to procceed','status' => 401],401);
            endif;
            $price = Product::find(request()->product_id)->selling_gross;
            $data['product_id'] = request()->product_id;
            $data['user_id'] = auth('sanctum')->user()->id;
            $data['price'] = $price;
            $data['quantity'] = request()->qty;
            $data['amount'] = $price * request()->qty;
            $check = Wishlist::where(['product_id' => $data['product_id'],'user_id' => $data['user_id']]);
            if($check->first()):
                $check->delete();
                return $this->SendResponse(true, 'Successfully removed from wishlist', []);
            else:
                Wishlist::create($data);
                return $this->SendResponse(true, 'Successfully added to wishlist', []);
            endif;
        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    } 

    public function wishlist()
    {
        try {
            if(!auth('sanctum')->check()):
                return response(['success' => false,'message' => 'please login to procceed','status' => 401],401);
            endif;
            $data['wishlist'] = Wishlist::with(['product' => function($q){
                $q->select('id','title',DB::raw('CONCAT("'.asset('products/images/products/').'",photo) as photo'),'selling_gross');
                $q->with([
                    'choice',
                    'size'
                ]);
            }])
            ->where('user_id',auth('sanctum')->user()->id)
                ->get();
            return $this->SendResponse(true, 'wishlist', $data);
        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }

    public function update_wishlist()
    {
        try {
            if(!auth('sanctum')->check()):
                return response(['success' => false,'message' => 'please login to procceed','status' => 401],401);
            endif;
            $check = Wishlist::where(['product_id' => request()->product_id,'user_id' => auth('sanctum')->user()->id]);
            if($check->first()):
                $data['quantity'] = request()->qty;
                $data['amount'] = request()->qty * $check->first()->price;
                $data['price'] = $check->first()->price;
                $data['product_id'] = request()->product_id;
                $data['user_id'] = auth('sanctum')->user()->id;
                $check->update($data);
                return $this->SendResponse(true, 'Successfully updated', []);
            else:
                return $this->SendResponse(false, 'Product not found', []);
            endif;
        } catch (\Exception $e) {
            return $this->SendResponse(false, $e->getMessage(), []);
        }
    }
}
