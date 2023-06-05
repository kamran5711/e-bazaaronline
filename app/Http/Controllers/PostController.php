<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\PostTagTags;
use App\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('category', 'post_tags')->where('store_id', auth()->user()->store_id)->paginate(10);
        return view('backend.post.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PostCategory::where('store_id', auth()->user()->store_id)->get();
        $tags = PostTag::where('store_id', auth()->user()->store_id)->get();
        return view('backend.post.create')->with('categories',$categories)->with('tags',$tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'title'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'nullable',
            'tags'=>'nullable',
            'category_id'=>'required',
            'status'=>'required|in:active,inactive'
        ]);

        $data = [];
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['category_id'] = $request->category_id;
        $tags = $request->tags;

        
        if($request->has('photo')):
            $user_image = $request->file('photo');
            $extension = $user_image->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $extension;
            $user_image->move('images/posts', $fileName);
            $data['photo']= $fileName;
        endif;

        $slug = Str::slug($request->title." ".auth()->user()->store_id);
        $count = Post::where('slug',$slug)->count();
        if($count>0){
            $slug = $slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug'] = $slug;
        $data['store_id'] = auth()->user()->store_id;
        $post = Post::create($data);
        foreach ($tags as $tag) {
            PostTagTags::create([
                'post_id' => $post->id,
                'post_tag_id' => $tag
            ]);
        }
        if($post){
            request()->session()->flash('success','Post Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('post.index');
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
        $post = Post::findOrFail($id);
        $categories = PostCategory::get();
        $tags = PostTag::get();
        return view('backend.post.edit')->with('categories',$categories)->with('tags',$tags)->with('post',$post);
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
        
        $post = Post::with('post_tags')->findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required',
            'description'=>'string|nullable',
            //'photo'=>'string|nullable',
            'tags'=>'required',
            'category_id'=>'required',
            'status'=>'required|in:active,inactive'
        ]);

        $data = [];
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['category_id'] = $request->category_id;
        $data['status'] = $request->status;
        $tags = $request->tags;



        if($request->hasFile('photo')){
            $user_image = $request->file('photo');
            $extension = $user_image->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $extension;
            $user_image->move('images/posts', $fileName);
            $data['photo']= $fileName;
        }

        $status = $post->fill($data)->update();
        $tags_arr = [];
        
        $tags_ids = $post->post_tags()->pluck('post_tag_id')->toArray();
        foreach($tags_ids as $tag_id){
            if (!in_array($tag_id, $tags)){
                PostTagTags::where(['post_id' => $post->id, 'post_tag_id'=> $tag_id])->delete();
            }
        }
        foreach($tags as $tag){
            if (!in_array($tag, $tags_ids ?? [] )){
                PostTagTags::create(['post_id' => $post->id, 'post_tag_id'=> $tag]);
            }
        }
        if($status){
            request()->session()->flash('success','Post Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
       
        $status = $post->delete();
        
        if($status){
            request()->session()->flash('success','Post successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting post ');
        }
        return redirect()->route('post.index');
    }
}
