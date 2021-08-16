@foreach($po_tnas as $po_tna)
    <tr>
        <td class="text-center td">
            <span class="btn btn-sm btn-success" title="Complete" onclick="completePoTnaTerm('{{ $po_tna->id }}');">
                <i class="fas fa-check"></i>
            </span>
            <span class="btn btn-sm btn-warning" title="Remarks" onclick="setPoTnaTermRemarksModal('{{ $po_tna->id }}')">
                <i class="far fa-comment"></i>
            </span>
        </td>
        <td class="text-center td">
            {{ $po_tna->tna_name }}
        </td>
        <td class="text-center td">
            {{ $po_tna->tna_term }}
        </td>
        <td class="text-center td">
            {{ $po_tna->plan_tna_date }}
        </td>
        <td class="text-center td">
            {{ $po_tna->ship_date }}
        </td>
        <td class="text-center td">
            {{ $po_tna->plant_name }}
        </td>
        <td class="text-center td">
            {{ $po_tna->buyer_name }}
        </td>
        <td class="text-center td">
            {{ $po_tna->po }}
        </td>
        <td class="text-center td">
            {{ $po_tna->destination }}
        </td>
        <td class="text-center td">
            {{ $po_tna->style_no }}
        </td>
        <td class="text-center td">
            {{ $po_tna->style_name }}
        </td>
        <td class="text-center td">
            {{ $po_tna->quality }}
        </td>
        <td class="text-center td">
            {{ $po_tna->color }}
        </td>
        <td class="text-center td">
            @if($po_tna->po_type == 0)
                Bulk
            @elseif($po_tna->po_type == 1)
                Sample
            @elseif($po_tna->po_type == 2)
                Size-Set
            @endif
        </td>
    </tr>
@endforeach