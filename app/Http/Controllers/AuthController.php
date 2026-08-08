<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\Auth\UserRegistrationService;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(protected UserRegistrationService $create) {}

    public function register(AuthRequest $request)
    {
        $validateData = $request->validated();
        $this->create->userCreate($validateData);

        return response()->json([
            'success' => true,
            'message' => 'Registro exitoso',
        ], Response::HTTP_CREATED);
    }

    public function updateUser(UpdateUserRequest $request, User $user)
    {
        $validateData=$request->validated();
        $user->update($validateData);
        return response()->json([
            'message' => ' actualizado correctamente',
            'data' => $user
        ],);
    }

    public function login(LoginRequest $request)
    {
        $validateData = $request->validated();
        $credentials = [
            'email' => $validateData['email'],
            'password' => $validateData['password']
        ];
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario o contraseña inválidos',
                    'errors' => null
                ], Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo generar el token',
                'errors' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'success' => true,
            'message' => 'Login exitoso',
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => auth()->user() // Esto incluye el role_id y area_id
            ]
        ]);
    }

    public function logout()
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::invalidate($token);
            return  response()->json(['sesion cerrada correctamente']);
        } catch (JWTException) {
            return response()->json([
                'error' => 'No se pudo cerrar la sesion, el token no es valido'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
