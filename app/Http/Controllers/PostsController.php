<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=> ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::orderBy('title','desc')->take(1)->get();
        //$posts = DB::select('SELECT * from posts');
        $posts = Post::orderBy('created_at','desc')->paginate(3);
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return $request->all();
        $validateData = $request->validate([
            'title' => ['required','max:60','regex:/(^[a-zA-Z ]+$)/i'],
            'body'  => ['required'],
            'cover_image' => ['image','nullable','max:1999']
        ]);
        if($request->hasFile('cover_image')){
            $fileNameWthExt = $request->file('cover_image')->getClientOriginalName();
            $fileExt = $request->file('cover_image')->getClientOriginalExtension();
            $filename = basename($fileNameWthExt,$fileExt); 
            $fileNameToStore = $filename."_".time().".".$fileExt;
            $path = $request->file('cover_image')->storeAs('public/cover_image',$fileNameToStore);
        }else{
            $fileNameToStore = "no_image.gif";
        }
        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;

        if($post->save()){
            return redirect('/posts')->with('success','Post created');
        }else{
            return redirect('/posts')->with('error','Post not created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //check for correct user
        if(auth()->user()->id !== $post->user_id){
            redirect('/');
        }
        return view('posts.edit',compact('post',$post));
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
        $validateData = $request->validate([
            'title' => ['required','max:60','regex:/(^[a-zA-Z ]+$)/i'],
            'body'  => ['required']
        ]);

        $editpost = Post::find($id);
        
        if($request->hasFile('cover_image')){
            $fileNameWthExt = $request->file('cover_image')->getClientOriginalName();
            $fileExt = $request->file('cover_image')->getClientOriginalExtension();
            $filename = basename($fileNameWthExt,$fileExt);
            $fileNameToStore = $filename."_".time().".".$fileExt;
            Storage::delete('public/cover_image/'.$editpost->cover_image);
            $path = $request->file('cover_image')->storeAs('public/cover_image',$fileNameToStore);
        }else{
            $fileNameToStore = "no_image.gif";
        }
        $editpost->title = $request->title;
        $editpost->body = $request->body;
        $editpost->user_id = auth()->user()->id;
        $editpost->cover_image = $fileNameToStore;

        if($editpost->save()){
            return redirect('/posts')->with('success','Post Editted successfully!!');   
        }else{
            return redirect('/posts')->with('error','Error occured while editing.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

         //check for correct user
         if(auth()->user()->id !== $post->user_id){
            redirect('/');
        }
        if($post->cover_image != 'no_image.gif'){
            //Storage::delete('public/cover_image/'.$editpost->cover_image);
            Storage::delete('public/cover_image/'.$post->cover_image);
        }
        if($post->delete()){
            return redirect('/posts')->with('success','Post Deleted successfully!!');   
        }else{
            return redirect('/posts')->with('error','Error occured while deleting.');
        }
    }
}
