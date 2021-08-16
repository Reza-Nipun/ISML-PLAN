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
use PhpOffice\PhpSpreadsheet\IOFactory;

class PoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = ' | PO List';
        $plants = Plant::all();
        $buyers = Buyer::all();
        $tnas = Tna::all();
        $pos = Po::all();

        return view('po.po_list', compact('title', 'buyers', 'plants', 'tnas', 'pos'));
    }

    public function searchPo(Request $request){
        $plant_id = $request->plant_id;
        $buyer_id = $request->buyer_id;
        $po_id = $request->po_filter;
        $ship_date_from = $request->ship_date_from;
        $ship_date_to = $request->ship_date_to;

        $query = Po::query();

        if ($plant_id!=null) {
            $query = $query->where('plant_id', $plant_id);
        }

        if ($buyer_id!=null) {
            $query = $query->where('buyer_id', $buyer_id);
        }

        if ($po_id!=null) {
            $query = $query->where('id', $po_id);
        }

        if (($ship_date_from!=null) && ($ship_date_to!=null)) {
            $query = $query->whereBetween('ship_date', [$ship_date_from, $ship_date_to]);
        }

        $pos = $query->get();

        return view('po.po_filter', compact('pos'));
    }


    public function assignTnaDetail(Request $request){
        $po_id = $request->po_id;

        $po_tna_details = PoTna::where('po_id', $po_id)->get();

        return view('po.po_tna_detail_filter', compact('po_tna_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = ' | Upload PO';
        $plants = Plant::where('status', 1)->get();
        $buyers = Buyer::where('status', 1)->get();

        return view('po.po_upload', compact('title', 'plants', 'buyers'));
    }

    public function uploadFile(Request $request){
        $this->validate(request(), [
            'plant'   => 'required',
            'buyer'   => 'required',
            'po_type'   => 'required',
            'upload_file'   => 'required|mimes:xls,xlsx',
        ]);

        $plant = $request->plant;
        $buyer = $request->buyer;
        $po_type = $request->po_type;
        $path = $request->file('upload_file')->getRealPath();

        $spreadsheet = IOFactory::load($path);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

//        Checking Date
        Carbon::macro('checkDate', function (
            $date,
            $month = null,
            $day = null
        ) {
            if (!is_null($day)) {
                $date = "{$date}-{$month}-{$day}";
            }

            $parsed = date_parse($date);

            return $parsed['error_count'] == 0 &&
                ($parsed['warning_count'] == 0 ||
                    !in_array(
                        'The parsed date was invalid',
                        $parsed['warnings']
                    ));
        });
//        Checking Date

        foreach ($sheetData as $row => $value) {

            if($row > 1){

                $is_po_exist = Po::where('po', $value['A'])
                                ->where('destination', $value['B'])
                                ->where('quality', $value['E'])
                                ->where('color', $value['F'])
                                ->where('style_no', $value['C'])
                                ->where('style_name', $value['D'])
                                ->where('buyer_id', $buyer)
                                ->where('ship_date', Carbon::parse($value['H'])->format('Y-m-d'))
                                ->where('po_type', $po_type)
                                ->get();

                if(sizeof($is_po_exist) == 0){
                    if(!empty($value['A']) && !empty($value['B']) && !empty($value['C']) && !empty($value['D']) && !empty($value['E']) && !empty($value['F']) && (Carbon::checkDate($value['I']) == true)){
                        $po = new Po();
                        $po->po = $value['A'];
                        $po->destination = $value['B'];
                        $po->quality = $value['E'];
                        $po->color = $value['F'];
                        $po->style_no = $value['C'];
                        $po->style_name = $value['D'];
                        $po->buyer_id = $buyer;
                        $po->ship_date = Carbon::parse($value['I'])->format('Y-m-d');
                        $po->order_confirm_date = Carbon::parse($value['J'])->format('Y-m-d');
                        $po->plan_quantity = $value['G'];
                        $po->order_quantity = $value['H'];
                        $po->po_type = $po_type;
                        $po->plant_id = $plant;
                        $po->uploaded_by = Auth::user()->id;
                        $po->save();

                        $po_id = $po->id;
                        $bill_tracking_no_update = Po::find($po_id);
                        $bill_tracking_no_update->order_no = $po_id.'-'.Carbon::parse($value['I'])->format('Y-m-d');
                        $bill_tracking_no_update->save();
                    }
                }

            }

        }

        return back()->with('success', 'Excel Data Imported successfully.');
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

    public function deletePo(Request $request){
        $po_ids = $request->po_ids;

        foreach($po_ids as $po_id){
            PoTna::where('po_id', $po_id)->delete();
            Po::destroy($po_id);
        }

        return response()->json('success', 200);
    }

    public function assignTna(Request $request){
        $po_ids = $request->po_ids;
        $assign_tna_id = $request->assign_tna_id;

        foreach($po_ids as $po_id){

            $po = Po::find($po_id);
            $po->tna_id = $assign_tna_id;
            $po->save();

            $po_ship_date = $po->ship_date;

            $tna_terms = TnaTerm::where('tna_id', $assign_tna_id)->get();

            PoTna::where('po_id', $po_id)->delete();

            foreach ($tna_terms as $tna_term){
                $po_tna = new PoTna();
                $po_tna->po_id = $po_id;
                $po_tna->tna_id = $assign_tna_id;
                $po_tna->tna_term_id = $tna_term->id;
                $po_tna->plan_tna_date = date('Y-m-d', strtotime($po_ship_date. " - $tna_term->days days"));
                $po_tna->save();
            }

        }

        return response()->json('success', 200);
    }

    public function changePlant(Request $request){
        $po_ids = $request->po_ids;
        $change_plant_id = $request->change_plant_id;

        foreach($po_ids as $po_id){
            $po = Po::find($po_id);
            $po->plant_id = $change_plant_id;
            $po->save();
        }

        return response()->json('success', 200);
    }

    public function changeShipDate(Request $request){
        $po_ids = $request->po_ids;
        $change_ship_date = $request->change_ship_date;

        foreach($po_ids as $po_id){
            $po = Po::find($po_id);
            $po->ship_date = $change_ship_date;
            $po->save();

            $po_tnas = PoTna::where('po_id', $po_id)->get();

            foreach ($po_tnas as $po_tna){
                $tna_term_days = $po_tna->tna_term->days;
                $tna_term_plan_date = date('Y-m-d', strtotime($change_ship_date. " - $tna_term_days days"));

                $po_tna_update = PoTna::find($po_tna->id);
                $po_tna_update->plan_tna_date = $tna_term_plan_date;

                if(isset($po_tna_update->actual_tna_date)){
                    $custom_tna_days = (isset($po_tna_update->custom_plan_tna_days) ? $po_tna_update->custom_plan_tna_days : 0);

                    $datetime1 = strtotime($po_tna_update->actual_tna_date); // convert to timestamps
                    $plan_tna_date = date('Y-m-d', strtotime( $po_tna_update->plan_tna_date. " +$custom_tna_days days"));
                    $datetime2 = strtotime($plan_tna_date); // convert to timestamps
                    $diff_in_days = (int)(($datetime1 - $datetime2)/86400);

                    $po_tna_update->difference_between_plan_actual_date = $diff_in_days;
                }

                $po_tna_update->save();
            }

        }

        return response()->json('success', 200);
    }

    public function shipmentInfoUpdate(Request $request){
        $po_id = $request->po_id;
        $actual_ship_date = $request->actual_ship_date;
        $actual_ship_qty = $request->actual_ship_qty;
        $remarks = $request->remarks;

        $po = Po::find($po_id);
        $po->actual_ship_date = $actual_ship_date;
        $po->actual_ship_quantity = $actual_ship_qty;
        $po->remarks = $remarks;
        $po->save();

        return response()->json('success', 200);
    }

    public function getPoInfo(Request $request){
        $po_id = $request->po_id;

        $po_info = Po::where('id', $po_id)->get();

        return response()->json($po_info, 200);
    }

    public function shipmentSummaryReport(){
        $title = ' | PO List';
        $plants = Plant::all();
        $buyers = Buyer::all();

        return view('reports.shipment_summary', compact('title', 'buyers', 'plants'));
    }

    public function getShipmentSummaryData(Request $request){
        $plant_id = $request->plant_id;
        $buyer_id = $request->buyer_id;
        $ship_date_from = $request->ship_date_from;
        $ship_date_to = $request->ship_date_to;

        $query_1 = Po::query()
                        ->whereNotNull('ship_date');

        $query_2 = Po::query()
                        ->whereNotNull('actual_ship_date')
                        ->whereNotNull('ship_date')
                        ->whereRaw("actual_ship_date <= ship_date");

        $query_3 = Po::query()
                        ->whereNotNull('actual_ship_date')
                        ->whereNotNull('ship_date')
                        ->whereRaw("actual_ship_date > ship_date");

        $query_4 = Po::query()
                        ->whereNull('actual_ship_date');

        $query_5 = Po::query()
                    ->whereNotNull('actual_ship_date');

        if ($plant_id!=null) {
            $query_1 = $query_1->where('plant_id', $plant_id);
            $query_2 = $query_2->where('plant_id', $plant_id);
            $query_3 = $query_3->where('plant_id', $plant_id);
            $query_4 = $query_4->where('plant_id', $plant_id);
            $query_5 = $query_5->where('plant_id', $plant_id);
        }

        if ($buyer_id!=null) {
            $query_1 = $query_1->where('buyer_id', $buyer_id);
            $query_2 = $query_2->where('buyer_id', $buyer_id);
            $query_3 = $query_3->where('buyer_id', $buyer_id);
            $query_4 = $query_4->where('buyer_id', $buyer_id);
            $query_5 = $query_5->where('buyer_id', $buyer_id);
        }

        if (($ship_date_from!=null) && ($ship_date_to!=null)) {
            $query_1 = $query_1->whereBetween('ship_date', [$ship_date_from, $ship_date_to]);
            $query_2 = $query_2->whereBetween('ship_date', [$ship_date_from, $ship_date_to]);
            $query_3 = $query_3->whereBetween('ship_date', [$ship_date_from, $ship_date_to]);
            $query_4 = $query_4->whereBetween('ship_date', [$ship_date_from, $ship_date_to]);
            $query_5 = $query_5->whereBetween('ship_date', [$ship_date_from, $ship_date_to]);
        }

        $total_pos = $query_1->count();
        $total_pos_sum_order = $query_1->sum('order_quantity');

        $total_ontime_shipment = $query_2->count();
        $total_ontime_shipment_quantity = $query_2->sum('actual_ship_quantity');

        $total_delay_shipment = $query_3->count();
        $total_delay_shipment_quantity = $query_3->sum('actual_ship_quantity');

        $total_pending = $query_4->count();
        $total_pending_quantity = $query_4->sum('order_quantity');

        $total_ship_pos = $query_5->count();
        $total_ship_quantity = $query_5->sum('actual_ship_quantity');

        $data = array(
            'total_pos' => $total_pos,
            'total_ship_pos' => $total_ship_pos,
            'total_ship_quantity' => $total_ship_quantity,
            'total_pos_sum_order' => $total_pos_sum_order,
            'total_ontime_shipment' => $total_ontime_shipment,
            'total_ontime_shipment_quantity' => $total_ontime_shipment_quantity,
            'total_delay_shipment' => $total_delay_shipment,
            'total_delay_shipment_quantity' => $total_delay_shipment_quantity,
            'total_pending' => $total_pending,
            'total_pending_quantity' => $total_pending_quantity,
        );


        return response()->json($data);
    }
}
