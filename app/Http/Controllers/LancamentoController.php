<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLancamentoRequest;
use App\Http\Requests\UpdateLancamentoRequest;
use App\Library\FormaPagamento;
use App\Models\Carteira;
use App\Models\Lancamento;
use App\Models\Parcela;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LancamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLancamentoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLancamentoRequest $request)
    {
        try {
            $classname = FormaPagamento::formaPagamento(
                (string) $request->formaPagamento["classe"]
            );
            $class = new Carteira();
            eval("\$class = \"$classname\"::find(\$request->formaPagamento['id']);");
            $lancamento = Lancamento::create($request->all());
            if ($request->parcela) {
                $parcela = new Parcela($request->parcela);
                $lancamento->parcelas()->save($parcela);
                $class->lancamentos()->save($parcela);
            } elseif ($request->parcelas) {
                foreach ($request->parcelas as $parcela) {
                    $lancamento->parcelas()->save(
                        new Parcela($parcela)
                    );
                }
            }
            Log::info("\nUsuário: " . Auth::user() . 
                    "\nLançamento adicionado ao Banco de Dados 
                    com sucesso." .
                    json_encode($lancamento) . PHP_EOL
                );
            return json_encode($lancamento);
        } catch (Exception $e) {
            $exception_message = !empty($e->getMessage()) ? 
                                    trim($e->getMessage()) : 
                                    'Erro na Aplicação';
            Log::error("\nUsuário: " . Auth::user() . 
                "\nErro ao salvar novo Lançamento | Request enviado: " . 
                json_encode($request->all()) . PHP_EOL .
                $exception_message . PHP_EOL . "No arquivo " . 
                $e->getFile() . " na linha " . $e->getLine() . PHP_EOL . 
                $e
            );
            return  response()->json(['status' => 'Erro interno'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function show(Lancamento $lancamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLancamentoRequest  $request
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLancamentoRequest $request, Lancamento $lancamento)
    {
        try {
            $lancamento->update($request->all());
            Log::info("\nUsuário: " . Auth::user() . 
                    "\nLançamento editado no Banco de Dados 
                    com sucesso." .
                    json_encode($lancamento) . PHP_EOL
                );
            return json_encode($lancamento);
        } catch (Exception $e) {
            $exception_message = !empty($e->getMessage()) ? 
                                    trim($e->getMessage()) : 
                                    'Erro na Aplicação';
            Log::error("\nUsuário: " . Auth::user() . 
                "\nErro ao editar Lançamento | Request enviado: " . 
                json_encode($request->all()) . PHP_EOL .
                $exception_message . PHP_EOL . "No arquivo " . 
                $e->getFile() . " na linha " . $e->getLine() . PHP_EOL . 
                $e
            );
            return  response()->json(['status' => 'Erro interno'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lancamento $lancamento)
    {
        try {
            $lancamento->delete();
            Log::info("\nUsuário: " . Auth::user() . 
                    "\nLançamento apagado do Banco de Dados 
                    com sucesso." .
                    json_encode($lancamento) . PHP_EOL
                );
            return response()->json([
                'message' => 'Lançamento apagado com sucesso!'
            ], 200);
        } catch (Exception $e) {
            $exception_message = !empty($e->getMessage()) ? 
                                    trim($e->getMessage()) : 
                                    'Erro na Aplicação';
            Log::error("\nUsuário: " . Auth::user() . 
                "\nErro ao apagar Lançamento | Request enviado: " . 
                json_encode($lancamento) . PHP_EOL .
                $exception_message . PHP_EOL . "No arquivo " . 
                $e->getFile() . " na linha " . $e->getLine() . PHP_EOL . 
                $e
            );
            return  response()->json(['status' => 'Erro interno'], 500);
        }
    }

    public function get()
    {
        return Parcela::select(
            'id','lancamento_id','forma_pagamento_type','forma_pagamento_id',
            'valor','data_pagamento','data_vencimento','numero','tipo',
            'total','periodo','obs'
        )
        ->with(
                'lancamento:id,descricao,valorTotal,data,obs',
                'formaPagamento'
            )
        ->orderByDesc('id')->get();
    }
}
