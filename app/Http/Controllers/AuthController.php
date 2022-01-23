<?php

namespace App\Http\Controllers;

use App\Models\AccountManagerLog;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Auth;
class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => ['required',Rule::in(User::pluck('email'))],
            'password'=>'required'
        ]);
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
            $user = Auth::user();
            $token = $user->createToken('login')->plainTextToken;
            $log = new AccountManagerLog();
            $log->account_manager_id = $user->id;
            $log->vendor_id = 30263;
            $log->reason_log = 'For Test';
            $log->save();
            return response()->json([
                'user' => $user,
                'token' => $token,
                'log' => $log
            ], 200);
        }
        return response()->json([
            'message' => 'Not authenticated'
        ], 401);
    }
}
