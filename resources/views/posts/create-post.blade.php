@extends('layouts.app')

@section('content')
<div class="container">
    <div class="comment-form-wrap pt-5">
        @if(\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif
        <h3 class="mb-5">Create a New Post</h3>
        <form action="{{ route('posts.store') }}" method="POST" class="p-5 bg-light" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" placeholder="Title" name="title" 
            class="form-control" id="website">
        </div>

        <div class="form-group">
            <select name="category" class="form-select" aria-label="Default select example">
                <option selected>Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->name }}">{{ $category->name }}</option>    
                @endforeach                
            </select>
        </div>

        <div class="form-group">
            <label for="title">Image</label>
            <input type="file" name="image" 
            class="form-control" id="website">
        </div>

        <div class="form-group">
            <label for="message">Description</label>
            <textarea placeholder="Description" name="description" id="message" cols="30" rows="10" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <input type="submit" name="submit" value="Create Post" class="btn btn-primary">
        </div>
        </form>
    </div>
</div>


@endsection