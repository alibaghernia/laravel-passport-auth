<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function index(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Succsessfull Logout!'
        ]);
    }
}
