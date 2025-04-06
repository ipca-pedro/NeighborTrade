<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use App\Models\Morada;
use App\Models\Imagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'Email' => 'required|email',
            'Password' => 'required'
        ]);

        if (Auth::attempt(['Email' => $credentials['Email'], 'Password' => $credentials['Password']])) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'Login realizado com sucesso'
            ]);
        }

        return response()->json([
            'message' => 'As credenciais fornecidas estão incorretas.'
        ], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255|unique:utilizador,User_Name',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilizador,Email',
            'password' => 'required|string|min:8|confirmed',
            'cc' => 'required|integer|unique:utilizador,CC',
            'data_nascimento' => 'required|date',
            'rua' => 'required|string',
            'foto_perfil' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            // 1.1 Criar morada
            $morada = Morada::create([
                'Rua' => $request->rua
            $path = $file->storeAs('public/comprovativos', $filename);

            // Criar registro na tabela imagem
            $imagem = new Imagem([
                'Nome' => $filename,
                'Path' => $path
            ]);
            $imagem->save();

            // Criar registro na tabela morada
            $morada = new Morada([
                'ImagemID_Imagem' => $imagem->ID_Imagem
            ]);
            $morada->save();
        }

        $user = new Utilizador([
            'Name' => $request->Name,
            'User_Name' => $request->User_Name,
            'Email' => $request->Email,
            'Password' => Hash::make($request->Password),
            'Data_Nascimento' => $request->Data_Nascimento,
            'CC' => $request->CC,
            'MoradaID_Morada' => $morada->ID_Morada,
            'ImagemID_Imagem' => $imagem->ID_Imagem,
            'Status_UtilizadorID_status_utilizador' => 1, // Status pendente
            'TipoUserID_TipoUser' => 1 // Tipo usuário normal
        ]);

        $user->save();

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Registro realizado com sucesso'
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ]);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

    public function verifyEmail($token)
    {
        $user = Utilizador::where('verification_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Token de verificação inválido'], 400);
        }

        if ($user->email_verified_at) {
            return response()->json(['message' => 'Email já verificado'], 400);
        }

        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        return response()->json(['message' => 'Email verificado com sucesso']);
    }

    public function resendVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:utilizador,Email'
        ]);

        $user = Utilizador::where('Email', $request->email)->first();

        if ($user->email_verified_at) {
            return response()->json(['message' => 'Email já verificado'], 400);
        }

        $verificationToken = Str::random(64);
        $user->verification_token = $verificationToken;
        $user->save();

        Mail::to($user->Email)->send(new VerifyEmail($user, $verificationToken));

        return response()->json(['message' => 'Email de verificação reenviado']);
    }
}
