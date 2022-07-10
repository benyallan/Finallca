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
        return view('carteiras.carteiras');
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
            return Carteira::create($request->all());
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carteira  $carteira
     * @return \Illuminate\Http\Response
     */
    public function edit(Carteira $carteira)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carteira  $carteira
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carteira $carteira)
    {
        //
    }

    public function get()
    {
        return Carteira::select('nome','saldo_inicial')->get();
    }
}
