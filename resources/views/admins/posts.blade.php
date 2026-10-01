@extends('layouts.admin')

@section('content')

<div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">

                @if(\Session::has('delete'))
                    <div class="alert alert-success">
                    <p>{!! \Session::get('delete') !!}</p>
                    </div>          
                @endif
              <h5 class="card-title mb-4 d-inline">Posts</h5>
            
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">title</th>
                    <th scope="col">category</th>
                    <th scope="col">user</th>
                    <th scope="col">delete</th>
                  </tr>
                </thead>
                <tbody>

                    @foreach ($posts as $post)
                        <tr>
                            <th scope="row">{{ $post->id }}</th>
                            <td>{{ substr($post->title, 0 , 35) }}</td>
                            <td>{{ $post->category }}</td>
                            <td>{{ $post->user_name }}</td>
                            <td><a href="{{ route('admins.posts.delete', $post->id) }}" class="btn btn-danger  text-center ">delete</a></td>
                        </tr>      
                    @endforeach
                  
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>

@endsection
