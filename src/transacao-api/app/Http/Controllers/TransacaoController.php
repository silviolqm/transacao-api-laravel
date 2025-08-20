<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransacaoResource;
use App\Models\Transacao;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class TransacaoController extends Controller
{
    public function index()
    {
        return TransacaoResource::collection(Transacao::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'valor' => ['required', 'numeric', 'min:0.01'],
            'cpf' => ['required', 'string', 'max:14'],
            'documento' => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            'status' => ['required', Rule::in(['Em processamento', 'Aprovada', 'Negada'])],
        ]);

        if ($request->hasFile('documento')) {
            $path = $request->file('documento')->store('documentos', 'public');
            $data['documento_path'] = $path;
        }

        $transacao = $request->user()->transacoes()->create($data);

        return new TransacaoResource($transacao);
    }

    public function show(Request $request, string $id)
    {
        $transacao = $request->user()->transacoes()->findOrFail($id);
        return new TransacaoResource($transacao);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'valor' => ['sometimes','required', 'numeric', 'min:0.01'],
            'cpf' => ['sometimes', 'required', 'string', 'max:14'],
            'documento' => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            'status' => ['sometimes', 'required', Rule::in(['Em processamento', 'Aprovada', 'Negada'])],
        ]);

        $transacao = $request->user()->transacoes()->findOrFail($id);

        if ($request->hasFile('documento')) {
            //Apaga o arquivo antigo
            if ($transacao->documento_path) {
                Storage::disk('public')->delete($transacao->documento_path);
            }
            //Salva o novo arquivo
            $path = $request->file('documento')->store('documentos', 'public');
            $data['documento_path'] = $path;
        }

        // Remove 'documento' do array de dados para o banco
        unset($data['documento']);

        // Se nada chegou, retorna 422
        if (empty($data)) {
            return response()->json([
                'message' => 'Nenhum campo válido enviado. Use pelo menos um de: valor, cpf, status, documento'
            ], 422);
        }

        $transacao->update($data);

        return new TransacaoResource($transacao);
    }

    public function destroy(Request $request, string $id)
    {
        //$transacao->delete();
        //$request->user()->transacoes()->delete($transacao);
        $transacaoToDelete = $request->user()->transacoes()->findOrFail($id);
        $transacaoToDelete->delete();

        return response()->noContent();
    }
}
