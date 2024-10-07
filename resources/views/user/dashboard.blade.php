@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
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

                @auth
                <div class="alert alert-info">
                    Welcome, {{ Auth::user()->name }}!

                </div>
                <div class="alert alert-info">
                    Welcome, {{ Auth::user()->email }}!
                    
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
                @endauth

            </div>
        </div>
    </div>
</div>
@endsection
