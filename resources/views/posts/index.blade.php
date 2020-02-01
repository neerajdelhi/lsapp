@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img width="100%" src="{{asset('storage/cover_image')."/".$post->cover_image }}">
                        </div>
                        <div class="col-md-8">
                            <div class="card-title">
                            <h3><a href="{{ route('index') }}/posts/{{ $post->id }}">{{ $post->title }}</a></h3>
                            </div>
                            <div class="card-text">
                            <p>{!!$post->body!!}</p>
                                <small>{{ $post->created_at  }} By {{ $post->user->name }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <br>
        @endforeach
        {{$posts->links()}}
        @else
            <p>No posts found</p>
    @endif
@endsection