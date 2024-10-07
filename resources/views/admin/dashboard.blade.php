@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@include('admin.nav')

<div class="container mt-4">
    <div class="row">
        <!-- Categories Card -->
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <i class="fas fa-th-list fa-2x text-primary"></i>
                    <h5 class="card-title mt-3">Total Categories</h5>
                    <p class="card-text">{{ $categoriesCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <!-- Users Card -->
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <i class="fas fa-users fa-2x text-success"></i>
                    <h5 class="card-title mt-3">Total Users</h5>
                    <p class="card-text">{{ $usersCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <!-- Products Card -->
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <i class="fas fa-box fa-2x text-warning"></i>
                    <h5 class="card-title mt-3">Total Products</h5>
                    <p class="card-text">{{ $productsCount ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    Your email: {{ Auth::user()->email }}
                </div>
                @endauth

            </div>
        </div>
    </div>
</div>
@endsection
