@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="text-center mb-4">Verify OTP</h2>

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

                <!-- OTP Verification Form -->
                <form method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label for="otp">Enter OTP</label>
                        <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp" name="otp" placeholder="Enter OTP" required>
                        @error('otp')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-block">Verify OTP</button>
                    </div>
                </form>

                <!-- Resend OTP Button -->
                <form method="POST" action="{{ route('otp.resend') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-link">Resend OTP</button>
                </form>

                <!-- Countdown Timer -->
                <div class="text-center mt-4">
                    <span>Time remaining: <span id="countdown" data-expires-at="{{ $expiresAtTimestamp }}"></span></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countdownElement = document.getElementById('countdown');
        const expiresAtTimestamp = parseInt(countdownElement.getAttribute('data-expires-at'));

        const updateCountdown = () => {
            const now = Math.floor(Date.now() / 1000);
            const remainingTime = expiresAtTimestamp - now;

            if (remainingTime <= 0) {
                countdownElement.textContent = "Expired";
                window.location.href = "{{ route('login') }}";

            } else {
                const minutes = Math.floor(remainingTime / 60);
                const seconds = remainingTime % 60;
                countdownElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            }
        };

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
</script>
@endsection
