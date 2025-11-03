<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prato;
use App\Events\PratoCriado;
use App\Events\PratoUpdated;
use Illuminate\Support\Facades\Storage;

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
            'preco_pequeno' => 'nullable|numeric',
            'category' => 'required|string|max:255',
            'period' => 'required|string|in:lunch,dinner',
            'imagem' => 'nullable|image|max:2048', // <-- NOVO: Regra para arquivo
            'imagem_url' => 'nullable|url', 
        ]);

         $url = $request->input('imagem_url'); // Assume a URL externa por padrão

    // 2. Lida com o Upload de Arquivo
    if ($request->hasFile('imagem')) {
        // Salva o arquivo no disco 'public' (storage/app/public/pratos)
        $path = $request->file('imagem')->store('pratos', 'public');
        // Gera o URL público (ex: http://localhost:8000/storage/pratos/...)
        $url = Storage::disk('public')->url($path);
        
        // Remove a URL externa, se houver, já que priorizamos o upload
        unset($dadosValidados['imagem_url']);
    }
    
    // 3. Sobrescreve a URL no array validado com a URL final
    $dadosValidados['imagem_url'] = $url;

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
            'preco_pequeno' => 'sometimes|nullable|numeric',
            'category' => 'sometimes|required|string|max:255',
            'period' => 'sometimes|required|string|in:lunch,dinner',
            'imagem' => 'nullable|image|max:2048',
            'imagem_url' => 'sometimes|nullable|string',
        ]);

        $url = $request->input('imagem_url');
        
        // 2. Lida com o Novo Upload
        if ($request->hasFile('imagem')) {
            // (Opcional: Deletar a imagem antiga)
            if ($prato->imagem_url && str_contains($prato->imagem_url, '/storage/')) {
                $oldPath = str_replace(url('storage'), '', $prato->imagem_url);
                Storage::disk('public')->delete(ltrim($oldPath, '/'));
            }

            // Salva o novo arquivo
            $path = $request->file('imagem')->store('pratos', 'public');
            $url = Storage::disk('public')->url($path);
            
            // Remove a URL externa, se houver
            unset($dadosValidados['imagem_url']);
        }
        
        // 3. Se houve upload OU se o campo imagem_url foi enviado, atualiza.
        if ($request->hasFile('imagem') || $request->has('imagem_url')) {
            $dadosValidados['imagem_url'] = $url;
        }

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

          if ($prato->imagem_url && str_contains($prato->imagem_url, '/storage/')) {
            $oldPath = str_replace(url('storage'), '', $prato->imagem_url);
            Storage::disk('public')->delete(ltrim($oldPath, '/'));
        }
        
        $prato->delete();

        // (Opcional: você pode disparar um evento PratoDeletado aqui)

        // Retorna 204 (No Content), que significa "sucesso, sem conteúdo"
        return response()->json(null, 204);
    }
}