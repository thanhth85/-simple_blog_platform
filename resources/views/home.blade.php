@extends('layouts.app')

@section('title')
{{$title}}
@endsection
@section('content')
@if ( !$posts->count() )
There is no post till now. Login and write a new post now!!!
@else
<div class="">
  @foreach( $posts as $post )
  <div class="list-group">
    <div class="list-group-item">
      <h3><a href="{{ url('/'.$post->slug) }}">{{$post->title}}</a>
        @if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
          @if($post->active == '1')
          <button class="btn" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Post</a></button>
          @else
          <button class="btn" style="float: right"><a href="{{ url('edit/'.$post->slug)}}">Edit Draft</a></button>
          @endif
        @endif
      </h3>
      <p><span>Created at: </span>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></p>
      @if($post->published_at && $post->active == '1')
      <p> <span>Published on:</span> {{ \Carbon\Carbon::parse($post->published_at)->format('M d,Y \a\t h:i a')}}</p>
      @endif
    </div>
    <div class="list-group-item">
      <article>
        {!! Str::limit($post->body, $limit = 1500, $end = '....... <a href='.url("/".$post->slug).'>Read More</a>') !!}
      </article>
    </div>
  </div>
  @endforeach
  {!! $posts->links() !!} 
  Page: {!! $posts->currentPage() !!} / {!! $posts->lastPage() !!}
</div>
@endif
@endsection
