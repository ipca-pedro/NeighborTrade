<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use App\Models\Morada;
use App\Models\Imagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    /**
     * Obter dados do perfil do utilizador autenticado
     */
    public function show()
    {
        $user = Auth::user();
        
        // Carregar relacionamentos
        $user->load(['morada', 'imagem', 'tipouser', 'status_utilizador']);
        
        return response()->json([
            'user' => $user
        ]);
    }
    
    /**
     * Atualizar dados básicos do perfil
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'user_name' => 'sometimes|string|max:255|unique:utilizador,User_Name,' . $user->ID_User . ',ID_User',
            'email' => 'sometimes|string|email|max:255|unique:utilizador,Email,' . $user->ID_User . ',ID_User',
        ]);
        
        // Atualizar dados do utilizador
        if ($request->has('name')) {
            $user->Name = $request->name;
        }
        
        if ($request->has('user_name')) {
            $user->User_Name = $request->user_name;
        }
        
        if ($request->has('email')) {
            $user->Email = $request->email;
        }
        
        $user->save();
        
        return response()->json([
            'message' => 'Perfil atualizado com sucesso',
            'user' => $user
        ]);
    }
    
    /**
     * Atualizar morada do utilizador
     */
    public function updateMorada(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'rua' => 'required|string|max:255',
        ]);
        
        DB::beginTransaction();
        
        try {
            $morada = Morada::find($user->MoradaID_Morada);
            
            if ($morada) {
                $morada->Rua = $request->rua;
                $morada->save();
            } else {
                // Criar nova morada se não existir
                $morada = new Morada([
                    'Rua' => $request->rua
                ]);
                $morada->save();
                
                $user->MoradaID_Morada = $morada->ID_Morada;
                $user->save();
            }
            
            DB::commit();
            
            return response()->json([
                'message' => 'Morada atualizada com sucesso',
                'morada' => $morada
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar morada: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Atualizar foto de perfil
     */
    public function updateFotoPerfil(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'foto_perfil' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        DB::beginTransaction();
        
        try {
            $file = $request->file('foto_perfil');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/perfil', $filename);
            
            // Se já existe imagem, atualiza
            if ($user->ImagemID_Imagem) {
                $imagem = Imagem::find($user->ImagemID_Imagem);
                if ($imagem) {
                    // Remover imagem antiga se existir e não for a imagem padrão
                    if ($imagem->Caminho && !str_contains($imagem->Caminho, 'default.png')) {
                        Storage::delete($imagem->Caminho);
                    }
                    $imagem->Caminho = $path;
                    $imagem->save();
                }
            } else {
                // Criar nova imagem
                $imagem = new Imagem([
                    'Caminho' => $path
                ]);
                $imagem->save();
                $user->ImagemID_Imagem = $imagem->ID_Imagem;
                $user->save();
            }
            
            DB::commit();
            
            return response()->json([
                'message' => 'Foto de perfil atualizada com sucesso',
                'imagem_url' => Storage::url($path)
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar foto de perfil: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obter histórico de anúncios do utilizador
     */
    public function historicoAnuncios()
    {
        $user = Auth::user();
        
        $anuncios = $user->anuncios()
            ->with(['categoria', 'imagens', 'status_anuncio'])
            ->orderBy('ID_Anuncio', 'desc')
            ->get();
        
        return response()->json([
            'anuncios' => $anuncios,
            'total' => count($anuncios)
        ]);
    }
}
