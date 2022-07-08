<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarteiraRequest;
use App\Http\Requests\UpdateCarteiraRequest;
use App\Models\Carteira;

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
     * @param  \App\Http\Requests\StoreCarteiraRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarteiraRequest $request)
    {
        return Carteira::create($request->all());
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
}
