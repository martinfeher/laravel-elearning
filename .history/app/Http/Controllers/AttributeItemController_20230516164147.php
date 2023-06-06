<?php

namespace App\Http\Controllers;

use App\Models\AttributeItem;
use App\Http\Requests\StoreAttributeItemRequest;
use App\Http\Requests\UpdateAttributeItemRequest;

class AttributeItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
    public function store(StoreAttributeItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeItem $attributeItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttributeItem $attributeItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeItemRequest $request, AttributeItem $attributeItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttributeItem $attributeItem)
    {
        //
    }
}
