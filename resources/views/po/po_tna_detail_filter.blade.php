<div class="table-responsive p-0 tableFixHead">
    <table id="table_id" class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center td">PO</th>
                <th class="text-center td">DEST</th>
                <th class="text-center td">STYLE</th>
                <th class="text-center td">QUALITY-COLOR</th>
                <th class="text-center td">SHIP DATE</th>
                <th class="text-center td">DELAY</th>
                <th class="text-center td">APPROX SHIP DATE</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center td">
                    {{ $po_tna_details[0]->po->po }}
                </td>
                <td class="text-center td">
                    {{ $po_tna_details[0]->po->destination }}
                </td>
                <td class="text-center">
                    {{ $po_tna_details[0]->po->style_no.' - '.$po_tna_details[0]->po->style_name }}
                </td>
                <td class="text-center td">
                    {{ $po_tna_details[0]->po->quality.' - '.$po_tna_details[0]->po->color }}
                </td>
                <td class="text-center td">
                    {{ $po_tna_details[0]->po->ship_date }}
                </td>
                <td class="text-center td">
                    @php
                        $total_delay_days = $po_tna_details[0]->po->po_tnas->max('difference_between_plan_actual_date');
                    @endphp
                    {{ $total_delay_days }} DAYS
                </td>
                <td class="text-center td" @if(date('Y-m-d', strtotime($po_tna_details[0]->po->ship_date . " +".$total_delay_days." days ")) > $po_tna_details[0]->po->ship_date) style="background-color: #ffcbd6;" @endif>
                    {{ date('Y-m-d', strtotime($po_tna_details[0]->po->ship_date . " +".$total_delay_days." days ")) }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="table-responsive p-0 tableFixHead">
    <table id="table_id" class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center td">TNA TERM</th>
                <th class="text-center td">LIABLE DEPT</th>
                <th class="text-center td">PLAN DATE</th>
                <th class="text-center td">ACTUAL DATE</th>
                <th class="text-center td">Days Difference</th>
                <th class="text-center td">Update By</th>
                <th class="text-center td">Remarks</th>
                <th class="text-center td">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($po_tna_details as $k => $po_tna_detail)

                <tr @if($po_tna_detail->difference_between_plan_actual_date > 0) style="background-color: #ffcbd6;" @endif>
                    <td class="text-center td">
                        {{ $po_tna_detail->tna_term->tna_term }}
                    </td>
                    <td class="text-center td">
                        @if(isset($po_tna_detail->tna_term->responsible_user_type))
                            {{ $po_tna_detail->tna_term->responsible_users_type->user_type }}
                        @endif
                    </td>
                    <td class="text-center td">
                        {{ $po_tna_detail->plan_tna_date }}
                    </td>
                    <td class="text-center td">
                        {{ $po_tna_detail->actual_tna_date }}
                    </td>
                    <td class="text-center td">
                        {{ $po_tna_detail->difference_between_plan_actual_date }}
                    </td>
                    <td class="text-center td">
                        @if(isset($po_tna_detail->updated_by))
                            {{ $po_tna_detail->user->name }}
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $po_tna_detail->remarks }}
                    </td>
                    <td class="text-center td">
                        @if($po_tna_detail->tna_term->responsible_user_type == auth()->user()->user_type)
                            @if(!isset($po_tna_detail->actual_tna_date))
                                <span class="btn btn-sm btn-success" title="Complete" onclick="completePoTnaTerm('{{ $po_tna_detail->id }}', '{{ $po_tna_detail->po_id }}');">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="btn btn-sm btn-warning" title="Remarks" onclick="setPoTnaTermRemarksModal('{{ $po_tna_detail->id }}', '{{ $po_tna_detail->po_id }}')">
                                    <i class="far fa-comment"></i>
                                </span>
                            @endif
                        @elseif(auth()->user()->user_type == 0)
                            @if(!isset($po_tna_detail->actual_tna_date))
                                <span class="btn btn-sm btn-success" title="Complete" onclick="completePoTnaTerm('{{ $po_tna_detail->id }}', '{{ $po_tna_detail->po_id }}');">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="btn btn-sm btn-warning" title="Remarks" onclick="setPoTnaTermRemarksModal('{{ $po_tna_detail->id }}', '{{ $po_tna_detail->po_id }}')">
                                    <i class="far fa-comment"></i>
                                </span>
                            @endif
                        @endif
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>
</div>