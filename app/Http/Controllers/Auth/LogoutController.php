<?php

namespace App\Http\Controllers\Auth;

use App\Traits\ApiHttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    use ApiHttpResponse;

    public function delete(Request $request){

        $user = $request->user();
        // Delete all user tokens
        $user->tokens()->delete();

        $data = [
            'user' => $user
        ];
        $message = 'logout successful';
        return $this->sendSuccess($data,  $message, 200);
    }
}
