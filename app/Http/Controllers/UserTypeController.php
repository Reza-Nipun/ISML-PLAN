<?php

namespace App\Http\Controllers;

use App\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = ' | User Types';
        $user_types = UserType::all();

        return view('user_types.user_type_list', compact('title', 'user_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = ' | Create User-Type';

        return view('user_types.create_user_type', compact('title'));
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
            'user_type' => 'required|unique:user_types',
        ]);

        $user_type = new UserType();
        $user_type->user_type = $request->user_type;
        $user_type->save();

        return redirect()->back()->with('success', 'User-Type Successfully Created!');
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
        $title = ' | Edit User-Type';
        $user_type = UserType::find($id);

        return view('user_types.edit_user_type', compact('title', 'user_type'));
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
            'user_type' => 'required|unique:user_types,user_type,'.$id,
        ]);

        $user_type = UserType::find($id);
        $user_type->user_type = $request->user_type;
        $user_type->save();

        return redirect()->back()->with('success', 'User-Type Successfully Updated!');
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
