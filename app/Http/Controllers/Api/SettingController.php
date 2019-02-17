<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('api')->user();
        $user->update($request->except('password_confirmation'));
        return new UserResource($user);
    }
}
