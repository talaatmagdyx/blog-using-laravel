@extends('post.layout')
@section('title')
    <h1 class="blog-title">مقالة {{$post->title}}</h1>
@endsection
@section('content')
    <a href="{{route('posts.edit', $post->id)}}">تعديل المقالة</a>
<div class="blog-post">
    <h2 class="blog-post-title"> {{$post->title}}</h2>
    {{$post->body}}
</div><!-- /.blog-post -->
<nav class="blog-pagination">
    <a class="btn btn-outline-primary" href="#">Older</a>
    <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
</nav>

@endsection
