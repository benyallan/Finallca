<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContaCorrenteRequest;
use App\Http\Requests\UpdateContaCorrenteRequest;
use App\Models\ContaCorrente;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContaCorrenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contas_corrente.ContasCorrente');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContaCorrenteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContaCorrenteRequest $request)
    {
        try {
            $contacorrente = ContaCorrente::create($request->all());
            return json_encode($contacorrente);
            Log::info("\nUsuário: " . Auth::user() . 
                    "\nConta Corrente adicionada ao Banco de Dados 
                    com sucesso." .
                    json_encode($contacorrente) . PHP_EOL
                );
        } catch (Exception $e) {
            $exception_message = !empty($e->getMessage()) ? 
                                    trim($e->getMessage()) : 
                                    'Erro na Aplicação';
            Log::error("\nUsuário: " . Auth::user() . 
                "\nErro ao salvar nova Conte Corrente | Request enviado: " . 
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
     * @param  \App\Models\ContaCorrente  $contaCorrente
     * @return \Illuminate\Http\Response
     */
    public function show(ContaCorrente $contaCorrente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContaCorrenteRequest  $request
     * @param  \App\Models\ContaCorrente  $contaCorrente
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContaCorrenteRequest $request, ContaCorrente $contaCorrente)
    {
        try {
            $contaCorrente->update($request->all());
            return json_encode($contaCorrente);
            Log::info("\nUsuário: " . Auth::user() . 
                    "\nConta Corrente editada no Banco de Dados 
                    com sucesso." .
                    json_encode($contaCorrente) . PHP_EOL
                );
        } catch (Exception $e) {
            $exception_message = !empty($e->getMessage()) ? 
                                    trim($e->getMessage()) : 
                                    'Erro na Aplicação';
            Log::error("\nUsuário: " . Auth::user() . 
                "\nErro ao editar Conta Corrente | Request enviado: " . 
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
     * @param  \App\Models\ContaCorrente  $contaCorrente
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContaCorrente $contaCorrente)
    {
        try {
            $contaCorrente->delete();
            return response()->json([
                'message' => 'Conta corrente apagada com sucesso!'
            ], 200);
            Log::info("\nUsuário: " . Auth::user() . 
                    "\nConta Corrente apagada do Banco de Dados 
                    com sucesso." .
                    json_encode($contaCorrente) . PHP_EOL
                );
        } catch (Exception $e) {
            $exception_message = !empty($e->getMessage()) ? 
                                    trim($e->getMessage()) : 
                                    'Erro na Aplicação';
            Log::error("\nUsuário: " . Auth::user() . 
                "\nErro ao apagar Conta Corrente | Request enviado: " . 
                json_encode($contaCorrente) . PHP_EOL .
                $exception_message . PHP_EOL . "No arquivo " . 
                $e->getFile() . " na linha " . $e->getLine() . PHP_EOL . 
                $e
            );
            return  response()->json(['status' => 'Erro interno'], 500);
        }
    }

    public function get()
    {
        return ContaCorrente::select(
            'id','banco','agencia','numero','nome','obs','saldo_inicial'
        )->get();
    }
}
