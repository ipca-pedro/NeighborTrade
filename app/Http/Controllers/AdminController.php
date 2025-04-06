<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use App\Models\Anuncio;
use App\Models\Aprovacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Middleware para verificar se é admin
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->TipoUserID_TipoUser !== 1) { // 1 = Admin
                return response()->json(['message' => 'Não autorizado'], 403);
            }
            return $next($request);
        });
        $pendingUsers = Utilizador::where('Status_UtilizadorID_status_utilizador', 1) // 1 = Pendente
            ->with(['morada', 'imagem'])
            ->get();

        return response()->json($pendingUsers);
    }

    public function approveUser(Request $request, $id)
    {
        // Verificar se o usuário é admin
        if (Auth::user()->TipoUserID_TipoUser !== 2) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $user = Utilizador::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilizador não encontrado'], 404);
        }

        // 2 = Aprovado
        $user->Status_UtilizadorID_status_utilizador = 2;
        $user->save();

        return response()->json(['message' => 'Utilizador aprovado com sucesso']);
    }

    public function rejectUser(Request $request, $id)
    {
        // Verificar se o usuário é admin
        if (Auth::user()->TipoUserID_TipoUser !== 2) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $user = Utilizador::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilizador não encontrado'], 404);
        }

        // 3 = Rejeitado
        $user->Status_UtilizadorID_status_utilizador = 3;
        $user->save();

        return response()->json(['message' => 'Utilizador rejeitado com sucesso']);
    }
}
