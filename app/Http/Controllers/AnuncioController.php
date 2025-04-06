<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Models\Imagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnuncioController extends Controller
{
    // Listar todos os anúncios
    public function index()
    {
        // Query usando Eloquent
        $anuncios = Anuncio::with(['vendedor', 'imagens', 'categoria'])
            ->where('Status_AnuncioID_Status_Anuncio', 1) // Status Ativo
            ->inRandomOrder() // Ordem aleatória
            ->take(10) // Limita a 10 anúncios
            ->get();

        return response()->json($anuncios);
    }

    // Buscar anúncios por tipo (produto ou serviço)
    public function porTipo($tipoId)
    {
        $anuncios = Anuncio::with(['vendedor', 'imagens', 'categoria'])
            ->where('Tipo_ItemID_Tipo', $tipoId)
            ->where('Status_AnuncioID_Status_Anuncio', 1) // Status Ativo
            ->inRandomOrder() // Ordem aleatória
            ->take(6) // Limita a 6 anúncios
            ->get();

        return response()->json($anuncios);
    }

    // Buscar anúncios por termo de busca
    public function buscar(Request $request)
    {
        $termo = $request->query('q');

        if (empty($termo)) {
            return response()->json(['message' => 'Termo de busca não fornecido'], 400);
        }

        $anuncios = Anuncio::with(['vendedor', 'imagens', 'categoria'])
            ->where('Status_AnuncioID_Status_Anuncio', 1) // Apenas ativos
            ->where(function($query) use ($termo) {
                $query->where('Titulo', 'like', '%' . $termo . '%')
                      ->orWhere('Descricao', 'like', '%' . $termo . '%');
            })
            ->orderBy('ID_Anuncio', 'desc')
            ->get();

        return response()->json([
            'termo' => $termo,
            'resultados' => $anuncios,
            'total' => count($anuncios)
        ]);
    }

    // Buscar um anúncio específico
    public function show($id)
    {
        // Query usando DB facade (SQL puro)
        $anuncio = DB::select('
            SELECT a.*, u.Name as vendedor_nome, c.Descricao_Categoria
            FROM anuncio a
            JOIN utilizador u ON a.UtilizadorID_User = u.ID_User
            JOIN categoria c ON a.CategoriaID_Categoria = c.ID_Categoria
            WHERE a.ID_Anuncio = ?
        ', [$id]);

        if (empty($anuncio)) {
            return response()->json(['message' => 'Anúncio não encontrado'], 404);
        }

        // Buscar imagens do anúncio
        $imagens = DB::select('
            SELECT i.Caminho
            FROM imagem i
            JOIN item_imagem ii ON i.ID_Imagem = ii.ImagemID_Imagem
            WHERE ii.ItemID_Item = ?
        ', [$id]);

        $anuncio[0]->imagens = $imagens;

        return response()->json($anuncio[0]);
    }

    // Criar novo anúncio
    public function store(Request $request)
    {
        // Começar uma transação
        DB::beginTransaction();

        try {
            // Inserir anúncio
            $anuncioId = DB::table('anuncio')->insertGetId([
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'preco' => $request->preco,
                'UtilizadorID_User' => Auth::id(),
                'CategoriaID_Categoria' => $request->categoria,
                'Tipo_ItemID_Tipo' => $request->tipo,
                'Status_AnuncioID_Status_Anuncio' => 2 // Status Pendente
            ]);

            // Processar imagens
            if ($request->hasFile('imagens')) {
                foreach ($request->file('imagens') as $imagem) {
                    // Salvar imagem no disco
                    $path = $imagem->store('produtos', 'public');
                    
                    // Inserir registro da imagem
                    $imagemId = DB::table('imagem')->insertGetId([
                        'Caminho' => $path
                    ]);

                    // Relacionar imagem com anúncio
                    DB::table('item_imagem')->insert([
                        'ItemID_Item' => $anuncioId,
                        'ImagemID_Imagem' => $imagemId
                    ]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Anúncio criado com sucesso', 'id' => $anuncioId]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Erro ao criar anúncio', 'error' => $e->getMessage()], 500);
        }
    }

    // Atualizar anúncio
    public function update(Request $request, $id)
    {
        // Verificar se o anúncio pertence ao usuário
        $anuncio = DB::select('
            SELECT * FROM anuncio 
            WHERE ID_Anuncio = ? AND UtilizadorID_User = ?
        ', [$id, Auth::id()]);

        if (empty($anuncio)) {
            return response()->json(['message' => 'Anúncio não encontrado ou sem permissão'], 403);
        }

        // Atualizar usando SQL puro
        DB::update('
            UPDATE anuncio 
            SET titulo = ?, 
                descricao = ?, 
                preco = ?
            WHERE ID_Anuncio = ?
        ', [$request->titulo, $request->descricao, $request->preco, $id]);

        return response()->json(['message' => 'Anúncio atualizado com sucesso']);
    }

    // Deletar anúncio
    public function destroy($id)
    {
        // Soft delete - apenas muda o status para "Eliminado"
        DB::update('
            UPDATE anuncio 
            SET Status_AnuncioID_Status_Anuncio = 3 
            WHERE ID_Anuncio = ? AND UtilizadorID_User = ?
        ', [$id, Auth::id()]);

        return response()->json(['message' => 'Anúncio eliminado com sucesso']);
    }

    // Buscar anúncios por categoria
    public function porCategoria($categoriaId)
    {
        $anuncios = DB::select('
            SELECT a.*, u.Name as vendedor_nome, 
                   (SELECT Caminho FROM imagem i 
                    JOIN item_imagem ii ON i.ID_Imagem = ii.ImagemID_Imagem 
                    WHERE ii.ItemID_Item = a.ID_Anuncio LIMIT 1) as imagem_principal
            FROM anuncio a
            JOIN utilizador u ON a.UtilizadorID_User = u.ID_User
            WHERE a.CategoriaID_Categoria = ? 
            AND a.Status_AnuncioID_Status_Anuncio = 1
            ORDER BY a.ID_Anuncio DESC
        ', [$categoriaId]);

        return response()->json($anuncios);
    }

    // Remover anúncio (soft delete)
    public function destroy($id)
    {
        // Verifica se o anúncio pertence ao usuário logado
        $anuncio = Anuncio::where('ID_Anuncio', $id)
            ->where('UtilizadorID_User', Auth::id())
            ->first();

        if (!$anuncio) {
            return response()->json(['message' => 'Anúncio não encontrado'], 404);
        }

        // Soft delete - apenas muda o status para "Eliminado"
        $anuncio->Status_AnuncioID_Status_Anuncio = 3; // Status Eliminado
        $anuncio->save();

        return response()->json(['message' => 'Anúncio eliminado com sucesso']);
    }

    // Buscar anúncios por vendedor
    public function porVendedor($vendedorId)
    {
        $anuncios = DB::select('
            SELECT a.*, u.Name as vendedor_nome, 
                   (SELECT Caminho FROM imagem i 
                    JOIN item_imagem ii ON i.ID_Imagem = ii.ImagemID_Imagem 
                    WHERE ii.ItemID_Item = a.ID_Anuncio LIMIT 1) as imagem_principal
            FROM anuncio a
            JOIN utilizador u ON a.UtilizadorID_User = u.ID_User
            WHERE a.UtilizadorID_User = ? 
            AND a.Status_AnuncioID_Status_Anuncio = 1
            ORDER BY a.ID_Anuncio DESC
        ', [$vendedorId]);

        return response()->json($anuncios);
    }
}
