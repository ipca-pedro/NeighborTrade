<?php

namespace App\Http\Controllers;

use App\Models\Utilizador;
use App\Models\Morada;
use App\Models\Imagem;
use App\Models\Aprovacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Login do utilizador
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['Email' => $credentials['email'], 'Password' => $credentials['password']])) {
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

    /**
     * Registo de novo utilizador
     */
    public function register(Request $request)
    {
        $request->validate([
            'User_Name' => 'required|string|max:255|unique:utilizador,User_Name',
            'Name' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:utilizador,Email',
            'Password' => 'required|string|min:8',
            'Password_confirmation' => 'required|same:Password',
            'Data_Nascimento' => 'required|date',
            'MoradaID_Morada' => 'required|integer|exists:morada,ID_Morada',
            'comprovativo_morada' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        DB::beginTransaction();
        
        try {
            // Usar a morada selecionada pelo utilizador
            $moradaId = $request->MoradaID_Morada;
            
            // Verificar se a morada existe
            $morada = Morada::find($moradaId);
            if (!$morada) {
                return response()->json([
                    'message' => 'Morada não encontrada'
                ], 400);
            }
            
            // Processar comprovativo de morada
            $imagemId = null;
            if ($request->hasFile('comprovativo_morada')) {
                $file = $request->file('comprovativo_morada');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/perfil', $filename);
                
                $imagem = new Imagem([
                    'Caminho' => $path
                ]);
                $imagem->save();
                $imagemId = $imagem->ID_Imagem;
            }
            
            // Verificar se temos uma imagem de perfil padrão para usar caso não tenha sido fornecida
            if (!$imagemId) {
                // Buscar a imagem padrão existente ou criar uma nova
                $imagem = Imagem::where('Caminho', 'public/perfil/default.png')->first();
                
                if (!$imagem) {
                    // Criar uma imagem padrão
                    $imagem = new Imagem([
                        'Caminho' => 'public/perfil/default.png' // Caminho para imagem padrão
                    ]);
                    $imagem->save();
                }
                
                $imagemId = $imagem->ID_Imagem;
            }
            
            // Criar utilizador sem aprovação (simplificado)
            $user = new Utilizador([
                'Name' => $request->Name,
                'User_Name' => $request->User_Name,
                'Email' => $request->Email,
                'Password' => Hash::make($request->Password),
                'Data_Nascimento' => $request->Data_Nascimento,
                'CC' => '000000000', // Valor padrão temporário
                'MoradaID_Morada' => $moradaId,
                'ImagemID_Imagem' => $imagemId,
                'AprovacaoID_aprovacao' => null, // Sem aprovação inicial
                'Status_UtilizadorID_status_utilizador' => 1, // Status pendente
                'TipoUserID_TipoUser' => 2 // Tipo utilizador normal (ID 2)
            ]);
            
            $user->save();
            
            DB::commit();
            
            $token = $user->createToken('auth-token')->plainTextToken;
            
            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'Registo realizado com sucesso'
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao registar utilizador: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout do utilizador
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
    
    /**
     * Retorna todas as moradas disponíveis para registo
     */
    public function getMoradas()
    {
        $moradas = Morada::all(['ID_Morada', 'Rua']);
        return response()->json($moradas);
    }

    /**
     * Obter dados do utilizador autenticado
     */
    public function me()
    {
        return response()->json(Auth::user());
    }
    
    // Método movido para o PerfilController
    
    /**
     * Alterar senha do utilizador
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        // Verificar senha atual
        if (!Hash::check($request->current_password, $user->Password)) {
            return response()->json([
                'message' => 'A senha atual está incorreta'
            ], 400);
        }
        
        // Atualizar senha
        $user->Password = Hash::make($request->password);
        $user->save();
        
        return response()->json([
            'message' => 'Senha alterada com sucesso'
        ]);
    }
    
    /**
     * Excluir conta do utilizador
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);
        
        $user = Auth::user();
        
        // Verificar senha
        if (!Hash::check($request->password, $user->Password)) {
            return response()->json([
                'message' => 'A senha está incorreta'
            ], 400);
        }
        
        DB::beginTransaction();
        
        try {
            // Remover tokens
            $user->tokens()->delete();
            
            // Remover utilizador
            $user->delete();
            
            DB::commit();
            
            return response()->json([
                'message' => 'Conta excluída com sucesso'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao excluir conta: ' . $e->getMessage()
            ], 500);
        }
    }
}
