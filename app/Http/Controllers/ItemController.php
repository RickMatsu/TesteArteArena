<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Retorna os itens com filtro de título e paginação.
     */
    public function index(Request $request)
    {
        // Busca pelo título, se fornecido
        $query = Item::query();
        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        $perPage = $request->get('per_page', 10); // Padrão: 10 itens por página
        $items = Item::paginate($perPage);
        return response()->json($items);
    }

    /**
     * Adiciona um novo item.
     */
    public function store(Request $request)
    {
        // Valida os dados recebidos
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Cria o item no banco de dados
        $item = Item::create($validated);

        return response()->json($item, 201); // Retorna com status 201 (Created)
    }

    // Exibir um item específico
    public function show($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        return response()->json($item);
    }

    // Atualizar um item
    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $item->update($validated);
        return response()->json($item);
    }

    // Excluir um item
    public function destroy($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->delete();
        return response()->json(['message' => 'Item deleted successfully']);
    }
}
