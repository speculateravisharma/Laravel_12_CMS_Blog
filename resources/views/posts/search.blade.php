@extends('layouts.app')

@section('content')

<div class="section search-result-wrap">
		<div class="container">
			<div class="row">
				{{-- <div class="col-12">
					<div class="heading">Category: {{ $name }}</div>
				</div> --}}
			</div>
			<div class="row posts-entry">
				<div class="col-lg-8">
                    @foreach ($results as $post)
                        <div class="blog-entry d-flex blog-entry-search-item">
                            <a href="{{ route('posts.single', $post->id) }}" class="img-link me-4">
                                <img width="150" height="150" src="{{ asset('assets/images/'.$post->image.'') }}" alt="Image" class="img-fluid">
                            </a>
                            <div>
                                <span class="date">{{ \Carbon\Carbon::parse($post->created_at)->format('M d,Y'); }} &bullet; <a href="#">{{ $post->category }}</a></span>
                                <h2>
                                    <a href="{{ route('posts.single', $post->id) }}">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                <p>{{ substr($post->description, 0 , 55) }}</p>
                                <p><a href="{{ route('posts.single', $post->id) }}" class="btn btn-sm btn-outline-primary">Read More</a></p>
                            </div>
                        </div>    
                    @endforeach					
				</div>

				
			</div>
		</div>
	</div>

@endsection