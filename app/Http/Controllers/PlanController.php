<?php

namespace App\Http\Controllers;

use App\Models\plan;
use App\Http\Requests\StoreplanRequest;
use App\Http\Requests\UpdateplanRequest;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreplanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateplanRequest $request, plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(plan $plan)
    {
        //
    }
}
