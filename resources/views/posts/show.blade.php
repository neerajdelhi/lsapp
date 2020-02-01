@extends('layouts.app')

@section('content')<br>
    <a href="{{ route('index') }}/posts" class="btn btn-default">Go Back</a><br>
    <h1>{{ $post->title }}</h1>
    <p>{!! $post->body !!}</p>
    <p>This Post create at {{ $post->created_at }}</p>

    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <div class="row">
                <div class="col-md-6">
                     <img src="{{asset('storage/cover_image')."/".$post->cover_image }}" width="100%">
                </div>
                <div class="col-md-6"></div>
            </div><br><br>
            <div class="row">
                <div class="col-md-6">
                    <a href="{{route('index')}}/posts/{{$post->id}}/edit" class="btn btn-info">Edit</a>
                </div>
                <div class="col-md-6">
                    <form action="{{action('PostsController@destroy',$post->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure!')" class="btn btn-danger text-right">delete</button>
                    </form>
                </div>
            </div>
        @endif
    @endif
@endsection