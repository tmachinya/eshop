<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ChangePasswordController extends Controller
{
    public function process(ChangePasswordRequest $request)
    {
        return $this->getPasswordResetTable($request)->count() > 0 ? $this->changePassword($request) : $this->tokenNotFoundResponse();
    }

    public function getPasswordResetTable($request)
    {
        return DB::table('password_resets')->where([
            'email' => $request->email, 'token' => $request->resetToken
        ]);
    }

    public function changePassword($request)
    {
        $user = User::whereEmail($request->email)->first();
        $user->update([
            'password' => $request->password
        ]);
        $this->getPasswordResetTable($request)->delete();
        return response()->json(['data' => 'Password successfully changed'], Response::HTTP_CREATED);

    }

    public function tokenNotFoundResponse()
    {
        return response()->json(['error' => 'Token or Email is incorrect'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
