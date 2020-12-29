<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

class LoginController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            //'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        //dd($user);

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $usuario = [
            'id' => $user['id'],
            'name' => $user['name'],
            'direction' => $user['direction'],
            'telephone' => $user['telephone'],
            'email' => $user['email'],
            'profile_photo' => $user['profile_photo']
        ];

        //dd($usuario);

        $response = [
            'usuario' => $usuario,
            'token' => $token
        ];
        //dd($response);
        return response($response, 200);
    }

    public function logout(){
        //Auth::user()->tokens()->delete(); //Eliminar todos los tokens
        Auth::user()->currentAccessToken()->delete(); //Eliminar token actual

        $response = [
            'status' => 'ok',
            'message' => 'Se eliminó el token'
        ];

        return response($response, 200);
    }
}
