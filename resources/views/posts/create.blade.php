@extends('layouts.app')

@section('content')<br>
    <h1>Create Posts</h1>
    <form action="{{ action('PostsController@store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" placeholder="title" name="title" class="form-control" value="{{ old('title') }}">
            @if($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea cols="50" rows="5" class="form-control" id="article-ckeditor" placeholder="body text" name="body">{{old('body')}}</textarea>
            @if($errors->has('body'))
                <span class="text-danger">{{ $errors->first('body') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="cover_image">Cover Image</label>
            <input type="file" name="cover_image" id="cover_image">
            @if($errors ->has('cover_image'))
                <span class="text-danger">{{ $errors->first('cover_image') }}</span>
            @endif
        </div>
        <div class="form-group">
            <input type="submit" value="submit" class="btn btn-primary">
        </div>
    </form>
@endsection