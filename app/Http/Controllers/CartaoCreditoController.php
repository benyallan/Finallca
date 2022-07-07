<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartaoCreditoRequest;
use App\Http\Requests\UpdateCartaoCreditoRequest;
use App\Models\CartaoCredito;

class CartaoCreditoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCartaoCreditoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCartaoCreditoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartaoCredito  $cartaoCredito
     * @return \Illuminate\Http\Response
     */
    public function show(CartaoCredito $cartaoCredito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CartaoCredito  $cartaoCredito
     * @return \Illuminate\Http\Response
     */
    public function edit(CartaoCredito $cartaoCredito)
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
    public function update(UpdateCartaoCreditoRequest $request, CartaoCredito $cartaoCredito)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartaoCredito  $cartaoCredito
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartaoCredito $cartaoCredito)
    {
        //
    }
}
