<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailOtp;
use Carbon\Carbon;
class AuthController extends Controller
{
    public function showregister()
    {
        return view('register');
    }

    public function showlogin()
    {
        return view('login');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string', 'email','max:255', 'unique:users'],
            'password' => ['required','string','min:6'],
            'g-recaptcha-response' => ['required','captcha'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($user) {
            return redirect()->route('login')->with('success', 'User registered successfully.');
        } else {
            return redirect()->route('register')->with('error', 'An error occurred while registering the user. Please try again.');
        }   
     }

     public function login(Request $request)
     {
         $request->validate([
             'email' => 'required|email',
             'password' => 'required|string',
         ]);
     
         if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
             $user = Auth::user();
     
             $validuser = User::where('id', $user->id)->where('otp_verified', true)->first();   
             
             if ($validuser) {
                if ($validuser) {
                    // Check if the user is admin or user based on the model methods
                    if ($validuser->isAdmin()) {
                        return redirect()->intended('admin'); // Redirect to admin dashboard
                    } elseif ($validuser->isUser()) {
                        return redirect()->intended('user'); // Redirect to user dashboard
                    }
                }
             }
     
             Otp::where('user_id', $user->id)->delete();
     
             $otp = rand(100000, 999999);
             
             Otp::create([
                 'user_id' => $user->id,
                 'otp' => $otp,
                 'expires_at' => Carbon::now()->addMinutes(10),
             ]);
     
             Mail::to($user->email)->send(new MailOtp($otp, $user->name));
     
             return redirect()->route('show.otp');
         } else {
             return redirect()->route('login')->with(['error' => 'Invalid email or password.']);
         }
     }


     public function resendOtp(Request $request)
     {
         $user = Auth::user();
 
         // Delete existing OTP
         Otp::where('user_id', $user->id)->delete();
 
         // Generate a new OTP
         $otp = rand(100000, 999999);
         
         Otp::create([
             'user_id' => $user->id,
             'otp' => $otp,
             'expires_at' => Carbon::now()->addMinutes(10),
         ]);
 
         // Send OTP via email
         Mail::to($user->email)->send(new MailOtp($otp, $user->name));
 
         return redirect()->route('show.otp')->with(['success' => 'A new OTP has been sent to your email.']);
     }

     public function verifyOtp(Request $request)
     {
         $request->validate([
             'otp' => 'required|integer',
         ]);
 
         $user = Auth::user();
         $otpRecord = Otp::where('user_id', $user->id)
                         ->where('otp', $request->otp)
                         ->where('expires_at', '>', Carbon::now())
                         ->first();
 
         if ($otpRecord) {
             // OTP is valid
             $user->otp_verified = true;
             $user->save();
 
             Otp::where('user_id', $user->id)->delete(); 
             if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'OTP verified successfully. Welcome, admin.');
            } else {
                return redirect()->route('user.dashboard')->with('success', 'OTP verified successfully.');
            }    
         } else {
             return redirect()->route('show.otp')->with('error', 'Invalid or expired OTP.');
         }
     }





     public function logout(Request $request)
     {
         // Optional: If you want to reset OTP verification status
         $user = Auth::user();
         if ($user) {
             $user->otp_verified = false;
             $user->save();
         }
 
         // Log the user out
         Auth::logout();
 
         // Invalidate the user's session
         $request->session()->invalidate();
         $request->session()->regenerateToken();
 
         return redirect()->route('login')->with(['success' => 'Logged out successfully.']);
     }

     public function userdashboard()
     {
         return view('user.dashboard');
     }

 

     public function showOtp()
     {
         $user = Auth::user();
         $otpRecord = Otp::where('user_id', $user->id)
                          ->where('expires_at', '>', Carbon::now())
                          ->first();
     
         if (!$otpRecord) {
             return redirect()->route('login')->with('error', 'OTP expired or not found.');
         }
     
         $expiresAtTimestamp = Carbon::parse($otpRecord->expires_at)->timestamp;
     
         return view('mailotp', compact('expiresAtTimestamp'));
     }


}
