@extends('layouts.master')

@section('content')
    <style>
        img{
            width: 57px;
            height: 57px;
            border-radius: 50%;
        }
        .posts{
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            border: 1px solid silver;
            margin: 10px;

        }
        .sharings{
            display: flex;
            flex-direction: column;
        }
        .subscribe{

        }
        .post-details{
            display: flex;
            flex-direction: column;
            justify-content: space-around;

        }
        div{
            padding: 10px;
            height: 90px;
        }
    </style>
    @if(\Illuminate\Support\Facades\Session::has('message'))
        <div class="alert alert-danger" role="alert">
            {{\Illuminate\Support\Facades\Session::get('message')}}
        </div>
    @endif

    <div class="user-details">
        <div class="avatar">
            <img src="" alt="">

        </div>
        <div class="subscribers">
            <strong>Subscribers : {{count($user->subscribers)}}</strong>
        </div>
        @foreach($user->subscribers as $subscriber)
        @if($subscriber->id === \Illuminate\Support\Facades\Auth::user()->id)
                <div class="unsubscribe">
                    <form action="{{route('user.unsubscribe',['id'=>$user->id])}}" method="POST">
                        @method('POST')
                        @csrf
                        <button class="btn-danger" type="submit"> Unsubscribe </button>
                    </form>

                </div>
            @endif
        @endforeach
        @if(\Illuminate\Support\Facades\Auth::user()->id !==$user->id)
            @can('subscribe',$user)
        <div class="subscribe">
            <form action="{{route('user.subscribe',['id'=>$user->id])}}" method="POST">
                @method('POST')
                @csrf
                <button class="btn-primary" type="submit"> subscribe </button>
            </form>
        </div>
            @endcan
        @endif
        <div class="data">
            <div class="name">
                <h2>
                Name: {{$user->name}}

                </h2>
            </div>
            <div class="email">
                <p>
                    mail : {{$user->email}}
                </p>
                <br>

            </div>
        </div>

        <h1 style="text-align: center"> POSTS</h1>
        <div class="sharings">
            @foreach($user->posts as $post)
            <div class="posts">
                <div class="post-image">
                    <img src="{{asset('storage/images/'.$post->image.'')}}" alt="">
                </div>

                <div class="post-details">
                    <div class="title">
                        <h6>
                            {{$post->title}}
                        </h6>
                    </div>
                    <div class="content">
                        <p>{{$post->content}}</p>
                    </div>
                </div>
                <div class="likes">
                    <strong>{{count($post->likes)}} likes</strong>
                </div>



            </div>

            @endforeach
        </div>
    </div>
@endsection
