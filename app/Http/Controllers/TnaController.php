<?php

namespace App\Http\Controllers;

use App\Tna;
use App\TnaTerm;
use Illuminate\Http\Request;

class TnaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = ' | TNA List';
        $tnas = Tna::all();

        return view('tna.tna_list', compact('title', 'tnas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = ' | Create TNA';

        return view('tna.create_tna', compact('title'));
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
            'tna_name' => 'required|unique:tnas',
        ]);

        $tna_name = $request->tna_name;
        $tna_terms = $request->tna_term;
        $days = $request->days;
        $responsible_departments = $request->responsible_department;
        $tna_term_statuss = $request->tna_term_status;

        $tna = Tna::create([
            'tna_name' => $tna_name,
        ]);

        $tna_id = $tna->id;

        foreach($tna_terms as $k => $tna_term){

            $tna_term_exist = TnaTerm::where('tna_id', $tna_id)->where('tna_term', $tna_term)->get();

            if(sizeof($tna_term_exist) == 0){

                TnaTerm::create([
                    'tna_id' => $tna_id,
                    'tna_term' => $tna_term,
                    'days' => $days[$k],
                    'responsible_user_type' => $responsible_departments[$k],
                    'status' => (isset($tna_term_statuss[$k]) == '1' ? '1' : '0'),
                ]);

            }

        }

        return redirect()->back()->with('success', 'TNA Successfully Created!');
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
        $title = ' | Edit TNA';

        $tna = Tna::find($id);
        $tna_terms = TnaTerm::where('tna_id', $id)->get();

        return view('tna.edit_tna', compact('title', 'tna', 'tna_terms'));
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
            'tna_name' => 'required|unique:tnas,tna_name,'.$id,
        ]);

        $tna = Tna::find($id);
        $tna->tna_name = $request->tna_name;
        $tna->save();

//        Existing TNA Terms Update Start

        $tna_term_ids = $request->tna_term_id;
        $tna_term_olds = $request->tna_term_old;
        $days_olds = $request->days_old;
        $responsible_department_olds = $request->responsible_department_old;
        $tna_term_status_olds = $request->tna_term_status_old;

        if(!empty($tna_term_ids)){
            foreach($tna_term_ids as $k => $tna_term_id){

                $tna_term_exist = TnaTerm::where('tna_id', $id)->where('tna_term', $tna_term_olds[$k])->get();

                $tna_term_update = TnaTerm::find($tna_term_id);

                if(sizeof($tna_term_exist) == 0){
                    $tna_term_update->tna_term = $tna_term_olds[$k];
                }
                $tna_term_update->days = $days_olds[$k];
                $tna_term_update->responsible_user_type = $responsible_department_olds[$k];
                $tna_term_update->status = (isset($tna_term_status_olds[$k]) == '1' ? '1' : '0');
                $tna_term_update->save();

            }
        }
//        Existing TNA Terms Update End

//        New Additional TNA Terms Start
        $tna_terms = $request->tna_term;
        $days = $request->days;
        $responsible_departments = $request->responsible_department;
        $tna_term_statuss = $request->tna_term_status;

        if(!empty($tna_terms)) {
            foreach ($tna_terms as $k => $tna_term) {

                $tna_term_exist = TnaTerm::where('tna_id', $id)->where('tna_term', $tna_term)->get();

                if (sizeof($tna_term_exist) == 0) {

                    TnaTerm::create([
                        'tna_id' => $id,
                        'tna_term' => $tna_term,
                        'days' => $days[$k],
                        'responsible_user_type' => $responsible_departments[$k],
                        'status' => (isset($tna_term_statuss[$k]) == '1' ? '1' : '0'),
                    ]);

                }

            }
        }
//        New Additional TNA Terms End

        return redirect()->back()->with('success', 'TNA Successfully Updated!');
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
