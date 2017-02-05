<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Posts;
use App\User;
use Redirect;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Load all posts for front page in groups of 10

        //fetch 5 posts from database which are active and latest
        $posts = Posts::where('active',1)->orderBy('created_at', 'desc')->paginate(2);
        // page Heading
        $title = 'Latest Posts';
        // return to our view (home.blade.php)
        return view('home')->withPosts($posts)->withTitle($title); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //not needed form already created
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
                //Save a new post

         $input['author_id'] = $request->user()->id;
       
        $input['title'] = $request->input('title');
        $input['description'] ='';
        $input['slug'] = $request->input('post_slug');

        $input['active'] = true;
        $input['images'] = '';

        $input['body'] = nl2br($request->input('post_content'));
        $slug = $request->input('slug');


        Posts::create( $input );
        return redirect('/')->with('message', 'Post published');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //
        $post = Posts::where('slug',$slug)->first();
      if (!$post) {
        return redirect('/')->withErrors('requested page not found');
      }
      $comments = $post->comments;
      return view('singlepost')->withPost($post)->withComments($comments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        //find the post that needs to be updated

        $post = Posts::find($id);

        $post->title = $request->input("title");
        $post->body = nl2br($request->input("post_content"));
        $post->slug = $request->input("post_slug");

        $post->save();
        return redirect('/')->with('message', 'Post edited');
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
         $post = Posts::find($id);
         if($post->author_id == Auth::id() || Auth::user()->role == 'admin'){

             $post->delete();
             return redirect('/')->with('message', 'not deleted');
         }
        return redirect('/')->with('message', 'not deleted');
    }
}
