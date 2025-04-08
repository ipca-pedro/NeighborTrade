<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use App\Models\TipoNotificacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificacaoController extends Controller
{
    /**
     * Listar todas as notificações do utilizador autenticado
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Notificacao::with(['tipo_notificacao', 'referenciatipo'])
            ->where('UtilizadorID_User', $user->ID_User)
            ->orderBy('DataNotificacao', 'desc');
            
        // Filtrar por tipo de notificação (opcional)
        if ($request->has('tipo')) {
            $query->where('TIpo_notificacaoID_TipoNotificacao', $request->tipo);
        }
        
        // Filtrar por data (opcional)
        if ($request->has('data')) {
            $query->whereDate('DataNotificacao', $request->data);
        }
        
        $notificacoes = $query->paginate(10);
        
        return response()->json($notificacoes);
    }
    
    /**
     * Obter uma notificação específica
     */
    public function show($id)
    {
        $user = Auth::user();
        
        $notificacao = Notificacao::with(['tipo_notificacao', 'referenciatipo'])
            ->where('ID_Notificacao', $id)
            ->where('UtilizadorID_User', $user->ID_User)
            ->first();
            
        if (!$notificacao) {
            return response()->json(['message' => 'Notificação não encontrada'], 404);
        }
        
        // Registar visualização
        // Como não temos o campo 'Lida', podemos usar um campo de status ou
        // simplesmente retornar a notificação sem marcar como lida
        
        return response()->json($notificacao);
    }
    
    /**
     * Registar visualização da notificação
     */
    public function registarVisualizacao($id)
    {
        $user = Auth::user();
        
        $notificacao = Notificacao::where('ID_Notificacao', $id)
            ->where('UtilizadorID_User', $user->ID_User)
            ->first();
            
        if (!$notificacao) {
            return response()->json(['message' => 'Notificação não encontrada'], 404);
        }
        
        // Como não temos campo 'Lida', podemos armazenar essa informação em cache ou em uma sessão
        // Ou simplesmente retornar sucesso e deixar o frontend gerenciar o estado de visualização
        
        return response()->json(['message' => 'Notificação visualizada com sucesso']);
    }
    
    /**
     * Marcar todas as notificações como vistas
     */
    public function marcarTodasVistas()
    {
        $user = Auth::user();
        
        // Como não temos campo 'Lida', podemos armazenar essa informação em cache ou em uma sessão
        // Ou simplesmente retornar sucesso e deixar o frontend gerenciar o estado de visualização
        
        // Obter IDs de todas as notificações do usuário
        $notificacoes = Notificacao::where('UtilizadorID_User', $user->ID_User)
            ->pluck('ID_Notificacao')
            ->toArray();
        
        return response()->json([
            'message' => 'Todas as notificações foram marcadas como vistas',
            'notificacoes' => $notificacoes
        ]);
    }
    
    /**
     * Excluir uma notificação
     */
    public function destroy($id)
    {
        $user = Auth::user();
        
        $notificacao = Notificacao::where('ID_Notificacao', $id)
            ->where('UtilizadorID_User', $user->ID_User)
            ->first();
            
        if (!$notificacao) {
            return response()->json(['message' => 'Notificação não encontrada'], 404);
        }
        
        $notificacao->delete();
        
        return response()->json(['message' => 'Notificação excluída com sucesso']);
    }
    
    /**
     * Excluir notificações antigas
     */
    public function limparNotificacoesAntigas(Request $request)
    {
        $user = Auth::user();
        $diasAntigos = $request->dias ?? 30; // Padrão: 30 dias
        
        $dataLimite = Carbon::now()->subDays($diasAntigos);
        
        $count = Notificacao::where('UtilizadorID_User', $user->ID_User)
            ->where('DataNotificacao', '<', $dataLimite)
            ->delete();
            
        return response()->json([
            'message' => 'Notificações antigas excluídas com sucesso',
            'quantidade' => $count
        ]);
    }
    
    /**
     * Criar uma notificação (método interno para uso por outros controllers)
     */
    public static function criarNotificacao($userId, $tipoId, $mensagem, $referenciaId = null, $referenciaTipoId = null)
    {
        try {
            $notificacao = new Notificacao([
                'Mensagem' => $mensagem,
                'DataNotificacao' => Carbon::now(),
                'ReferenciaID' => $referenciaId,
                'UtilizadorID_User' => $userId,
                'ReferenciaTipoID_ReferenciaTipo' => $referenciaTipoId,
                'TIpo_notificacaoID_TipoNotificacao' => $tipoId
            ]);
            
            $notificacao->save();
            return $notificacao;
            
        } catch (\Exception $e) {
            \Log::error('Erro ao criar notificação: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Obter contagem de notificações recentes
     */
    public function contarRecentes(Request $request)
    {
        $user = Auth::user();
        $diasRecentes = $request->dias ?? 7; // Padrão: últimos 7 dias
        
        $dataLimite = Carbon::now()->subDays($diasRecentes);
        
        $count = Notificacao::where('UtilizadorID_User', $user->ID_User)
            ->where('DataNotificacao', '>=', $dataLimite)
            ->count();
            
        return response()->json(['count' => $count]);
    }
}
