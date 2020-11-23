<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signupActivate($token){

        $user = User::where('activation_token' , $token)->first();
        if(!$user){
            return response()->json([
                'message'=> 'this activation token is invalid'
            ], 404);
        }

        $user->active = true ;
        $user->activation_token = '';
        $user->email_verified_at = Carbon::now();
        $user->save();
        return $user;

    }
}
