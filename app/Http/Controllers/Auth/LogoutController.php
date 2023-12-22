<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    //
    public function delete(Request $request){
        
        $user = $request->user();
        // Delete all user tokens
        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'logout successful',
            'data' => [
                'user' => $user,
            ],
        ], 200);
    }
}
