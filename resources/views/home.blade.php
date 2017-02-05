@extends('layouts.app')
@section('header')
  <div class="site-heading">
    <h1>Samuel Adoga's Blog</h1>
    <hr class="small">
    <span class="subheading">Simple Blog for techies to share and learn <br>
      Register today and have fun :) :)
    </span>
  </div>
@endsection

@if(Auth::check())
@section('postbox')



<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Write Post</button>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Write Post</h4>
      </div>
      <div class="modal-body">
        <div class="row">
    
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
    						<div class="widget-area no-padding blank">
								<div class="status-upload" id="sharepost">
                <h3>Share your thoughts!!</h3>
									 <form class="form-horizontal" role="form" id="shareform" method="POST" action="{{ url('/posts') }}">
                        {{ csrf_field() }}

                     <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" onkeyup="postslug(this.value,'post_slug')">
                    </div>   

                    <div class="form-group">
                      <label for="post_content">Body</label>
										<textarea id="post_content" name= "post_content" class = 'form-control' rows='5' placeholder="What are you doing right now?" ></textarea>
										</div>

                    <div class="form-group">
                      <label for="post_slug">Slug</label>
                      <input type="text" class="form-control" id="post_slug" name="post_slug" readonly/>
                      </div>

										<button type="submit" class="btn btn-success green"><i class="fa fa-share"></i> Share</button>
									</form>
								</div><!-- Status Upload  -->
							</div><!-- Widget Area -->
						</div>
        
    </div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- edit Modal -->
<div id="myModaledit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Post</h4>
      </div>
      <div class="modal-body">
           <div class="row">
    
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
    						<div class="widget-area no-padding blank">
								<div class="status-upload" id="sharepost">
                <h3>Share your thoughts!!</h3>
									 <form class="form-horizontal" role="form" id="editform" method="POST" action="{{ url('/posts') }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                     <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" id="edit_title" name="title" placeholder="Enter title" onkeyup="postslug(this.value,'edit_post_slug')">
                    </div>   

                    <div class="form-group">
                      <label for="post_content">Body</label>
										<textarea id="edit_post_content" name= "post_content" class = 'form-control' rows='5' placeholder="What are you doing right now?" ></textarea>
										</div>

                    <div class="form-group">
                      <label for="post_slug">Slug</label>
                      <input type="text" class="form-control" id="edit_post_slug" name="post_slug" readonly/>
                      </div>

										<button type="submit" class="btn btn-success green"><i class="fa fa-share"></i> Update</button>
									</form>
								</div><!-- Status Upload  -->
							</div><!-- Widget Area -->
						</div>
        
    </div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection
@endif

@section('content')

  @if (!$posts->count())
    There are no posts to display. Login and write a new post now!!!
  @else
  <h3>{{ $title }}</h3>
  @foreach ($posts as $post)
      <h2 class="post-title">
        <a href="{{ url('/posts/'.$post->slug) }}">{{ $post->title }}</a>
       
       @if(Auth::check())
         @if(Auth::id() == $post->author_id)
        
        <form class="form-horizontal" method="POST" action="{{  url('/posts/'.$post->id )}}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <a data-toggle="modal" data-target="#myModaledit"  onclick="loadEdit({{$post}})" class='btn btn-primary'>Edit</a>
        

        <button type="submit" class='btn btn-danger'>Delete</button>

        </form>
        
          @elseif(Auth::user()->role === 'admin')
          <form method="POST" action="{{url('/posts/'.$post->id)}}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <button type="submit" class='btn btn-danger'>Delete</button>

        </form>
          @endif

          @endif
      </h2>
      <p class="post-subtitle">
        {!! str_limit($post->body, $limit= 120, $end = '....... <a href='.url("/posts/".$post->slug).'>Read More</a>') !!}
      </p>
      <p class="post-meta">
        {{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a>
      </p>
  @endforeach
  @endif
@endsection
@section('pagination')
<div class="row">
  <hr>
  {!! $posts->links() !!}
</div>
@endsection
