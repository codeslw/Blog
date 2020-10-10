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
        .post-details{
            display: flex;
            flex-direction: column;
            justify-content: space-around;

        }
        div{
            padding: 10px;
            height: 90px;
        }
        .actions{
            display: flex;
            flex-direction: column;
        }
        .act{
            border: 1px solid grey;
            padding: 8px;
        }
        h1{
            text-align: center;
        }
    </style>
    <h4>Subscribers {{count($followers)}}</h4>
    <h1>Actions</h1>
    @if($actions)
        <div class="actions">
            @foreach($actions as $action)
                <div class="act">
                    {{$action->description}}
                </div>
            @endforeach
        </div>
    @endif
    <br>
    <br>
    <br>
    <br>
    <h1 style="text-align: center">My Posts</h1>
    @if($posts)
    @foreach($posts as $post)
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
    @else
    <p>No posts yet!</p>
    @endif
@endsection
