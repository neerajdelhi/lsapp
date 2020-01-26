<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;

class PostsController extends Controller
{
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
            'body'  => ['required']
        ]);
    
        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->user()->id;
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
        $editpost->title = $request->title;
        $editpost->body = $request->body;
        $editpost->user_id = auth()->user()->id;

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
        if($post->delete()){
            return redirect('/posts')->with('success','Post Deleted successfully!!');   
        }else{
            return redirect('/posts')->with('error','Error occured while deleting.');
        }
    }
}
