@extends('layouts.master')
@section('content')
    <div style="margin: 20px">
    <form action="{{route('post.store')}}", method="POST", enctype="multipart/form-data">
        @method('POST')
        @csrf

        <div class="form-group">
            <label for="exampleInputEmail1">Title</label>
            <input type="email" class="form-control" id="exampleInputEmail1" name="title" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">Please Write Title</small>
        </div>
        <div class="form-group">
            <label for="contentID">Content</label>
            <input type="text" class="form-control" name= 'content' id="Content ID">
        </div>
        {{-- <div class="form-group form-check">
             <input type="checkbox" class="form-check-input" id="exampleCheck1">
             <label class="form-check-label" for="exampleCheck1">Check me out</label>
         </div>--}}
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control" id="image" name = 'image'>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
