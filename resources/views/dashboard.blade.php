@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{ action('PostsController@create') }}" class="btn btn-info m-3">Create Posts</a>
                    <h3>Your Blog Posts</h3>
                    
                    @if(count($posts) > 0)
                        <table class="table table-stripe">
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach ($posts as $post )
                            <tr>
                                <th>{{$post->title}}</th>
                                <th><a href="{{ action('PostsController@edit',$post->id) }}" class="btn btn-warning">Edit</a></th>
                                <th>
                                    <form action="{{action('PostsController@destroy',$post->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure!')" class="btn btn-danger pull-right">delete</button>
                                    </form>
                                </th>
                            </tr>
                            @endforeach
                        </table>
                    @else
                        <p>You have no posts.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
