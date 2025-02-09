@extends('layouts.app')
@section('page_styles')
<link rel="stylesheet" href="{{ asset('irh_assets/vendor/summernote/summernote-lite.css') }}">
<style type="text/css">
	#single-resource-header
	{
		margin-top: 0%;
	}
	@media screen and (max-width: 767px)
	{
		#single-resource-header
		{
			margin-top: 0;
		}
	}
</style>
@endsection
@section('content')
<header id="single-resource-header" class="">
	<div class="container bg-blue p-5">
		<div class="row">
			<div class="col-md-8 text-left">
				<h3 class="text-white mb-0">{{ ucwords($resource->title) }}</h3>
				<h5 class="text-white mb-0">Author: <a href="{{ route('theme.resources.authorprofile',$resource->user->id) }}" style="color: #fff;">{{ ucwords($resource->user->full_name) }}</a></h5>
				<div class="py-2" style="border-bottom: 1px solid #ffffff85;">
					{!! $resource->commulativeRating($resource->reviews->count()) !!}
					<span class="pl-2">{{ $resource->reviews->count() }} {{ str_plural('Review',$resource->reviews->count()) }}</span>
				</div>
				<div class="py-2">
					<div class="float-left">

						<h5 class="text-white mb-0 mt-2 resource-publish-date">Published on {{ date('d-M-Y',strtotime($resource->created_at)) }}</h5>
					</div>
					<div class="float-right">
						<span class="px-2"><a href="" target="_blank" class="text-white"><i class="fab fa-instagram"></i></a></span>
						<span class="px-2"><a href="https://www.facebook.com/sharer/sharer.php?u={{ \Request::url() }}" target="_blank" class="text-white"><i class="fab fa-facebook"></i></a></span>

						<span class="px-2"><a href="whatsapp://send?text=IslamicResourceHub" data-action="share/whatsapp/share"  target="_blank" class="text-white"><i class="fab fa-whatsapp"></i></a></span>
						<span class="px-2"><a href="https://twitter.com/home?status={{ \Request::url() }}" target="_blank" class="text-white"><i class="fab fa-twitter"></i></a></span>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<a href="{{ route('theme.downloadresource',$resource) }}" onclick="return showSupportPopup();" class="btn bg-yellow btn-block"><i class="fas fa-download"></i> Download</a>
					</div>
					<div class="card-footer">
						<div class="my-2" style="display: grid;">
							<div style="grid-column: 1;" id="saveResourceContainer">
								@auth
								@if(!$resource->isResourceSavedByLoggedInUser())
								<a href="javascript:void(0);" onclick='saveResource("{{ $resource->id }}",true);'>
									<img src="{{ asset('irh_assets/images/singlesave.png') }}" alt="" width="30px"> <span class="text-muted pl-3">Save for later</span>
								</a>
								@else
								<img src="{{ asset('irh_assets/images/savedlogo.png') }}" alt="" width="30px"> Saved
								@endif
								@endauth

							</div>
							<div style="grid-column: 2;" id="likeContainer">
								@auth
								@if(!$resource->isResourceLikedByLoggedInUser())
								<a href="javascript:void(0);" class="btn bg-yellow" onclick='likeResource("{{ $resource->id }}");'><i class="far fa-thumbs-up"></i> Like</a>
								@else
								<a href="javascript:void(0);" class="btn bg-yellow"><i class="fas fa-thumbs-up"></i> Liked</a>
								@endif
								@endauth
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<section id="single-resource" class="p-lg-5 p-md-5 p-2">
	<div class="container">
	<div class="description">
		<h5 class="resource-section-heading">RESOURCE DESCRIPTION</h5>
		{!! $resource->description !!}
	</div>
	<hr>
	<div class="files py-4">
		<h5 class="resource-section-heading">PREVIEW FILES INCLUDED</h5>
		<div>
			<figure class="figure">
				<img src="{{ $resource->cover_attachment_path }}" alt="" class="img-thumbnail" width="200px" height="200px">
				<!-- <figcaption class="figure-caption ml-3"><a href="{{ route('theme.downloadresource',$resource) }}"><i class="fas fa-download"></i> Download resource file</a></figcaption> -->
			</figure>
		</div>
	</div>
	@if(!blank($resource->embed_link))
	<hr>
	<div class="embed py-4">
		<h4 class="heading">Embeded Video:</h4>
		<div id="embed_container" class="embed-responsive embed-responsive-16by9">
			{{-- From JS --}}
		</div>
	</div>
	@endif
	<hr>
	<!-- @auth
	<p>Report a <a href="" data-toggle="modal" data-target="#flagResourceModal">Problem</a></p>
	@if(Session::has('success'))
	<div class="alert alert-success">
		{{ Session::get('success') }}
	</div>
	@endif
	<hr>
	@endauth -->
	<h5 class="resource-section-heading">REVIEWS</h5>
	@auth
	@if(!$resource->loggedInUserHasReview())
	<a href="#" data-toggle="modal" data-target="#addReviewModal" class="btn bg-yellow btn-sm">Add a Review</a>
	@endif
	@endauth
	</h4>
	<div class="reviews">
		@foreach($resource->reviews as $rv)
		<div class="review py-4">
			<!-- create this shit new -->
			<h6 class="text-muted"><i class="fa fa-angle-right"></i> {{ $rv->user->full_name }} <span>{!! $rv->resourceStarsRatings() !!}</span>
			@if($rv->status == 1)
			@if($rv->user_id == Auth::id())
			&nbsp;&nbsp;<a href="javascript:void(0);" data-toggle="modal" data-target="#editReviewModal{{ $rv->id }}" class="text-muted"><i class="fa fa-pen"></i></a>
			@endif
			@if(Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator')))
			<a href="{{ route('theme.deletereviewfromresource',$rv) }}" class="text-muted ml-2" onclick="return confirm('Are you sure you want to delete this?');"><i class="fa fa-times"></i></a>
			@endif
			</h6>
			<p class="ml-3">{{ $rv->review }}</p>
			@else
			</h6>
			<p class="ml-3"><em>This review has been removed by a moderator.</em></p>
			@endif
		</div>
		<div class="modal fade" id="editReviewModal{{ $rv->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Edit Review</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="{{ route('theme.updatereviewfromresource',$rv) }}" method="POST">
							@csrf
							<div class="form-group">
								<label for="">Review</label>
								<textarea name="review" rows="2" class="form-control" placeholder="Review ..">{{ $rv->review }}</textarea>
							</div>
							<div class="form-group">
								<label for="">Rating</label>
								<select name="stars" id="" class="form-control">
									<option value="1" {{ ($rv->stars == 1)?'selected':'' }}>1 Star</option>
									<option value="2" {{ ($rv->stars == 2)?'selected':'' }}>2 Star</option>
									<option value="3" {{ ($rv->stars == 3)?'selected':'' }}>3 Star</option>
									<option value="4" {{ ($rv->stars == 4)?'selected':'' }}>4 Star</option>
									<option value="5" {{ ($rv->stars == 5)?'selected':'' }}>5 Star</option>
								</select>
							</div>
							<div class="form-group">
								<input type="submit" class="btn bg-yellow" value="Update Review">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	<hr>
	<h4 class="heading">Tags:</h4>
	<div class="tags py-4">
		@foreach($resource->tags as $tag)
		<a href="{{ route('theme.resourcesbytag',$tag) }}">
		<span class="bg-yellow p-2" style="border-radius:3em;">{{ $tag->name }}</span>
		</a>
		@endforeach
	</div>
	<hr>
	{{-- <hr>
	<h4 class="heading" id="commentsSection">Comments:</h4>
	<div class="commentSection py-4">
		@auth
		<form action="{{ route('theme.resources.comment') }}" method="POST">
			@csrf
			<div class="form-group">
				<textarea name="comment_text" id="" rows="3" class="form-control {{ $errors->has('comment_text') ? ' is-invalid' : '' }}" placeholder="Start typing here .." required></textarea>
				@if ($errors->has('comment_text'))
	            <span class="invalid-feedback" role="alert">
	              <strong>{{ $errors->first('comment_text') }}</strong>
	            </span>
	            @endif
			</div>
			<div class="form-group">
				<input type="hidden" name="resource_id" value="{{ $resource->id }}">
				<input type="submit" class="btn btn-primary" value="Add Comment">
			</div>
		</form> <hr>
		@endauth
		<div class="allComments">
			<div class="comments p-3" style="background: #eee;">
				@forelse($resource->comments as $comment)
				<div class="commentItem" >
					<div class="commentBy">
						<img src="{{ asset('irh_assets/images/avatar.png') }}" alt="" width="30px" class="rounded-circle" style="display: inline-block;">
						<p class="d-inline mt-2"><em>{{ $comment->user->full_name }}</em>
							@if($comment->user->id == Auth::id() OR Auth::user()->hasRole('admin'))
							<span class="ml-3"><a href="{{ route('theme.resources.comment.destroy',$comment) }}"><i class="fas fa-times"></i></a></span>
							@endif
						</p>
					</div>
					<div class="comment py-2">
						{!! $comment->comment !!}
					</div>
				</div>
				@if(!$loop->last)
				<hr>
				@endif
				@empty
				<div class="commentItem" >
					<div class="comment py-2 text-center">
						No Comments Found
					</div>
				</div>
				@endforelse
			</div>
		</div>
	</div> --}}
	<h5 class="resource-section-heading">RELATED RESOURCES</h5>
	<div class="relatedResources py-4 text-center">
		<div class="container">
			<div class="row">
				@forelse($related as $rel)
				<div class="col-md-3 mb-4">
					<div class="resourcebox">
						<div class="card">
							<a href="{{ route('theme.singleresource',$rel) }}">
							<img class="card-img-top" src="{{ $rel->preview_attachment_path }}" alt="Card image cap" style="position: relative;"></a>
							 <span style="position: absolute;top: -1;right: 10px;" id="saveResourceContainer_{{ $resource->id }}">
							  	@auth
							  	@if(!$resource->isResourceSavedByLoggedInUser())
							  	<a href="javascript:void(0);"  onclick='saveResource("{{ $resource->id }}",false);'>
							  	<img src="{{ asset('irh_assets/images/savelogo.png') }}" alt="" width="25px" data-toggle="tooltip" data-placement="top" title="save for later">
							  	</a>
							  	@else
							  	<img src="{{ asset('irh_assets/images/savedlogo.png') }}" alt="" width="25px">
							  	@endif
							  	@endauth
							  </span>
							<div class="card-body">
								<div class="pb-4"><img src="{{ asset('irh_assets/images/avatar.png') }}" alt="" width="30px" class="rounded-circle"><span class="ml-3">{{ $rel->user->full_name }}</span></div>
								<a href="{{ route('theme.singleresource',$rel) }}" class="text-muted"><h5 class="card-title">{{ $rel->title }}</h5></a>
							</div>
							<div class="card-footer">
								<div style="display: grid;">
									<div style="grid-column: 1;border-right: 1px solid #333;"><small>VIEWS</small><br>{{ $rel->views }}</div>
									<div style="grid-column: 2;border-right: 1px solid #333;"><small>DOWNLOADS</small><br>{{ $rel->downloads }}</div>
									<div style="grid-column: 3;"><small>LIKES</small><br>{{ $rel->likes->count() }}</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@empty
				<div class="col-md-4 offset-md-4">
					<h3>No Related Resource</h3>
				</div>
				@endforelse
			</div>
		</div>
	</div>
</div>
</section>
<div class="modal fade" id="addReviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add a Review</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('theme.addreviewtoresource') }}" method="POST">
					@csrf
					<div class="form-group">
						<label for="">Review</label>
						<textarea name="review" rows="2" class="form-control" placeholder="Review .."></textarea>
					</div>
					<div class="form-group">
						<label for="">Rating</label>
						<select name="stars" id="" class="form-control">
							<option value="1">1 Star</option>
							<option value="2">2 Star</option>
							<option value="3">3 Star</option>
							<option value="4">4 Star</option>
							<option value="5">5 Star</option>
						</select>
					</div>
					<div class="form-group">
						<input type="hidden" name="resource_id" value="{{ $resource->id }}">
						<input type="submit" class="btn bg-yellow" value="Add Review">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="flagResourceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Flag this Resource</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('theme.flagresource') }}" method="POST">
					@csrf
					<div class="form-group">
						<label for="">Reason</label>
						<textarea name="reason" rows="2" class="form-control" placeholder="Explain your problem .."></textarea>
					</div>
					<div class="form-group">
						<input type="hidden" name="resource_id" value="{{ $resource->id }}">
						<input type="submit" class="btn bg-yellow" value="Report">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@stop
@section('page_scripts')
<script src="{{ asset('irh_assets/vendor/summernote/summernote-lite.js') }}"></script>
 <script>
   $(document).ready(function(){ $('.summernote').summernote(); });
   function likeResource(res)
   {

   	$.ajax({
		 	  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
	          type: 'POST',
	          url: "{{ route('theme.likeresource.ajax') }}",
	          data: {resource:res},
	          success: function (data){
		          if(data.success)
		          {
		          	var html = '<a href="javascript:void(0);" class="btn bg-yellow"><i class="fas fa-thumbs-up"></i> Liked</a>';
   	 				$('#likeContainer').html(html);
		          }
	          }
		 });

   }

   function getId(url) {
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regExp);

    if (match && match[2].length == 11) {
        return match[2];
    } else {
        return 'error';
    }
}

	var videoId = getId("{{ $resource->embed_link }}");

	var iframeMarkup = '<iframe  class="embed-responsive-item" width="560" height="315" src="//www.youtube.com/embed/'
	    + videoId + '" frameborder="0" allowfullscreen></iframe>';
	 $('#embed_container').html(iframeMarkup);

 </script>
@endsection
