<?php

namespace App\Http\Controllers\Api\Auth;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginJwtController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->all('email', 'password');

        Validator::make($credentials, [
            'email' => 'required|string',
            'password' => 'required|string',
        ])->validate();

        //attempt vai tentar logar o usuario
        if (!$token = auth('api')->attempt($credentials)) {
            $message = new ApiMessages('Você levou um toco!');
            return response()->json($message->getMessage(), 401);
        }

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Bye bye!', 200]);
    }

    //atualizar o token
    public function refresh()
    {
        $token = auth('api')->refresh();
        return response()->json([
            'token' => $token
        ]);
    }
}
