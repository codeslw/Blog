<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function edit($id,$postId){
        $comment = Comment::find($id);
        return redirect()->route('posts')->with(['edit'=>true,'poster'=>$postId, 'comment'=>true,'comid'=>$comment->id]);
    }
    public function delete($id){
        $comment = Comment::find($id);
        $action = new Action();

        $comment->delete();
        $action->description = 'You have deleted comment on post';
        Auth::user()->actIONS()->save($action);
        return redirect()->back()->with('deleted', 'Delleted!!!');
    }
    public function update(Request $request,$id){
        $comment = Comment::find($id);
        $comment->comment = $request->comment_text;
        $comment->save();
        return redirect()->back();

    }
    public function getComment($id){
        $post = Post::find($id);
        return redirect()->route('posts')->with(['comment'=>true,'poster'=>$post->id] );
    }
    public function comment(Action $action,Request  $request,$id){
        $user = Auth::user();
        $post = Post::find($id);
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user_id = $user->id;
        $comment->post_id = $post->id;
        $post->comments()->save($comment);
        $user->comments()->save($comment);
        $action->description = 'You left a comment ('.$comment->comment.') on post with title'.$post->title;
        $user->actions()->save($action);
        return redirect()->route('posts')->with(['comment' => false, 'comment_user'=>$user]);
    }

}
