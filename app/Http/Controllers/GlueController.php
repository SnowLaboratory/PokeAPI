<?php

namespace App\Http\Controllers;

use App\Models\Glue;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GlueController extends Controller
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

    public function names(Request $request) {
        $names = Glue::where('base_type', $request->input('base_type'))
            ->where('base_id', $request->input('base_id'))
            ->where('foreign_id', $request->input('foreign_id'))
            ->where('foreign_type', $request->input('foreign_type'))
            ->pluck('name');

        return response()->json($names);
    }

    public function fetch(Request $request) {
        $glue = Glue::where('base_type', $request->input('base_type'))
            ->where('base_id', $request->input('base_id'))
            ->where('foreign_id', $request->input('foreign_id'))
            ->where('foreign_type', $request->input('foreign_type'))
            ->where('name', $request->input('name'))
            ->first();

        return response()->json(json_decode($glue?->data));
    }

    public function save(Request $request) {
        $glue = Glue::updateOrCreate([
            'name' => $request->input('name'),
            'base_id' => $request->input('base_id'),
            'base_type' => $request->input('base_type'),
            'foreign_id' => $request->input('foreign_id'),
            'foreign_type' => $request->input('foreign_type'),
        ], [
            'data' => $request->input('json'),
        ]);

        return response()->json($glue);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Glue');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
