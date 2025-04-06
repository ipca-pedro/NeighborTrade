<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    // Solicitar reset de senha
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = Utilizador::where('Email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Se o email existir, enviaremos um link de recuperação'
            ]);
        }

        // Gerar token único
        $token = Str::random(60);
        
        // Salvar token no banco
        DB::table('password_resets')->insert([
            'email' => $user->Email,
            'token' => Hash::make($token),
            'created_at' => now()
        ]);

        // Enviar email
        // TODO: Implementar envio de email com o token

        return response()->json([
            'message' => 'Se o email existir, enviaremos um link de recuperação'
        ]);
    }

    // Validar token e resetar senha
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        // Verificar token
        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return response()->json([
                'message' => 'Token inválido'
            ], 400);
        }

        // Verificar se o token não expirou (24 horas)
        if (now()->diffInHours($reset->created_at) > 24) {
            return response()->json([
                'message' => 'Token expirado'
            ], 400);
        }

        // Atualizar senha
        $updated = DB::table('utilizador')
            ->where('Email', $request->email)
            ->update(['Password' => Hash::make($request->password)]);

        if (!$updated) {
            return response()->json([
                'message' => 'Email não encontrado'
            ], 404);
        }

        // Remover token usado
        DB::table('password_resets')
            ->where('email', $request->email)
            ->delete();

        return response()->json([
            'message' => 'Senha atualizada com sucesso'
        ]);
    }
}