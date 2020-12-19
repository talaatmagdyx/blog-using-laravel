@extends('post.layout')
@section('title')
    <h1 class="blog-title">المقالات</h1>
@endsection
@section('content')
    @if(count($posts))
        @foreach ($posts as $post)
        <div class="blog-post">
            <h2 class="blog-post-title"> {{$post->title}}</h2>
            <p class="blog-post-meta"> {{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}} by <a href="#">{{$post->user->name}}</a></p>
            {{$post->excerpt}}
            <a href="posts/{{$post->id}}"> المزيد</a>
        </div><!-- /.blog-post -->
        @endforeach
    @else
        <h1> لا توجد مقالات</h1>
    @endif
        <nav class="blog-pagination">
            <a class="btn btn-outline-primary" href="#">Older</a>
            <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
        </nav>
@endsection
