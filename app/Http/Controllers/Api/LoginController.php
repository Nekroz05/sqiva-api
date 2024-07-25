<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\LoginResource;
use App\Services\Employee\ReadEmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request, ReadEmployeeService $employee)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $loggedInEmployee = $employee->findEmployeeByEmail($request->email);

            if ($loggedInEmployee)
            {
                $authUser = Auth::user();
                /**
                 * @var \App\Models\User $authUser
                 * 
                 */
                $token = $authUser->createToken(
                    'auth_token',
                    ['*'],
                    now()->addHour()
                )->plainTextToken;
                $loggedInEmployee->token = $token;
                unset($loggedInEmployee->password);

                return new LoginResource(
                    $loggedInEmployee,
                    'Login Successfully',
                    200
                );
            }
        }
        else
        {
            return response()->json([
                'error' => 'Credential failed'
            ], 401);
        }
    }

    public function logout()
    {
        $authUser = Auth::user();
        /**
         * @var \App\Models\User $authUser
         */
        $authUser->currentAccessToken()->delete();
        Auth::logout();

        return new LoginResource(
            [],
            'Logout Successful',
            200
        );
    }
}
