@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="col-lg-4 col-md-6 col-sm-8 col-10"> <!-- Updated the column classes for responsiveness -->
        <div class="card shadow">
            <div class="card-body">
                <h2 class="text-center mb-4">Login</h2>

                <!-- Display success or error messages -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('action.login') }}">
                    @csrf
                    <div class="form-group mt-3">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-4">Login</button>
                </form>
                <p class="text-center mt-3">Don't have an account? <a href="{{ route('register') }}" class="text-primary">Go to Register</a></p>

            </div>
        </div>
    </div>
</div>
@endsection
