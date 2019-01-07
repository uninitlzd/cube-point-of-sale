<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterAuthRequest;
use App\Http\Resources\UserResource;
use App\Models\OwnerDetail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public $loginAfterSignUp = true;

    public function register(RegisterAuthRequest $request)
    {
        $user = User::create($request->all());

        $user->roles()->attach(Role::getRoleIdByName(Role::OWNER));
        $user->ownerDetail()->save(new OwnerDetail([
            'number_of_outlet' => 0,
            'number_of_employee' => 0
        ]));

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = auth('api')->attempt($input)) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'message' => ["Invalid Email or Password"]
                ],
            ], 401);
        }

        return response()->json([
            'success' => true,
            'access_token' => $jwt_token,
            'user' => new UserResource(auth('api')->user())
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        auth('api')->invalidate($request->token);

        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully'
        ]);
    }

    public function getAuthUser(Request $request)
    {
        return new UserResource(auth('api')->user());
    }
}
