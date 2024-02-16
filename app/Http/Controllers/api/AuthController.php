<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseHelpers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function getTokenByPasswordAndEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return ResponseHelpers::validation($validator->messages());
        }

        $user = User::where('email', $request->email)->first();
        if (!Hash::check($request->password, $user->password)) {
            return ResponseHelpers::error(null, 'Invalid credentials', 401);
        }

        // date format to timestamp
        $date = Carbon::now()->timestamp;
        $role = $user->role->can;
        $token = $user->createToken($date, $role)->plainTextToken;
        return ResponseHelpers::success(['token' => $token], 'Successfully create Token');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ResponseHelpers::success(null, 'Successfully logout');
    }
}
