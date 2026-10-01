@extends('layouts.app')

@section('content')
<div class="container">
    <div class="comment-form-wrap pt-5">
        
        <h3 class="mb-5">Update Profile Info</h3>
        @if(session('update'))
            <div class="alert alert-success">
                {{ session('update') }}
            </div>
        @endif
        
        <form action="{{ url('/users/update/'.$user->id) }}" method="POST" class="p-5 bg-light">
        @csrf
        <div class="form-group">
            <label for="title">Email</label>
            <input type="text" placeholder="Email" name="email" value="{{ $user->email }}"
            class="form-control" id="website">
        </div>

        @error('email')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <div class="form-group">
            <label for="title">Name</label>
            <input type="text" placeholder="name" name="name" value="{{ $user->name }}"
            class="form-control" id="website">
        </div>
        @error('name')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        
        
        <div class="form-group">
            <label for="message">Bio</label>
            <textarea placeholder="bio" name="bio" id="message" cols="30" rows="10" class="form-control">
                {{ $user->bio }}
            </textarea>
        </div>
        @error('bio')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <div class="form-group">
            <input type="submit" name="submit" value="Update Profile" class="btn btn-primary">
        </div>
        </form>
    </div>
</div>

@endsection