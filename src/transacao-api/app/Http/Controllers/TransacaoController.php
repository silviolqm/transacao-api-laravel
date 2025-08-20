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

        $data['user_id'] = auth()->id();

        if ($request->hasFile('documento')) {
            $path = $request->file('documento')->store('documentos', 'public');
            $data['documento_path'] = $path;
        }

        $transacao = Transacao::create($data);

        return new TransacaoResource($transacao);
    }

    public function show(Transacao $transacao)
    {
        return new TransacaoResource($transacao);
    }

    public function update(Request $request, Transacao $transacao)
    {
        $data = $request->validate([
            'valor' => ['sometimes','required', 'numeric', 'min:0.01'],
            'cpf' => ['sometimes', 'required', 'string', 'max:14'],
            'documento_path' => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:2048'],
            'status' => ['sometimes', 'required', Rule::in(['Em processamento', 'Aprovada', 'Negada'])],
        ]);

        if ($request->hasFile('documento')) {
            //Apaga o arquivo antigo
            if ($transacao->documento_path) {
                Storage::disk('public')->delete($transacao->documento_path);
            }
            //Salva o novo arquivo
            $path = $request->file('documento')->store('documentos', 'public');
            $data['documento_path'] = $path;
        }

        $transacao->update($data);

        return new TransacaoResource($transacao);
    }

    public function destroy(Transacao $transacao)
    {
        $transacao->delete();

        return response()->noContent();
    }
}
