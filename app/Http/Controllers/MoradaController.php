<?php

namespace App\Http\Controllers;

use App\Models\Morada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class MoradaController extends Controller
{
    /**
     * Método de teste para verificar se a API está funcionando
     */
    public function test()
    {
        return response()->json(['message' => 'API funcionando corretamente']);
    }
    /**
     * Retorna todas as moradas disponíveis
     */
    public function index()
    {
        try {
            // Verificar se a tabela existe
            if (!Schema::hasTable('morada')) {
                return response()->json(['error' => 'Tabela morada não encontrada'], 500);
            }
            
            // Obter todas as moradas
            $moradas = Morada::all(['ID_Morada', 'Rua']);
            
            // Retornar as moradas
            return response()->json($moradas);
        } catch (\Exception $e) {
            // Retornar erro
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Adiciona uma nova morada
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'Rua' => 'required|string|max:255',
            ]);

            $morada = new Morada();
            $morada->Rua = $request->Rua;
            $morada->save();

            return response()->json($morada, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
