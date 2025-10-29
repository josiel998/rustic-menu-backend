<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prato;
use App\Events\PratoCriado;
use App\Events\PratoUpdated;

class PratoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index()
{
    // Busca todos os pratos salvos no banco
    $pratos = Prato::orderBy('created_at', 'desc')->get();
    return response()->json($pratos);
}

// Função para CRIAR um novo prato (quando o formulário é enviado)
public function store(Request $request)
{
    // Validação (opcional, mas recomendado)
  $dadosValidados = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric', // Campo 'preco' (Português)
            'category' => 'required|string|max:255',
            'period' => 'required|string|in:lunch,dinner',
            // 'imagem_url' => 'nullable|string', // Descomente se precisar
        ]);

    // Cria e salva o prato no banco de dados
$prato = Prato::create($dadosValidados);
    
        // Dispara o evento (como você já tinha)
        broadcast(new PratoCriado($prato))->toOthers();

        return response()->json($prato, 201);
    }
    /**
     * Display the specified resource.
     */
public function show(Prato $prato)
    {
        // (Não precisamos desta função por enquanto)
        return response()->json($prato);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prato $prato)
    {
        // 1. Valida os dados (mesmas regras do store, mas 'nome' pode ser opcional
        // se você não quiser forçar a mudança dele toda vez. Usar 'sometimes')
        $dadosValidados = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'sometimes|nullable|string',
            'preco' => 'sometimes|required|numeric',
            'category' => 'sometimes|required|string|max:255',
            'period' => 'sometimes|required|string|in:lunch,dinner',
            'imagem_url' => 'sometimes|nullable|string',
        ]);

        // 2. Atualiza o prato no banco
        $prato->update($dadosValidados);

        // 3. Dispara o evento de update para o WebSocket
        broadcast(new PratoUpdated($prato))->toOthers();

        // 4. Retorna o prato atualizado
        return response()->json($prato);
    }

    /**
     * Remove the specified resource from storage.
     */
    // NOVO: Função de deletar implementada
    public function destroy(Prato $prato)
    {
        // O Laravel automaticamente encontra o Prato pelo ID
        // ou retorna 404 se não achar (Route Model Binding)
        
        $prato->delete();

        // (Opcional: você pode disparar um evento PratoDeletado aqui)

        // Retorna 204 (No Content), que significa "sucesso, sem conteúdo"
        return response()->json(null, 204);
    }
}