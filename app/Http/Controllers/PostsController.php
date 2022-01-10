<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PostsController extends Controller
{
    // we have a problem right now:
    // we check for auth to access some pages BUT we can still access it if we already know the path to those pages
    // we could simply write it down the URL and it's done so:
    public function __construct()
    {
        // the inner array contains the methods that a user can access if they're not logged in
        $this->middleware('auth', ['except' => ['index', 'show']]);
        // so from now if we try to access '/blog/create' without being logged in for example
        // we'll be redirected to the login page
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('blog.index')
            ->with('posts', Post::orderBy('updated_at', 'DESC')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            // max is the max size
            'image' => 'required|mimes:jpg,png,jpeg,webp|max:5048'
        ]);

        // createSlug takes 3 params: 
        // the model, 
        // the table column where you have to push the slug
        // the title since we want to turn it into a a slug
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        // let's create a new name for our image to store it on the server
        $newImageName = uniqid() . '-' . $slug . '.' . $request->image->extension();
        // move the image into the /public/images directory (create it if needed)
        // and name the file with $newImageName value
        $request->image->move(public_path('images'), $newImageName);

        Post::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'slug' => $slug,
            'image_path' => $newImageName,
            'user_id' => auth()->user()->id
        ]);

        // we want to go back to /blog when post is ok
        // with a message to confirm it's done to the user
        return redirect('/blog')->with('message', 'Your post has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // we want to pass one post to the view
        // get it from the Post model
        // where the slug field would be the slug in the URI
        // (so $slug comes from the URI)
        // we need to say that we need the first port that match
        return view('blog.show')->with('post', Post::where('slug', $slug)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        return view('blog.edit')->with('post', Post::where('slug', $slug)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        Post::where('slug', $slug)->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'slug' => $slug,
            'user_id' => auth()->user()->id
        ]);
        return redirect('/blog')->with('message', 'Your post has been upated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $post = Post::where('slug', $slug);
        $post->delete();
        return redirect('/blog')->with('message', 'Your post has been deleted');
    }
}

// N.B.:
/*
Create:
we need to call the create method to show it (GET)
and the store method to post it (POST)
-> /blog/create

Read:
-> /blog/index
but index won't be visible
-> /blog

Update:
-> /blog/update?
nope we need to tell the app what we need to update
-> /blog/{slug} -> PUT or PATCH

Delete:
-> /blog/{id} -> DELETE

Show:
-> /blog/{id} -> GET

Edit:
-> /blog/{id}/edit -> GET
 */
