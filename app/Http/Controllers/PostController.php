<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use Image;
use Storage;
use App\Post;
use App\Comment;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::orderBy('id', 'desc')->paginate(3);
        return view('home.post.index')->withPost($post);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $messages = [
            
        ];
        $validator = Validator::make($request->all(), [
            'title'    => 'required|max:255',
            'featured_image' => 'image'
        ], $messages);

        if ($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        } 
        else 
        {
            $post = new Post;
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            //print($request->file('featured_image')->getClientOriginalName());
            if($request->hasFile('featured_image'))
            {
                $img = $request->file('featured_image');
                $filename = time(). '.' . $img->getClientOriginalExtension();
                //$filename = $img->getClientOriginalName();
                $location = public_path('images/'. $filename);
                Image::make($img)->save($location);
                $post->image = $filename;
                print($request->file('featured_image')->getClientOriginalName());
            }
            if(Auth::check())
            {
                $post->author_id = Auth::user()->id;
            }

            $post->save();
            return redirect()->route('post.index');
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
        $comments = Comment::where('post_id','like', '%'.$id.'%')->get();
        return view('home.post.show')->withPost($post)->withComments($comments);
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
        return view('home.post.edit')->withPost($post);
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
        $messages = [
            
        ];
        $validator = Validator::make($request->all(), [
            'title'    => 'required|max:255',
            'featured_image' => 'image'
        ], $messages);

        if ($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        } 
        else 
        {
            $post = Post::find($id);
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            //print($request->file('featured_image')->getClientOriginalName());
            if($request->hasFile('featured_image'))
            {
                $img = $request->file('featured_image');
                $filename = time(). '.' . $img->getClientOriginalExtension();
                //$filename = $img->getClientOriginalName();
                $location = public_path('images/'. $filename);
                Image::make($img)->save($location);

                $oldFile = $post['image'];
                Storage::delete($oldFile);
                unlink(public_path('images/'.$oldFile));
                
                $post->image = $filename;
            }
            $post->save();
            return redirect()->route('post.index');
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
        $oldFile = $post['image'];
        Storage::delete($oldFile);
        unlink(public_path('images/'.$oldFile));
        //print($oldFile);
        $post->delete();

        Session::flash('success', 'This post was successfully deleted !');
        return redirect()->route('post.index');
    }
}
