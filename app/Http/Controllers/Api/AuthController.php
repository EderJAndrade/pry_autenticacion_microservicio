<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['message'=>'Usuario registrado','token'=>$token,'user'=>$user],201);
    }

    public function login(LoginRequest $request)
    {
        $creds = $request->validated();
        $user = User::where('email',$creds['email'])->first();
        if (!$user || !Hash::check($creds['password'],$user->password)) {
            return response()->json(['message'=>'Credenciales inválidas'],401);
        }
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['message'=>'Autenticación exitosa','token'=>$token,'user'=>$user],200);
    }

    // Proteger con auth:sanctum
    public function validateToken(Request $request)
    {
        // Si llega acá, middleware auth:sanctum validó el token
        return response()->json(['valid'=>true,'user'=>$request->user()],200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Sesión cerrada (token revocado)'],200);
    }
}
