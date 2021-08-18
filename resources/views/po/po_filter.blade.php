<thead>
    <tr>
        @if(Auth::user()->user_type == 0 || Auth::user()->user_type == 3)
            <th class="text-center td">
                <input type="checkbox" class="" id="checkAll" style="width:2vw; height:3vh;">
            </th>
        @endif
        {{--<th class="text-center td">Order No</th>--}}
        <th class="text-center td">Action</th>
        <th class="text-center td">Plant</th>
        <th class="text-center td">PO</th>
        <th class="text-center td">Dest.</th>
        <th class="text-center td">Style No</th>
        <th class="text-center td">Style Name</th>
        <th class="text-center td">Quality</th>
        <th class="text-center td">Color</th>
        <th class="text-center td">Order Qty</th>
        <th class="text-center td">Plan Qty</th>
        <th class="text-center td">Buyer</th>
        <th class="text-center td">Ship Date</th>
        <th class="text-center td">Approx Ship Date</th>
        <th class="text-center td">Actual Ship Date</th>
        <th class="text-center td">Actual Ship Qty</th>
        <th class="text-center td">Confirm Date</th>
        <th class="text-center td">Type</th>
        <th class="text-center">Remarks</th>
    </tr>
</thead>
<tbody>
@php
    $total_plan_qty = 0;
    $total_order_qty = 0;
    $total_ship_qty = 0;
@endphp

@foreach($pos as $k => $po)

    @php
        $total_plan_qty += $po->plan_quantity;
        $total_order_qty += $po->order_quantity;
        $total_ship_qty += $po->actual_ship_quantity;

        $max_differece = $po->po_tnas->max('difference_between_plan_actual_date');
        $days_difference = (isset($max_differece) ? $max_differece : 0);
    @endphp

    <tr>
        @if(Auth::user()->user_type == 0 || Auth::user()->user_type == 3)
            <td>
                <input type="checkbox" class="checkItem" id="" name="checkItem[]" style="width:2vw; height:3vh;" value="{{ $po->id }}">
            </td>
        @endif
            {{--<td class="text-center td">--}}
                {{--{{ $po->order_no }}--}}
            {{--</td>--}}
            <td class="text-center td">
                @if(Auth::user()->user_type == 0)
                    <span class="btn btn-sm btn-primary" title="EDIT" onclick="poInfoUpdateModal('{{ $po->id }}')">
                        <i class="fas fa-edit"></i>
                    </span>
                @endif

                @if(Auth::user()->user_type == 0 || Auth::user()->user_type == 3)
                    <span class="btn btn-sm btn-success" title="SHIPMENT" onclick="shipmentInfoUpdateModal('{{ $po->id }}')">
                        <i class="fas fa-truck"></i>
                    </span>
                @endif

                @if(!empty($po->tna_id))
                    <span class="btn btn-sm btn-warning" onclick="assignTNADetail('{{ $po->id }}')" title="TNA">
                        {{ $po->tna->tna_name }}
                    </span>
                @endif
            </td>
            <td class="text-center td">
                {{ $po->plant->plant_name }}
            </td>
            <td class="text-center td">
                {{ $po->po }}
            </td>
            <td class="text-center td">
                {{ $po->destination }}
            </td>
            <td class="text-center td">
                {{ $po->style_no }}
            </td>
            <td class="text-center td">
                {{ $po->style_name }}
            </td>
            <td class="text-center td">
                {{ $po->quality }}
            </td>
            <td class="text-center td">
                {{ $po->color }}
            </td>
            <td class="text-center td">
                {{ $po->order_quantity }}
            </td>
            <td class="text-center td">
                {{ $po->plan_quantity }}
            </td>
            <td class="text-center td">
                {{ $po->buyer->buyer_name }}
            </td>
            <td class="text-center td">
                {{ $po->ship_date }}
            </td>
            <td class="text-center td" @if(date('Y-m-d', strtotime($po->ship_date . " +".$days_difference." days ")) > $po->ship_date) style="background-color: #ffcbd6;" @endif>
                {{ date('Y-m-d', strtotime($po->ship_date . " +".$days_difference." days ")) }}
            </td>
            <td class="text-center td">
                {{ $po->actual_ship_date }}
            </td>
            <td class="text-center td">
                {{ $po->actual_ship_quantity }}
            </td>
            <td class="text-center td">
                {{ $po->order_confirm_date }}
            </td>
            <td class="text-center td">
                @if($po->po_type == 0)
                    Bulk
                @elseif($po->po_type == 1)
                    Sample
                @elseif($po->po_type == 2)
                    Size-Set
                @endif
            </td>
            <td class="text-center">
                {{ $po->remarks }}
            </td>
    </tr>
@endforeach
</tbody>
<tfoot>
<tr>
    @if(Auth::user()->user_type == 0 || Auth::user()->user_type == 3)
        <td class="text-center td">

        </td>
    @endif
    {{--<th class="text-center td">Order No</th>--}}
    <td class="text-center td" colspan="8"></td>
    <td class="text-center td">
        {{ $total_order_qty }}
    </td>
    <td class="text-center td">
        {{ $total_plan_qty }}
    </td>
    <td class="text-center td" colspan="4"></td>
    <td class="text-center td">
        {{ $total_ship_qty }}
    </td>
    <td class="text-center td" colspan="3"></td>
</tr>
</tfoot>