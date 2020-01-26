@extends('layouts.app')

@section('content')<br>
    <a href="{{ route('index') }}/posts" class="btn btn-default">Go Back</a><br>
    <h1>{{ $post->title }}</h1>
    <p>{!! $post->body !!}</p>
    <p>This Post create at {{ $post->created_at }}</p>

    <div class="row">
        <div class="col-md-6">
            <a href="{{route('index')}}/posts/{{$post->id}}/edit" class="btn btn-info">Edit</a>
        </div>
        <div class="col-md-6">
            <form action="{{action('PostsController@destroy',$post->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure!')" class="btn btn-danger pull-right">delete</button>
            </form>
        </div>
    </div>
@endsection