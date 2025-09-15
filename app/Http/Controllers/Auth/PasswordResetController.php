<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\PasswordResetEmail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{

    public function forgotPassword(Request $request){

        $request->validate([
            'email'=>'required|email|exists:users,email'
        ]);
        $token= Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
             ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );



        // Send verification email
      Mail::to($request->email)->send(new PasswordResetEmail([
            'token' => $token,
            'email' => $request->email
        ]));




        return response()->json([
            'success' => true,
            'message' => 'Password reset link sent to your email.'
        ]);


    }

    public function resetPassword(Request $request){
              $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

         $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

             if (!$record) {
            return response()->json(['success' => false, 'message' => 'Invalid token.'], 400);


        }

              // Check if token expired (> 3 hours)
        if (Carbon::now()->diffInHours(Carbon::parse($record->created_at)) > 3) {
            return response()->json(['success' => false, 'message' => 'Token expired.'], 400);
        }

        // Update password
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Delete token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.'
        ]);

    }
}
