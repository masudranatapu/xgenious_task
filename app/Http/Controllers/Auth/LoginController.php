<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }


    public function loginUser(LoginRequest $request)
    {
        try {

            $user = User::query()
                ->where('email', $request->username_email)
                ->orWhere('username', $request->username_email)
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found with this given data'
                ]);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Password Do not match with our records'
                ]);
            }

            Auth::login($user);

            return response()->json([
                'status' => true,
                'message' => 'User Successfully Logged',
                'route' => route('home')
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => 'Sorry! Something went wrong. Try again',
            ]);
        }
    }
}
