<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BikeType;
use App\Services\BikeTypeService;
use Illuminate\Http\Request;

class BikeTypeController extends Controller
{
    public function __construct(public BikeTypeService $bikeTypeService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bikeTypes = $this->bikeTypeService->all($request->except('_token'));

        return view('admin.bike-type.index', compact('bikeTypes'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BikeType $bikeType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BikeType $bikeType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BikeType $bikeType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BikeType $bikeType)
    {
        //
    }
}
