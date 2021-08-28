@extends((Auth::user()->is_admin == 1) ? 'layouts.admin_app' : 'layouts.user_app')

@section('content')

    <style>
        .td{white-space:nowrap}
    </style>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>PO-TNA Tasks</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">PO-TNA Tasks</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <!-- /.card -->
                        <div class="card">
                            {{--<div class="card-header">--}}
                                {{--<h3 class="card-title">--}}
                                    {{--<a href="{{ route('po.create') }}" class="btn btn-success">--}}
                                        {{--<i class="fas fa-upload"></i> Upload PO--}}
                                    {{--</a>--}}
                                {{--</h3>--}}
                            {{--</div>--}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="plant_filter">Plant</label>
                                            <select class="form-control select2bs4" style="width: 100%;" name="plant_filter" id="plant_filter">
                                                <option value="">Select Plant</option>
                                                @foreach($plants as $plant)
                                                    <option value="{{ $plant->id }}">{{ $plant->plant_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="buyer_filter">Buyer</label>
                                            <select class="form-control select2bs4" style="width: 100%;" name="buyer_filter" id="buyer_filter">
                                                <option value="">Select Buyer</option>
                                                @foreach($buyers as $buyer)
                                                    <option value="{{ $buyer->id }}">{{ $buyer->buyer_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="po_filter">PO_Destination_Style_Color_Quality_ShipDate_Type</label>
                                            <select class="form-control select2bs4" style="width: 100%;" name="po_filter" id="po_filter">
                                                <option value="">Select PO</option>
                                                @foreach($pos as $po)

                                                    @php
                                                        $po_type = '';

                                                        if($po->po_type == 0){
                                                            $po_type = 'BULK';
                                                        }elseif ($po->po_type == 1){
                                                            $po_type = 'Sample';
                                                        }elseif ($po->po_type == 2){
                                                            $po_type = 'Size-Set';
                                                        }
                                                    @endphp

                                                    <option value="{{ $po->id }}">{{ $po->po.'_'.$po->destination.'_'.$po->style_no.'_'.$po->color.'_'.$po->quality.'_'.$po->ship_date.'_'.$po_type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Ship Date <span class="badge badge-danger" onclick="return $('#ship_date_range_filter').val('');"><i class="far fa-calendar-times"></i></span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                                <input type="text" class="form-control float-right reservationtime" id="ship_date_range_filter" autocomplete="off">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-1 d-flex align-items-end">
                                        <div class="form-group">
                                            {{--<label for="search_btn"><span style="color: #ffffff;">.</span></label>--}}
                                            <button class="form-control btn btn-primary" id="search_btn" onclick="searchPoTnaTasks()">SEARCH</button>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-1 d-flex align-items-end">
                                        {{--<label for=""><span style="color: #ffffff;">.</span></label>--}}
                                        <div class="loader" style="display: none;"></div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive p-0 tableFixHead">
                                    <table id="table_id" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center td">ACTION</th>
                                                <th class="text-center td">TNA</th>
                                                <th class="text-center td">TNA-TERM</th>
                                                <th class="text-center td">PLAN DATE</th>
                                                <th class="text-center td">SHIP DATE</th>
                                                <th class="text-center td">PLANT</th>
                                                <th class="text-center td">BUYER</th>
                                                <th class="text-center td">PO</th>
                                                <th class="text-center td">DEST.</th>
                                                <th class="text-center td">STYLE#</th>
                                                <th class="text-center td">STYLE NAME</th>
                                                <th class="text-center td">QUALITY</th>
                                                <th class="text-center td">COLOR</th>
                                                <th class="text-center td">TYPE</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_id">
                                            {{--@foreach($po_tnas as $po_tna)--}}
                                                {{--<tr>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--<span class="btn btn-sm btn-success" title="Complete" onclick="completePoTnaTerm('{{ $po_tna->id }}');">--}}
                                                            {{--<i class="fas fa-check"></i>--}}
                                                        {{--</span>--}}
                                                        {{--<span class="btn btn-sm btn-warning" title="Remarks" onclick="setPoTnaTermRemarksModal('{{ $po_tna->id }}')">--}}
                                                            {{--<i class="far fa-comment"></i>--}}
                                                        {{--</span>--}}
                                                    {{--</td>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--{{ $po_tna->tna_name }}--}}
                                                    {{--</td>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--{{ $po_tna->tna_term }}--}}
                                                    {{--</td>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--{{ $po_tna->plan_tna_date }}--}}
                                                    {{--</td>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--{{ $po_tna->ship_date }}--}}
                                                    {{--</td>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--{{ $po_tna->plant_name }}--}}
                                                    {{--</td>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--{{ $po_tna->buyer_name }}--}}
                                                    {{--</td>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--{{ $po_tna->po }}--}}
                                                    {{--</td>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--{{ $po_tna->destination }}--}}
                                                    {{--</td>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--{{ $po_tna->style_no }}--}}
                                                    {{--</td>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--{{ $po_tna->style_name }}--}}
                                                    {{--</td>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--{{ $po_tna->quality }}--}}
                                                    {{--</td>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--{{ $po_tna->color }}--}}
                                                    {{--</td>--}}
                                                    {{--<td class="text-center td">--}}
                                                        {{--@if($po_tna->po_type == 0)--}}
                                                            {{--Bulk--}}
                                                        {{--@elseif($po_tna->po_type == 1)--}}
                                                            {{--Sample--}}
                                                        {{--@elseif($po_tna->po_type == 2)--}}
                                                            {{--Size-Set--}}
                                                        {{--@endif--}}
                                                    {{--</td>--}}
                                                {{--</tr>--}}
                                            {{--@endforeach--}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <div class="modal fade" id="modal-lg-0">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Warning <i class="fas fa-exclamation-triangle"></i></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h5 id="warning_message">No Options are Selected!</h5>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-lg-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remarks <i class="far fa-comment"></i></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="plant_filter">Remarks</label>
                                <input type="text" class="form-control" name="po_tna_remarks" id="po_tna_remarks" autocomplete="off" />
                                <input type="hidden" readonly="readonly" class="form-control" name="remarks_po_tna_term_id" id="remarks_po_tna_term_id" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="setPoTnaTermRemarks()">SAVE</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script type="text/javascript">
        $(document).on('click','#checkAll',function () {
            $('.checkItem').not(this).prop('checked', this.checked);
        });

        function ExportToExcel(tableid) {
            var tab_text = "<table border='2px'><tr>";
            var textRange; var j = 0;
            tab = document.getElementById(tableid);//.getElementsByTagName('table'); // id of table
            if (tab==null) {
                return false;
            }
            if (tab.rows.length == 0) {
                return false;
            }

            for (j = 0 ; j < tab.rows.length ; j++) {
                tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
                //tab_text=tab_text+"</tr>";
            }

            tab_text = tab_text + "</table>";
            tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
            tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
            tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");

            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
            {
                txtArea1.document.open("txt/html", "replace");
                txtArea1.document.write(tab_text);
                txtArea1.document.close();
                txtArea1.focus();
                sa = txtArea1.document.execCommand("SaveAs", true, "download.xls");
            }
            else                 //other browser not tested on IE 11
            //sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
                try {
                    var blob = new Blob([tab_text], { type: "application/vnd.ms-excel" });
                    window.URL = window.URL || window.webkitURL;
                    link = window.URL.createObjectURL(blob);
                    a = document.createElement("a");
                    if (document.getElementById("caption")!=null) {
                        a.download=document.getElementById("caption").innerText;
                    }
                    else
                    {
                        a.download = 'download';
                    }

                    a.href = link;

                    document.body.appendChild(a);

                    a.click();

                    document.body.removeChild(a);
                } catch (e) {
                }


            return false;
            //return (sa);
        }

        function searchPoTnaTasks() {
            var plant_id = $("#plant_filter").val();
            var buyer_id = $("#buyer_filter").val();
            var po_filter = $("#po_filter").val();

//        Ship Date Range Start
            var ship_dt_range_filter = $("#ship_date_range_filter").val();
            var ship_date_range_filter = ship_dt_range_filter.split(" - ");

            var ship_date_from = ship_date_range_filter[0];
            var ship_date_to = (ship_date_range_filter[1] != undefined ? ship_date_range_filter[1] : '');
//        Ship Date Range End

//            if(plant_id=='' && buyer_id=='' && po_filter=='' && (ship_date_from=='' || ship_date_from==undefined) && (ship_date_to==''  || ship_date_to==undefined)){
//                $("#modal-lg-0").modal('show');
//            }else{
                $(".loader").css('display', 'block');
                $("#tbody_id").empty();

                $.ajax({
                    url: "{{ route("search_po_tna_tasks") }}",
                    type:'POST',
                    data: {_token:"{{csrf_token()}}", plant_id: plant_id, buyer_id: buyer_id, po_filter: po_filter, ship_date_from: ship_date_from, ship_date_to: ship_date_to},
                    dataType: "html",
                    success: function (data) {
                        $("#tbody_id").append(data);
                        $(".loader").css('display', 'none');
                    }
                });
//            }

        }
        
        function completePoTnaTerm(po_tna_term_id) {
            $.ajax({
                url: "{{ route("complete_po_tna_term") }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}", po_tna_term_id: po_tna_term_id},
                dataType: "json",
                success: function (data) {
                    if(data == 'success'){
                        $("#search_btn").click();
                    }
                }
            });
        }

        function setPoTnaTermRemarksModal(po_tna_term_id) {
            $("#remarks_po_tna_term_id").val(po_tna_term_id);
            $("#modal-lg-1").modal('show');
        }

        function setPoTnaTermRemarks() {
            var po_tna_term_id = $("#remarks_po_tna_term_id").val();
            var po_tna_remarks = $("#po_tna_remarks").val();

            $.ajax({
                url: "{{ route("set_po_tna_term_remarks") }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}", po_tna_term_id: po_tna_term_id, po_tna_remarks: po_tna_remarks},
                dataType: "json",
                success: function (data) {
                    if(data == 'success'){
                        $("#modal-lg-1").modal('hide');
                        $("#search_btn").click();
                    }
                }
            });
        }

    </script>

@endsection
