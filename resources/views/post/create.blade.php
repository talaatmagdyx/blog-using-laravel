@extends('post.layout')
@section('title')
    <h1 class="blog-title">مقالة جديدة</h1>
@endsection

@section('content')
    <form method="POST" action="{{$action}}">
        {{@csrf_field()}}
        <input type="hidden" name="user_id" value="{{\Illuminate\Support\Facades\Auth::id()}}">
        @if($method == 'put')
            {{method_field('PUT')}}
        @endif

        @if(count($errors))
            <dev class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </dev>
        @endif
        <div class="form-group">
            <label for="title-id">العنوان</label>
            <input type="text" class="form-control" id="title-id" name="title" value="{{old('title', isset($post)?$post->title:null)}}">
        </div>
        <div class="form-group">
            <label for="body-id">نص المقالة</label>
            <textarea class="form-control" id="body-id" name="body" rows="10">{{old('body', isset($post)?$post->body:null)}}</textarea>
        </div>
        <div class="form-group">
            <label for="excerpt-id">المقتطف</label>
            <textarea class="form-control" id="excerpt-id" name="excerpt" rows="2">{{old('excerpt', isset($post)?$post->excerpt:null)}}</textarea>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" name="is_published" class="form-check-input">
                نشر المقالة
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
