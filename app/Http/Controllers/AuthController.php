<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiLoginRequest;
use App\Traits\ApiResponses;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
  

    public function getLoginPage(){
        return view('auth.login');
    }

    public function authenticate(){
        
        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
 
            return redirect()->intended('students');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(){
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }

    public function getForgotPasswordPage(){
        return view('auth.resetPage');
    }

    public function requestForgotPasswordLink(){
       request()->validate([
        'email' => 'required|email'
       ]);

     $status =  Password::sendResetLink(
        request()->only('email')
       );

       return $status === Password::RESET_LINK_SENT
       ? back()->with(['alertMessage' => __($status)])
       :back()->withErrors(['email' => __($status)]);
    }

    public function getPasswordResetPage($token){
        $email = request()->query('email');
       return view('auth.passwordResetPage', [
        'token' => $token,
         'email' => $email
        ]);
    }

  
    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
            'token' => 'required',
            'password' => 'required|min:6|max:150|confirmed'
        ]);


        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
                $user->save();
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('auth.login')->with('alertMessage', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function getToken(){
         request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
      $user = User::where('email', request()->email)->first();

      if(! $user || ! Hash::check(request()->password, $user->password)){
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect']
        ]);
      }
     
      $token = $user->createToken(request()->ip())->plainTextToken;

      return [
        'message' => 'login successful',
        'token' => $token,
        'user' => $user
      ];
    }

    public function revokeToken(){
     request()->user()->tokens()->delete();
     return [
       'message' => 'logout successful',
     ];
   }
}