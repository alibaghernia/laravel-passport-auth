<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Notifications\SignupActivate;

class RegisterController extends Controller
{

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'unique:users', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'unique:users', 'string'],
            'phone_number' => ['required', 'unique:users', 'string', 'max:255'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ]);
        
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => false], 500);
        } 

        $user = new User([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'activation_token' => Str::random(60),
        ]);

        
            $user->save();

            $user->notify(new SignupActivate($user));

            return response()->json([
                'message' => 'Succsessfully create user!'
            ], 201);
        
    }
}
