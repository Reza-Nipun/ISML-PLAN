<?php

namespace App\Http\Controllers;

use App\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = ' | Plant List';
        $plants = Plant::all();

        return view('plant.plant_list', compact('title', 'plants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = ' | Create Plant';

        return view('plant.create_plant', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'plant_code' => 'required|unique:plants',
            'status' => 'required',
        ]);

        Plant::create([
            'plant_code' => $request->plant_code,
            'plant_name' => $request->plant_name,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Plant Successfully Created!');
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
        $title = ' | Edit Plant';
        $plant = Plant::find($id);

        return view('plant.edit_plant', compact('title', 'plant'));
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
        $this->validate($request, [
            'plant_code' => 'required|unique:plants,plant_code,'.$id,
            'status' => 'required',
        ]);

        $plant = Plant::find($id);
        $plant->plant_code = $request->plant_code;
        $plant->plant_name = $request->plant_name;
        $plant->status = $request->status;
        $plant->save();

        return redirect()->back()->with('success', 'Plant Successfully Updated!');
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
