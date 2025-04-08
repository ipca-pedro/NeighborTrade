<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\ImagemProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    // Listar todos os produtos aprovados
    public function index()
    {
        $produtos = Produto::with(['vendedor', 'imagens'])
            ->where('Status', 'aprovado')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($produtos);
    }

    // Listar produtos pendentes (para admin)
    public function listPendentes()
    {
        $produtos = Produto::with(['vendedor', 'imagens'])
            ->where('Status', 'pendente')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($produtos);
    }

    // Buscar produto por ID
    public function show($id)
    {
        $produto = Produto::with(['vendedor', 'imagens'])->findOrFail($id);
        return response()->json($produto);
    }

    // Criar novo produto
    public function store(Request $request)
    {
        $request->validate([
            'Nome' => 'required|string|max:255',
            'Descricao' => 'required|string',
            'Preco' => 'required|numeric|min:0',
            'Categoria' => 'required|string|max:255',
            'Condicao' => 'required|in:novo,usado,seminovo',
            'imagens.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $produto = Produto::create([
            'Nome' => $request->Nome,
            'Descricao' => $request->Descricao,
            'Preco' => $request->Preco,
            'Categoria' => $request->Categoria,
            'Condicao' => $request->Condicao,
            'Status' => 'pendente',
            'UtilizadorID_User' => Auth::id()
        ]);

        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $index => $imagem) {
                $path = $imagem->store('produtos', 'public');
                
                ImagemProduto::create([
                    'ProdutoID_Produto' => $produto->ID_Produto,
                    'Url' => $path,
                    'Principal' => $index === 0 // primeira imagem é a principal
                ]);
            }
        }

        return response()->json([
            'message' => 'Produto criado com sucesso',
            'produto' => $produto
        ], 201);
    }

    // Atualizar produto
    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        // Verificar se o usuário é dono do produto
        if ($produto->UtilizadorID_User !== Auth::id()) {
            return response()->json([
                'message' => 'Não autorizado'
            ], 403);
        }

        $request->validate([
            'Nome' => 'string|max:255',
            'Descricao' => 'string',
            'Preco' => 'numeric|min:0',
            'Categoria' => 'string|max:255',
            'Condicao' => 'in:novo,usado,seminovo',
            'imagens.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $produto->update($request->only([
            'Nome', 'Descricao', 'Preco', 'Categoria', 'Condicao'
        ]));

        if ($request->hasFile('imagens')) {
            // Remover imagens antigas
            foreach ($produto->imagens as $imagem) {
                Storage::disk('public')->delete($imagem->Url);
                $imagem->delete();
            }

            // Adicionar novas imagens
            foreach ($request->file('imagens') as $index => $imagem) {
                $path = $imagem->store('produtos', 'public');
                
                ImagemProduto::create([
                    'ProdutoID_Produto' => $produto->ID_Produto,
                    'Url' => $path,
                    'Principal' => $index === 0
                ]);
            }
        }

        return response()->json([
            'message' => 'Produto atualizado com sucesso',
            'produto' => $produto
        ]);
    }

    // Aprovar produto (admin)
    public function aprovar($id)
    {
        $produto = Produto::findOrFail($id);
        $produto->update(['Status' => 'aprovado']);

        return response()->json([
            'message' => 'Produto aprovado com sucesso'
        ]);
    }

    // Rejeitar produto (admin)
    public function rejeitar($id)
    {
        $produto = Produto::findOrFail($id);
        $produto->update(['Status' => 'rejeitado']);

        return response()->json([
            'message' => 'Produto rejeitado com sucesso'
        ]);
    }

    // Excluir produto
    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);

        // Verificar se o usuário é dono do produto
        if ($produto->UtilizadorID_User !== Auth::id()) {
            return response()->json([
                'message' => 'Não autorizado'
            ], 403);
        }

        // Remover imagens do storage
        foreach ($produto->imagens as $imagem) {
            Storage::disk('public')->delete($imagem->Url);
        }

        $produto->delete();

        return response()->json([
            'message' => 'Produto excluído com sucesso'
        ]);
    }
}
