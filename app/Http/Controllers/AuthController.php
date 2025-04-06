<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use App\Models\Imagem;
use App\Models\Morada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'Name' => 'required|string|max:255',
            'User_Name' => 'required|string|max:255|unique:utilizador',
            'Email' => 'required|string|email|max:255|unique:utilizador',
            'Password' => 'required|string|min:8|confirmed',
            'Data_Nascimento' => 'required|date',
            'CC' => 'required|integer|unique:utilizador',
            'comprovativo_morada' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        // Processar o upload do comprovativo de morada
        if ($request->hasFile('comprovativo_morada')) {
            $file = $request->file('comprovativo_morada');
            $filename = time() . '_' . $file->getClientOriginalName();
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
            'Status_UtilizadorID_status_utilizador' => 1, // Status padrão
            'TipoUserID_TipoUser' => 1 // Tipo de usuário padrão
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

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
}
