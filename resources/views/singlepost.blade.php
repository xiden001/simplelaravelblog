@extends('layouts.app')
@section('header')
                <div class="post-heading">
                        <h1>{{ $post->title }}</h1>
                        <h2 class="subheading"></h2>
                        <span class="meta">Posted by <a href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a> on {{ $post->created_at->format('M d,Y \a\t h:i a') }}</span>
                    </div>
@endsection

@section('content')
  @if ($post == null)
    There is post does not exist.
  @else
  
      
      <p class="post-subtitle">
        {!! $post->body !!}
      </p>
    
      
      @if(!$comments->count())
        There are no comments for this post.
      @else
      <h2>Comments</h2>
      @foreach ($comments as $comment)
      <h2 class="post-title">
        <p>{{ $comment->title }}</p>
      </h2>
      <p class="post-subtitle">
        {!! $comment->body !!}
      </p>
      <p class="post-meta">
        {{ $comment->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$comment->from_user)}}">{{ $comment->author->name }}</a>
      </p>
      @endforeach
      @endif

@if(Auth::check())
      <div class="row">
    
    <div class="col-md-12">
    						<div class="widget-area no-padding blank">
								<div class="status-upload">
                <h3>Drop your comments!!</h3>
									 <form class="form-horizontal" role="form" method="POST" action="{{ url('/comment') }}">
                        {{ csrf_field() }}

                     <input type="hidden" name='on_post' value='{{ $post->id }}'>
                    <div class="form-group">
                      <label for="post_content">Comment</label>
										<textarea id="post_content" name= "post_content" class = 'form-control' rows='5' placeholder="What are your thoughts on this?" ></textarea>
										</div>

                    

										<button type="submit" class="btn btn-success green"><i class="fa fa-share"></i>Post Comment</button>
									</form>
								</div><!-- Status Upload  -->
							</div><!-- Widget Area -->
						</div>
        
    </div>
</div>

    @endif
   @endif
@endsection

