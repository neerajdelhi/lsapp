@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>{{ $title }}</h1>
        <p>lorem ipsum text is too asum with words and descriptions in anywhere in the world.</p>
        <p><a class="btn btn-primary btn-lg" href="/login" role="login">Login</a>
        <a class="btn btn-success btn-lg" href="/register" role="register">Register</a></p>
</div>
@endsection