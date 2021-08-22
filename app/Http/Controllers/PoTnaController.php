<?php

namespace App\Http\Controllers;

use App\Buyer;
use App\Plant;
use App\Po;
use App\PoTna;
use App\Tna;
use App\TnaTerm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PoTnaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = ' | PO-TNA Tasks';
        $plants = Plant::all();
        $buyers = Buyer::all();
        $pos = Po::all();

        $query = DB::table('po_tnas')
            ->Join('pos', 'pos.id', '=', 'po_tnas.po_id')
            ->Join('tnas', 'tnas.id', '=', 'po_tnas.tna_id')
            ->Join('tna_terms', 'tna_terms.id', '=', 'po_tnas.tna_term_id')
            ->Join('plants', 'plants.id', '=', 'pos.plant_id')
            ->Join('buyers', 'buyers.id', '=', 'pos.buyer_id')
            ->select('po_tnas.*', 'pos.po', 'pos.destination', 'pos.quality',
                'pos.color', 'pos.style_no', 'pos.style_name', 'pos.ship_date', 'pos.po_type',
                'tnas.tna_name', 'tna_terms.tna_term', 'plants.plant_name', 'buyers.buyer_name')
            ->whereNull('po_tnas.actual_tna_date')
            ->orderBy('po_tnas.plan_tna_date', 'ASC');

        if (!empty(auth()->user()->user_type)) {
            $query = $query->where('tna_terms.responsible_user_type', auth()->user()->user_type);
        }

        $po_tnas = $query->get();


        return view('po_tna.po_tna_list', compact('title', 'buyers', 'plants', 'po_tnas', 'pos'));
    }


    public function searchPoTnaTasks(Request $request){
        $plant_id = $request->plant_id;
        $buyer_id = $request->buyer_id;
        $po_id = $request->po_filter;
        $ship_date_from = $request->ship_date_from;
        $ship_date_to = $request->ship_date_to;

        $query = DB::table('po_tnas')
                ->Join('pos', 'pos.id', '=', 'po_tnas.po_id')
                ->Join('tnas', 'tnas.id', '=', 'po_tnas.tna_id')
                ->Join('tna_terms', 'tna_terms.id', '=', 'po_tnas.tna_term_id')
                ->Join('plants', 'plants.id', '=', 'pos.plant_id')
                ->Join('buyers', 'buyers.id', '=', 'pos.buyer_id')
                ->select('po_tnas.*', 'pos.po', 'pos.destination', 'pos.quality',
                    'pos.color', 'pos.style_no', 'pos.style_name', 'pos.ship_date', 'pos.po_type',
                    'tnas.tna_name', 'tna_terms.tna_term', 'plants.plant_name', 'buyers.buyer_name')
                ->whereNull('po_tnas.actual_tna_date')
                ->orderBy('po_tnas.plan_tna_date', 'ASC');

        if (!empty(auth()->user()->user_type)) {
            $query = $query->where('tna_terms.responsible_user_type', auth()->user()->user_type);
        }

        if ($po_id!=null) {
            $query = $query->where('po_tnas.po_id', $po_id);
        }

        if ($plant_id!=null) {
            $query = $query->where('pos.plant_id', $plant_id);
        }

        if ($buyer_id!=null) {
            $query = $query->where('pos.buyer_id', $buyer_id);
        }

        if (($ship_date_from!=null) && ($ship_date_to!=null)) {
            $query = $query->whereBetween('pos.ship_date', [$ship_date_from, $ship_date_to]);
        }

        $po_tnas = $query->get();

        return view('po_tna.po_tna_terms_filter', compact('po_tnas'));
    }

    public function setPoTnaTermRemarks(Request $request){
        $po_tna_term_id = $request->po_tna_term_id;
        $po_tna_remarks = $request->po_tna_remarks;

        $po_tna = PoTna::find($po_tna_term_id);
        $po_tna->remarks = $po_tna_remarks;
        $po_tna->save();

        return response()->json('success', 200);
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
        //
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

    public function completePoTnaTerm(Request $request){
        $po_tna_term_id = $request->po_tna_term_id;

        $po_tna_term = PoTna::find($po_tna_term_id);

        $custom_tna_days = (isset($po_tna_term->custom_plan_tna_days) ? $po_tna_term->custom_plan_tna_days : 0);

        $datetime1 = strtotime(date('Y-m-d')); // convert to timestamps
        $plan_tna_date = date('Y-m-d', strtotime( $po_tna_term->plan_tna_date. " +$custom_tna_days days"));
        $datetime2 = strtotime($plan_tna_date); // convert to timestamps
        $diff_in_days = (int)(($datetime1 - $datetime2)/86400);

        $po_tna_term->actual_tna_date = date('Y-m-d');
        $po_tna_term->difference_between_plan_actual_date = $diff_in_days;
        $po_tna_term->updated_by = Auth::user()->id;
        $po_tna_term->save();

        return response()->json('success', 200);
    }

}
