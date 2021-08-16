<?php

namespace App\Http\Controllers;

use App\Buyer;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = ' | Buyer List';
        $buyers = Buyer::all();

        return view('buyer.buyer_list', compact('title', 'buyers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = ' | Create Buyer';

        return view('buyer.create_buyer', compact('title'));
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
            'buyer_name' => 'required|unique:buyers',
            'status' => 'required',
        ]);

        Buyer::create([
            'buyer_name' => $request->buyer_name,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Buyer Successfully Created!');
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
        $title = ' | Edit Buyer';
        $buyer = Buyer::find($id);

        return view('buyer.edit_buyer', compact('title', 'buyer'));
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
            'buyer_name' => 'required|unique:buyers,buyer_name,'.$id,
            'status' => 'required',
        ]);

        $buyer = Buyer::find($id);
        $buyer->buyer_name = $request->buyer_name;
        $buyer->status = $request->status;
        $buyer->save();

        return redirect()->back()->with('success', 'Buyer Successfully Updated!');
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
