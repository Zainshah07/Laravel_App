<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\FileUploadManager;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyRegistrationEmail;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendVerificationEmailJob;
use App\Http\Requests\ProfileUpdateRequest;


class AuthController extends Controller
{
    public function login()
    {
        return view('Auth.login');
    }

    public function registerView(){
        return view('Auth.register');
    }

    //Registration Controller to authentiacte registration

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'is_active' => false,
            'verification_token' => Str::random(64)
        ]);
        \Log::info('Sending verification email to ' . $user->email);
       SendVerificationEmailJob::dispatch($user);
        \Log::info('Email sent.');

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Check your email to verify your account.'
        ]);
}

    // Token Verification and updation after Email verification

     public function verify($token , $email){
        $user= User::where('verification_token' , $token)->whereEmail($email)->first();
          if (!$user) {
            return redirect()->with('error', 'Invalid verification link.');
        }

         // Activate user
        $user->update([
            'is_active' => true,
            'email_verified_at' => now(),
            'verification_token' => null
        ]);

    return redirect()->route('login')->with('success', 'Your email has been verified. You can now login.');

    }



    public function loginAction(LoginRequest $request){
            \Log::info('loginCheck endpoint called', $request->all());


        $user= User::where('email',$request->email)->first();

        if(!$user){
            return response()->json([
                'success'=>false,
                'message'=>'user not found'
            ],200);

        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is inactive. Contact admin.'
            ], 200);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect password'
            ], 200);
        }

         // ✅ Check if "remember me" checkbox was selected
    $remember = $request->boolean('remember'); // this will be true if checkbox is checked

        Auth::login($user, $remember);

         return response()->json([
            'success' => true,
            'message' => 'Login successful'
        ], 200);
    }

    public function profile(){
        return view('admin.profile.index');
    }

    public function updateProfile(ProfileUpdateRequest $request){


        $user= Auth::user();

        $user->fill([
            'name'=>$request->name,
            'phone'=>$request->phone
        ]);


        // If profile image is uploaded, this will trigger the mutator
        if ($request->hasFile('profile_image')) {
         $image = FileUploadManager::uploadFile($request->profile_image , 'profile_images/');
         $user->profile_image = $image['path'];
        }

        $user->save();

         return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
             'profile_image_url' => $user->profile_image, // accessor gives full URL
            'user'    => $user
        ]);
    }

    public function updatePassword(Request $request){
        $request->validate([
            'password'=>'required|min:6|confirmed'
        ]);
        $user=Auth::user();
        $user->update([
            'password'=>$request->password
        ]);
        return response()->json([
        'success' => true,
        'message' => 'Password updated successfully!'
    ]);

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');

    }
}
