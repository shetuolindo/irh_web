@extends('layouts.app')
@section('content')
<header id="single-resource-header" class="bg-blue py-5" style="height: 400px;">
	<div class="container-fluid" style="margin-top:5%;margin-left: 2%;">
		@if(Session::has('successPublish'))
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="alert alert-success">
					<h6>Jazakallahu Khairan for sharing your resource, as part of quality control one of our team members will need to approve of your resource before going live. <br> <a href="#">Click here</a> to find out more about what type of resources will not be approved.</h6>
				</div>
			</div>
		</div>
		@else
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<div class="alert alert-success">
					@if($resource->resource_status == 'drafted')
					<h6>A draft copy of this resource has been saved</h6>
					@endif
					<a href="{{ route('dashboard.resources.edit',$resource) }}" class="btn bg-blue btn-sm"><i class="fas fa-pen"></i> Edit</a>
					@if($resource->resource_status == 'drafted')
					<a href="{{ route('dashboard.resource.submitforreviewbyuser',$resource) }}" class="btn bg-blue btn-sm"><i class="fas fa-check"></i> Submit for review</a>
					@elseif($resource->resource_status == 'inreview')
					<a href="#" class="btn bg-blue btn-sm"><i class="fas fa-info"></i> In-Review</a>
					@endif
				</div>
			</div>
		</div>
		@endif
		<div class="row">
			<div class="col-md-8 text-left">
				<h3 class="text-white mb-0">{{ ucwords($resource->title) }} (Preview)</h3>
				<div class="py-2" style="border-bottom: 1px solid #ffffff85;">
					<i class="fas fa-star" style="color:var(--yellow-color);"></i>
					<i class="fas fa-star" style="color:var(--yellow-color);"></i>
					<i class="fas fa-star" style="color:var(--yellow-color);"></i>
					<i class="fas fa-star" style="color:var(--yellow-color);"></i>
					<i class="far fa-star"></i>
					<span class="pl-2">{{ $resource->reviews->count() }} Review</span>
				</div>
				<div class="py-2">
					<div class="float-left">
						<h5 class="text-white mb-0">Author: {{ ucwords($resource->user->full_name) }}</h5>
						<h5 class="text-white mb-0 mt-2">Created at: {{ date('d-M-Y',strtotime($resource->created_at)) }}</h5>
					</div>
					<div class="float-right">
						<span class="px-2"><i class="fab fa-instagram"></i></span>
						<span class="px-2"><i class="fab fa-facebook"></i></span>
						<span class="px-2"><i class="fab fa-whatsapp"></i></span>
						<span class="px-2"><i class="fab fa-twitter"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card">
					<div class="card-body">
						<a href="{{ route('theme.downloadresource',$resource) }}" class="btn bg-blue btn-block"><i class="fas fa-download"></i> Download</a>
					</div>
					<div class="card-footer">
						<div class="my-2" style="display: grid;">
							<div style="grid-column: 1;">
								<img src="{{ asset('irh_assets/images/singlesave.png') }}" alt="" width="30px"> <span class="text-muted pl-3">Save for later</span>
							</div>
							<div style="grid-column: 2;">
								<a href="javascript:void(0);" class="btn bg-yellow"><i class="far fa-thumbs-up"></i> Like</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<section id="single-resource" class="p-5">
	<div class="description">
		{!! $resource->description !!}
	</div>
	<hr>
	<div class="files py-4">
		<h4 class="heading">File(s) Included:</h4>
		<div>
			<figure class="figure">
			  <img src="{{ $resource->cover_attachment_path }}" alt="" class="img-thumbnail" width="200px" height="200px">
			  <figcaption class="figure-caption ml-3"><a href="{{ route('theme.downloadresource',$resource) }}"><i class="fas fa-download"></i> Download resource file</a></figcaption>
			</figure>
		</div>
	</div>
	<hr>
	<p>Report a <a href="">Problem</a></p>
	<hr>
	<h4 class="heading">Review(s):
	</h4>
	<div class="reviews">
		@foreach($resource->reviews as $rv)
		<div class="review py-4">
			<h6 class="text-muted"><i class="fa fa-angle-right"></i> {{ $rv->user->full_name }} <span>{!! $rv->resourceStarsRatings() !!}</span></h6>
			<p class="ml-3">{{ $rv->review }}</p>
		</div>
		@endforeach
	</div>
	<hr>
	<h4 class="heading">Tags:</h4>
	<div class="tags py-4">
		@foreach($resource->tags as $tag)
		<span class="bg-blue p-2" style="border-radius:3em;">{{ $tag->name }}</span>
		@endforeach
	</div>
</section>

@stop