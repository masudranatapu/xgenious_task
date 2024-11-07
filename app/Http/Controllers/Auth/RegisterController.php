<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SetPasswordRequest;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{


    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }


    public function registerUser(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $userExist = User::query()
                ->where('email', $request->email)
                ->orWhere('username', $request->username)
                ->first();

            if ($userExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'User already exist with this email or username'
                ]);
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit();

            Auth::login($user);

            return response()->json([
                'status' => true,
                'message' => 'User Successfully Register',
                'route' => route('home')
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }
    public function forgetPasswordMail(Request $request)
    {
        try {
            DB::beginTransaction();

            $token = Str::random(40);

            $user = User::query()
                ->where('email', $request->email_username)
                ->orWhere('username', $request->email_username)
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found this this information',
                ]);
            }

            $user->remember_token = $token;

            $user->save();

            Mail::to($user->email)->send(new PasswordResetMail($user, $token));

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Password Reset mail successfully sent to your email. Please Check your mail',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }
    public function setForgetPassword(Request $request)
    {

        $user = User::query()
            ->where('remember_token', $request->token)
            ->first();
        if (!$user) {
            return redirect()->route('frontend.index')->with([
                'message' => 'Token not match with our recode',
                'alert-type' => 'info'
            ]);
        }

        return view('auth.passwords.reset', compact('user'));
    }
    public function setPassword(SetPasswordRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::query()
                ->where('remember_token', $request->forget_token)
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found this this information',
                ]);
            }

            $user->password = Hash::make($request->password);
            $user->remember_token = null;
            $user->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'New Password Password Successfully Set',
                'route' => route('login')
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }
}
