<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\ApiToken;
use App\Services\Jwt;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request, Jwt $jwt, Employee $employee)
    {
        if (!$request->employee_number || !$request->password) {
            return response()->json([
                'message' => 'Please complete the required fields!'
            ], 422);
        }

        $query = $employee->get_user($request->employee_number, $request->password);

        if (!$query) 
            return response()->json([
                'message' => 'Your credentials are incorrect!'
            ], 401);

        // Create token for the user
        $token = ApiToken::create([
            'employee_id' => $query->id,
            'token'       => $jwt->encrypt([
                'employee_no' => $query->employee_no,
                'name'        => $query->name,
                'created_at'  => Carbon::now()->toDateTimeString()
            ]),
            'revoked'    => 0,
            'expires_at' => Carbon::now()->addMinutes(config('auth.token_expiration'))
        ]);

        return response()->json([
            'user'         => $query,
            'access_token' => $token->token,
            'expires_at'   => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }
}
