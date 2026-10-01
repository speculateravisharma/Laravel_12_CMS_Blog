@extends('layouts.app')

@section('content')

<div class="site-cover site-cover-sm same-height overlay single-page"
     style="margin-top:-25px; background-image: url('{{ asset('assets/images/hero_3.jpg') }}');">
    <div class="container">
      <div class="row same-height justify-content-center">
        
        <div class="col-md-6">
          <div class="post-entry text-center">
            <img style="width:70px;height:70px;" src="{{ asset('assets/user_images/'.$profile->image.'') }}">
            <h1 class="mb-4">{{ substr($profile->name,0,25) }}</h1>
            <div class="post-meta align-items-center text-center">
              {{-- <figure class="author-figure mb-0 me-3 d-inline-block"><img src="images/person_1.jpg" alt="Image" class="img-fluid"></figure> --}}
              
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="container">

      <div class="row blog-entries element-animate">

        <div class="col-md-12 col-lg-8 main-content">

            <div class="post-content-body">
                <p>
                    {{ $profile->bio }}
                </p>
            </div>   

        </div>

        <!-- END main-content -->

        <div style="padding:30px;margin-left:710px;margin-top:-56px;width:321px;" class="sidebar-box">
            <h3 class="heading">Latest Posts by this Author</h3>
            <div class="post-entry-sidebar">
              <ul>
                @foreach ($latestPosts as $post)
                    <li>
                        <a href="{{ route('posts.single',$post->id) }}">
                            <img src="{{ asset('assets/images/'.$post->image.'') }}" alt="Image placeholder" class="me-4 rounded">
                            <div class="text">
                            <h4>{{ substr($post->title,0,15) }}</h4>
                            <div class="post-meta">
                                <span class="mr-2">{{ \Carbon\Carbon::parse($post->created_at)->format('M d,Y'); }} </span>
                            </div>
                            </div>
                        </a>
                    </li>    
                @endforeach                            
              </ul>
            </div>
          </div>
        <!-- END sidebar -->

      </div>
    </div>
  </section>


  

  @endsection