<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParcelaRequest;
use App\Http\Requests\UpdateParcelaRequest;
use App\Models\Parcela;

class ParcelaController extends Controller
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
     * @param  \App\Http\Requests\StoreParcelaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreParcelaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parcela  $parcela
     * @return \Illuminate\Http\Response
     */
    public function show(Parcela $parcela)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parcela  $parcela
     * @return \Illuminate\Http\Response
     */
    public function edit(Parcela $parcela)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateParcelaRequest  $request
     * @param  \App\Models\Parcela  $parcela
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateParcelaRequest $request, Parcela $parcela)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parcela  $parcela
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parcela $parcela)
    {
        //
    }
}
