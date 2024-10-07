<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <!-- Bootstrap Email CSS -->
    <style>
        /* Include inline Bootstrap Email styles */
        /* Import font from Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .email-body {
            padding: 20px;
        }
        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }
        .icon {
            font-size: 48px;
            color: #007bff;
            margin-bottom: 15px;
        }
    </style>
    <!-- FontAwesome icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
    <div class="email-container">
        <!-- Email Header -->
        <div class="email-header">
            <h1>Verify Your Email</h1>
        </div>

        <!-- Email Body -->
        <div class="email-body text-center">
            <!-- Icon -->
            <div class="icon">
                <i class="fas fa-envelope"></i>
            </div>

            <h2>Hello {{ $name }},</h2>
            <p>Thank you for registering with us! To complete your sign-up process, please verify your email address using the OTP below.</p>

            <p class="otp-code">{{ $otp }}</p>

            <p>If you did not request this OTP, please disregard this email.</p>

            <!-- Call to Action -->
            {{-- <a href="{{ $verificationUrl }}" class="btn btn-primary">Verify Now</a> --}}
        </div>

    
    </div>
</body>
</html>
