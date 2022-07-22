<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartaoCreditoRequest;
use App\Http\Requests\UpdateCartaoCreditoRequest;
use App\Models\CartaoCredito;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartaoCreditoController extends Controller
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
     * @param  \App\Http\Requests\StoreCartaoCreditoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCartaoCreditoRequest $request)
    {
        try {
            $cartoescredito = CartaoCredito::create($request->all());
            $cartoescredito = CartaoCredito::select(
                'id','conta_corrente_id','nome'
                ,'dia_fechamento','dia_vencimento'
            )->with('contaCorrente:id,nome,banco,agencia,numero,obs')
            ->where('id',$cartoescredito->id)
            ->get();
            $cartoescredito->load('contaCorrente');
            Log::info("\nUsuário: " . Auth::user() . 
                    "\nCartão de Crédito adicionado ao Banco de Dados 
                    com sucesso." .
                    json_encode($cartoescredito) . PHP_EOL
                );
            return json_encode($cartoescredito);
        } catch (Exception $e) {
            $exception_message = !empty($e->getMessage()) ? 
                                    trim($e->getMessage()) : 
                                    'Erro na Aplicação';
            Log::error("\nUsuário: " . Auth::user() . 
                "\nErro ao salvar novo Cartão de Crédito | Request enviado: " . 
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
     * @param  \App\Models\CartaoCredito  $cartaoCredito
     * @return \Illuminate\Http\Response
     */
    public function show(CartaoCredito $cartaocredito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCartaoCreditoRequest  $request
     * @param  \App\Models\CartaoCredito  $cartaoCredito
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartaoCreditoRequest $request, CartaoCredito $cartoescredito)
    {
        try {
            $cartoescredito->update($request->all());
            $cartoescredito = CartaoCredito::select(
                    'id','conta_corrente_id','nome'
                    ,'dia_fechamento','dia_vencimento'
                )->with('contaCorrente:id,nome,banco,agencia,numero,obs')
                ->where('id',$cartoescredito->id)
                ->get();
            $cartoescredito->load('contaCorrente');
            Log::info("\nUsuário: " . Auth::user() . 
                    "\nCartão de Crédito editado no Banco de Dados 
                    com sucesso." .
                    json_encode($cartoescredito) . PHP_EOL
                );
            return json_encode($cartoescredito);
        } catch (Exception $e) {
            $exception_message = !empty($e->getMessage()) ? 
                                    trim($e->getMessage()) : 
                                    'Erro na Aplicação';
            Log::error("\nUsuário: " . Auth::user() . 
                "\nErro ao editar Cartão de Crédito | Request enviado: " . 
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
     * @param  \App\Models\CartaoCredito  $cartaoCredito
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartaoCredito $cartaocredito)
    {
        try {
            $cartaocredito->delete();
            Log::info("\nUsuário: " . Auth::user() . 
                    "\nCartão de Crédito apagado do Banco de Dados 
                    com sucesso." .
                    json_encode($cartaocredito) . PHP_EOL
                );
            return response()->json([
                'message' => 'Cartão de Crédito apagado com sucesso!'
            ], 200);
        } catch (Exception $e) {
            $exception_message = !empty($e->getMessage()) ? 
                                    trim($e->getMessage()) : 
                                    'Erro na Aplicação';
            Log::error("\nUsuário: " . Auth::user() . 
                "\nErro ao apagar Cartão de Crédito | Request enviado: " . 
                json_encode($cartaocredito) . PHP_EOL .
                $exception_message . PHP_EOL . "No arquivo " . 
                $e->getFile() . " na linha " . $e->getLine() . PHP_EOL . 
                $e
            );
            return  response()->json(['status' => 'Erro interno'], 500);
        }
    }

    public function get()
    {
        $cartaocredito = CartaoCredito::select(
            'id','conta_corrente_id','nome','dia_fechamento',
            'dia_vencimento'
        )->with('contaCorrente:id,nome,banco,agencia,numero,obs')
        ->orderByDesc('id')->get();
        $cartaocredito->load('contaCorrente');
        return $cartaocredito;
    }
}
