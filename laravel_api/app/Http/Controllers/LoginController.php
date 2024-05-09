<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use ApiResponse;
    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        if (User::where('email', $request->email)->first()) {
            $user = User::where('email', $request->email)->first();
            if (Hash::check($request->password, $user->password)) {
                $success['token'] =  $user->createToken('round56')->plainTextToken;
                $success['user'] =  $user;
                Auth::login($user);
                return $this->sendResponse($success, 'Login successful.');
            }
        } else {
            return $this->sendError('Unauthorised.', ['error' => ['No user found with this phone number']], 422);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->sendResponse('', 'User logged out successfully.');
    }
}
