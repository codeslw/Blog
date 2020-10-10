<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Post;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(){
        $actions = Action::all();
        $user = Auth::user();
        $posts = $user->posts;
        $followers = $user->subscribers;
        return  view('users.index',['actions'=>$actions,'user'=>$user,'posts'=>$posts, 'followers'=>$followers]);
    }
    public function show(User $user){
        return view('users.profile',['user'=>$user]);
    }
    public function subscribe(Action $action,$id){
        $user = User::find($id);
        $response = Gate::inspect('subscribe',$user);
        if(Gate::allows('subscribe',$user)){
        $follow = Auth::user();
        $user->subscribers()->attach($follow);
        $action->description = 'You subscribed to '.$user->name.'';
        Auth::user()->actions()->save($action);
        return redirect()->back();
        }
        else
        {
            return redirect()->back()->with('error','You have already subscribed');
        }
    }
    public function unsubscribe(Action $action,$id){
        $user = User::find($id);
        $follow = Auth::user();
        foreach ($user->subscribers as $follower){
            if ($follower->id ===$follow->id){
                $user->subscribers()->detach($follower);
                $action->description = 'You unsubscribed from '.$user->name.'';
                $follow->actions()->save($action);
            }
        }
        return redirect()->back();
    }

}
