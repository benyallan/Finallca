<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContaCorrenteRequest;
use App\Http\Requests\UpdateContaCorrenteRequest;
use App\Models\ContaCorrente;

class ContaCorrenteController extends Controller
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
     * @param  \App\Http\Requests\StoreContaCorrenteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContaCorrenteRequest $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContaCorrente  $contaCorrente
     * @return \Illuminate\Http\Response
     */
    public function edit(ContaCorrente $contaCorrente)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContaCorrente  $contaCorrente
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContaCorrente $contaCorrente)
    {
        //
    }
}
