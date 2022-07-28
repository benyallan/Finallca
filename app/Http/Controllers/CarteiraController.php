<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarteiraRequest;
use App\Http\Requests\UpdateCarteiraRequest;
use App\Models\Carteira;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CarteiraController extends Controller
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
     * @param  \App\Http\Requests\StoreCarteiraRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarteiraRequest $request)
    {
        try {
            $carteira = Carteira::create($request->all());
            Log::info("\nUsuário: " . Auth::user() . 
                    "\nCarteira adicionada ao Banco de Dados 
                    com sucesso." .
                    json_encode($carteira) . PHP_EOL
                );
            return json_encode($carteira);
        } catch (Exception $e) {
            $exception_message = !empty($e->getMessage()) ? 
                                    trim($e->getMessage()) : 
                                    'App Error Exception';
            Log::error("\nUser: " . Auth::user() . 
                "\nError store Carteira | Request Send to: " . 
                json_encode($request->all()) . PHP_EOL .
                $exception_message . PHP_EOL . "In file " . 
                $e->getFile() . " on line " . $e->getLine() . PHP_EOL . 
                $e
            );
            return  response()->json(['status' => 'Server Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carteira  $carteira
     * @return \Illuminate\Http\Response
     */
    public function show(Carteira $carteira)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarteiraRequest  $request
     * @param  \App\Models\Carteira  $carteira
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarteiraRequest $request, Carteira $carteira)
    {
        try {
            $carteira->update($request->all());
            Log::info("\nUsuário: " . Auth::user() . 
                    "\nCarteira editada no Banco de Dados 
                    com sucesso." .
                    json_encode($carteira) . PHP_EOL
                );
            return json_encode($carteira);
        } catch (Exception $e) {
            $exception_message = !empty($e->getMessage()) ? 
                                    trim($e->getMessage()) : 
                                    'Erro na Aplicação';
            Log::error("\nUsuário: " . Auth::user() . 
                "\nErro ao editar Carteira | Request enviado: " . 
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
     * @param  \App\Models\Carteira  $carteira
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carteira $carteira)
    {
        try {
            $carteira->delete();
            Log::info("\nUsuário: " . Auth::user() . 
                    "\nCarteira apagada do Banco de Dados 
                    com sucesso." .
                    json_encode($carteira) . PHP_EOL
                );
            return response()->json([
                'message' => 'Carteira apagada com sucesso!'
            ], 200);
        } catch (Exception $e) {
            $exception_message = !empty($e->getMessage()) ? 
                                    trim($e->getMessage()) : 
                                    'Erro na Aplicação';
            Log::error("\nUsuário: " . Auth::user() . 
                "\nErro ao apagar Carteira | Request enviado: " . 
                json_encode($carteira) . PHP_EOL .
                $exception_message . PHP_EOL . "No arquivo " . 
                $e->getFile() . " na linha " . $e->getLine() . PHP_EOL . 
                $e
            );
            return  response()->json(['status' => 'Erro interno'], 500);
        }
    }

    public function get()
    {
        return Carteira::select('id','nome','saldo_inicial')
            ->orderByDesc('id')->get();
    }

    public function getSelect()
    {
        return Carteira::select('id','nome')
            ->orderBy('nome')->get();
    }
}
