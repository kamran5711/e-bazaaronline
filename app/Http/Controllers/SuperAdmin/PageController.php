<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use App\Search;
class PageController extends Controller
{
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.posts.create');

        //
    }
    
      public function about_us()
    { 
        
        
        return view('about_us' );
    }
    
    
     public function terms_and_conditions()
    { 
        
        
        return view('terms_and_conditions' );
    }

    public function home(Request  $request)
    {
      if ($request->search!=null){
          $userData = User::get();

    $searchdata=DB::table('categories')->where('categories.name','LIKE', '%'.$request->search.'%')->first();
    if($searchdata){
    Search::where('category_id',$searchdata->id)->delete();
     $searchData=['category_id'=>$searchdata->id];
     Search::create($searchData);
    }
    $companies=DB::table('users')
    ->leftjoin('categories', 'users.category_id','=','categories.id')
    ->where('categories.name','LIKE', '%'.$request->search.'%')
    ->where('role_id',3)->paginate(10);

    $searchcompany=Search::pluck('category_id')->toArray();
    $categories=DB::table('categories')->whereIn('id',$searchcompany)-> orderBy('id','desc')->paginate(8);
    $search=$request->search;
          return view('store_searched' , compact('companies','userData','search','categories'));
      }
      else{
          $companies = User::whereHas('role', function ($q) {
            $q->whereName('Subscriber')->where('is_active',1);
      })->get();
      $searchcompany=Search::pluck('category_id')->toArray();
      $categories=DB::table('categories')->whereIn('id',$searchcompany)-> orderBy('id','desc')->paginate(8);
          return view('welcome' , compact('companies','categories'));
      }
    }
    public function searchAll($id)
    { 
        $searchShops=User::where('category_id',$id)->orderBy('id','desc')->paginate(8);
        
        return view('searchShops',compact('searchShops'));
    }
    
     public function privacy_policy()
    { 
        return view('privacy_policy' );
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

        return view('admin.posts.edit');

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
