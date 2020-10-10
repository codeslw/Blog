<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('welcome', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $action = new Action();
        request()->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required'
        ]);
        $post = new Post([
            'title' => $request->title,
            'content' => $request->input('content'),
        ]);
        $fileName = $request->image->getClientOriginalName();
        $request->image->storeAs('images', $fileName, 'public');
        $post->image = $fileName;
        $action->description = 'You stored the post with title' . $post->title . '';
        $user->actions()->save($action);
        $user->posts()->save($post);
        return redirect()->route('post.create');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.post', ['posts', $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $response = Gate::inspect('update-post', $post);
        if ($response->allowed()) {
            return view('posts.edit')->with(['post' => $post,]);
        } elseif (!Auth::check()) {
            return redirect()->route('login');

        } else {
            return redirect()->route('posts')->with('message', $response->message());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required'
        ]);
        $user = Auth::user();
        $action = new Action();
        $post->title = $request->title;
        $post->content = $request->content;
        $fileName = $request->image->getClientOriginalName();
        $request->image->storeAs('images', $fileName, 'public');
        $post->image = $fileName;
        $action->description = 'You have updated the post with title' . $post->title . '';
        $user->actions()->save($action);
        $post->save();
        return redirect()->route('posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $user = Auth::user();
        $action = new Action();

        if (Gate::allows('delete-post', $post)) {
            $post->delete();
            $action->description = 'User dleteted the post with title' . $post->title . '';
            $user->actions()->save($action);
            return redirect()->route('posts');
        }
        return redirect()->back()->with('message', 'You Are not Allowed to delete this post');
    }


    public function like($id)
    {

        $user = Auth::user();
        $post = Post::find($id);
        $like = new Like();
        $action = new Action();
        $liked = Like::where('user_id', '' . $user->id . '')->where('post_id', '' . $id . '')->first();
        if (!$liked) {
            $like->user_id = $user->id;
            $like->post_id = $post->id;
            $post->likes()->save($like);
            $user->likes()->save($like);
            $action->description = 'User liked the post with title' . $post->title . '';
            $user->actions()->save($action);
            return redirect()->route('posts');
        } else {
            return redirect()->route('posts')->with('message', 'YOU CAN LIKE ONE POST ONLY ONCE!');
        }
    }

    public function dislike($id)
    {
        $user = Auth::user();
        $post = Post::find($id);
        $action = new Action();
        foreach ($user->likes as $like) {
            foreach ($post->likes as $plike) {
                if ($like->id === $plike->id) {
                    $like = Like::where('user_id', '' . $user->id . '')->where('post_id', '' . $post->id . '')->first();
                    $like->delete();
                    $action->description = 'You disliked the post with title' . $post->title . '';
                    $user->actions()->save($action);
                    return redirect()->route('posts');

                }
            }

            //Could use just $id but to make it more clear decided to go with long way
            return redirect()->route('posts')->with('message', 'You can not dislike');

        }
    }
}
