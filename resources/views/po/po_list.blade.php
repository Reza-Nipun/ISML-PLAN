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
                        <h1>PO List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">PO List</li>
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
                                            <label for="">Ship Date Range <span class="badge badge-danger" onclick="return $('#ship_date_range_filter').val('');"><i class="far fa-calendar-times"></i></span></label>
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
                                            <button class="form-control btn btn-primary" id="search_btn" onclick="searchPOs()">SEARCH</button>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-8">
                                        <button class="btn btn-sm btn-secondary" style="color: #FFF;" onclick="ExportToExcel('table_id')">
                                            <i class="fas fa-file-excel"></i> Export Excel
                                        </button>

                                        @if(Auth::user()->is_admin == 1)
                                            <a href="{{ route('po.create') }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-upload"></i> Upload PO
                                            </a>

                                            <span class="btn btn-sm btn-danger" onclick="deletePoModal()"><i class="fas fa-trash"></i> Delete</span>
                                        @endif

                                        @if(Auth::user()->is_admin == 1 || Auth::user()->user_type == 3)
                                            <span class="btn btn-sm btn-primary" onclick="assignTNAModal()"><i class="fas fa-calendar-alt"></i> Assign TNA</span>
                                            <span class="btn btn-sm btn-warning" onclick="changePlantModal()"><i class="fas fa-store"></i> Change Plant</span>
                                            <span class="btn btn-sm btn-info" onclick="changeShipDateModal()"><i class="fas fa-ship"></i> Change Ship-Date</span>
                                        @endif

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
                                                @if(Auth::user()->is_admin == 1 || Auth::user()->user_type == 3)
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
                                        <tbody></tbody>
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
    <div class="modal fade" id="modal-lg-0-1">
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
                                <h5 id="warning_message">Please fill-up required fields!</h5>
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
                    <h4 class="modal-title">Warning <i class="fas fa-exclamation-triangle"></i></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h5 id="warning_message">Are You Sure to Delete Selected POs?</h5>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-success" onclick="deletePOs()">Yes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="modal-lg-2">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-calendar-alt"></i> Assign TNA</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="assign_tna_id">Select TNA</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="assign_tna_id" id="assign_tna_id">
                                    <option value="">Select TNA</option>
                                    @foreach($tnas as $tna)
                                        <option value="{{ $tna->id }}">{{ $tna->tna_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <div class="loader" style="display: none;"></div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                    <button type="button" class="btn btn-success" onclick="assignTNA()">SAVE</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="modal-lg-3">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-calendar-alt"></i> TNA DETAIL</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="tna_detail_id">

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="modal-lg-4">
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
                                <input type="hidden" readonly="readonly" class="form-control" name="remarks_po_id" id="remarks_po_id" />
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
    <div class="modal fade" id="modal-lg-5">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Change Plant <i class="far fa-store"></i></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="change_plant_id">Plant</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="change_plant_id" id="change_plant_id">
                                    <option value="">Select Plant</option>
                                    @foreach($plants as $plant)
                                        <option value="{{ $plant->id }}">{{ $plant->plant_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="changePlant()">SAVE</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="modal-lg-6">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Change Ship Date <i class="fas fa-ship"></i></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="change_ship_date">Ship Date <span class="badge badge-danger" onclick="return $('#change_ship_date').val('');"><i class="far fa-calendar-times"></i></span></label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" placeholder="YYYY-MM-DD" id="change_ship_date" autocomplete="off" />
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="changeShipDate()">SAVE</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="modal-lg-7">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Shipment Update <i class="fas fa-ship"></i></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="actual_ship_date">Ship Date <span class="badge badge-danger" onclick="return $('#actual_ship_date').val('');"><i class="far fa-calendar-times"></i></span></label>
                                <div class="input-group date reservationdate" id="" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate" placeholder="YYYY-MM-DD" id="actual_ship_date" autocomplete="off" />
                                    <div class="input-group-append" data-target=".reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" id="ship_info_po_id" autocomplete="off" />
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label for="actual_ship_qty">Actual Ship Qty</label>
                                <input type="number" class="form-control" id="actual_ship_qty" autocomplete="off" />
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <input type="text" class="form-control" id="remarks" autocomplete="off" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="shipmentInfoUpdate()">SAVE</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="modal-lg-8">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">PO Update <i class="fab fa-first-order"></i></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="po_update_po_no">PO <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="po_update_po_no" autocomplete="off" />
                                <input type="hidden" class="form-control" id="po_info_update_po_id" autocomplete="off" readonly="readonly" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="po_update_destination">Destination <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="po_update_destination" autocomplete="off" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="po_update_style_no">Style No <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="po_update_style_no" autocomplete="off" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="po_update_style_name">Style Name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="po_update_style_name" autocomplete="off" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="po_update_quality">Quality <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="po_update_quality" autocomplete="off" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="po_update_color">Color <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="po_update_color" autocomplete="off" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="po_update_plan_qty">Plan Qty <span style="color: red;">*</span></label>
                                <input type="number" class="form-control" id="po_update_plan_qty" autocomplete="off" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="po_update_order_qty">Order Qty <span style="color: red;">*</span></label>
                                <input type="number" class="form-control" id="po_update_order_qty" autocomplete="off" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Ship Date <span style="color: red;">*</span> <span class="badge badge-danger" onclick="return $('#po_update_ship_date').val('');"><i class="far fa-calendar-times"></i></span></label>
                                <div class="input-group date reservationdate" id="" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate" placeholder="YYYY-MM-DD" id="po_update_ship_date" autocomplete="off" />
                                    <div class="input-group-append" data-target=".reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Confirm Date <span class="badge badge-danger" onclick="return $('#po_update_confirm_date').val('');"><i class="far fa-calendar-times"></i></span></label>
                                <div class="input-group date reservationdate_2" id="" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target=".reservationdate_2" placeholder="YYYY-MM-DD" id="po_update_confirm_date" autocomplete="off" />
                                    <div class="input-group-append" data-target=".reservationdate_2" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="po_update_po_type">PO Type <span style="color: red;">*</span></label>
                                <select class="form-control" style="width: 100%;" id="po_update_po_type">
                                    <option value="">Select Type</option>
                                    <option value="0">Bulk</option>
                                    <option value="1">Sample</option>
                                    <option value="2">Size-Set</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="po_update_po_remarks">Remarks </label>
                                <input type="text" class="form-control" id="po_update_po_remarks" autocomplete="off" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="po_update_buyer">Buyer <span style="color: red;">*</span></label>
                                <select class="form-control" style="width: 100%;" id="po_update_buyer">
                                    <option value="">Select Buyer</option>
                                    @foreach($buyers as $buyer)
                                        <option value="{{ $buyer->id }}">{{ $buyer->buyer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="po_update_plant">Plant <span style="color: red;">*</span></label>
                                <select class="form-control" style="width: 100%;" id="po_update_plant">
                                    <option value="">Select Plant</option>
                                    @foreach($plants as $plant)
                                        <option value="{{ $plant->id }}">{{ $plant->plant_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="poInfoUpdate()">SAVE</button>
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

        function searchPOs() {
            var plant_id = $("#plant_filter").val();
            var buyer_id = $("#buyer_filter").val();
            var po_filter = $("#po_filter").val();

//        Ship Date Range Start
            var ship_dt_range_filter = $("#ship_date_range_filter").val();
            var ship_date_range_filter = ship_dt_range_filter.split(" - ");

            var ship_date_from = ship_date_range_filter[0];
            var ship_date_to = (ship_date_range_filter[1] != undefined ? ship_date_range_filter[1] : '');
//        Ship Date Range End

            if(plant_id=='' && buyer_id=='' && po_filter=='' && (ship_date_from=='' || ship_date_from==undefined) && (ship_date_to==''  || ship_date_to==undefined)){
                $("#modal-lg-0").modal('show');
            }else{
                $(".loader").css('display', 'block');
                $("#table_id").empty();

                $.ajax({
                    url: "{{ route("search_po") }}",
                    type:'POST',
                    data: {_token:"{{csrf_token()}}", plant_id: plant_id, buyer_id: buyer_id, po_filter: po_filter, ship_date_from: ship_date_from, ship_date_to: ship_date_to},
                    dataType: "html",
                    success: function (data) {
                        $("#table_id").append(data);
                        $(".loader").css('display', 'none');
                    }
                });
            }

        }
        
        function deletePoModal() {
            $("#modal-lg-1").modal('show');
        }
        
        function deletePOs() {
            var po_ids = [];
            $('input.checkItem:checkbox:checked').each(function () {
                var sThisVal = $(this).val();

                po_ids.push(sThisVal);
            });

            if(po_ids.length > 0){
                $.ajax({
                    url: "{{ route("delete_po") }}",
                    type:'POST',
                    data: {_token:"{{csrf_token()}}", po_ids: po_ids},
                    dataType: "json",
                    success: function (data) {
                        if(data == "success"){
                            $("#modal-lg-1").modal('hide');
                            $("#search_btn").click();
                        }
                    }
                });
            }else{
                $("#modal-lg-1").modal('hide');
                $("#modal-lg-0").modal('show');
            }
        }

        function assignTNAModal(){
            $("#modal-lg-2").modal('show');
        }
        
        function assignTNA() {
            var po_ids = [];
            $('input.checkItem:checkbox:checked').each(function () {
                var sThisVal = $(this).val();

                po_ids.push(sThisVal);
            });

            var assign_tna_id = $("#assign_tna_id").val();

            if(po_ids.length > 0 && assign_tna_id != ''){
                $(".loader").css('display', 'block');

                $.ajax({
                    url: "{{ route("assign_tna") }}",
                    type:'POST',
                    data: {_token:"{{csrf_token()}}", po_ids: po_ids, assign_tna_id: assign_tna_id},
                    dataType: "json",
                    success: function (data) {
                        if(data == "success"){
                            $(".loader").css('display', 'none');
                            $("#assign_tna_id").val("").change();
                            $("#modal-lg-2").modal('hide');
                            $("#search_btn").click();
                        }
                    }
                });
            }else{
                $("#modal-lg-2").modal('hide');
                $("#modal-lg-0").modal('show');
            }
        }

        function assignTNADetail(po_id){
            $("#tna_detail_id").empty();

            $.ajax({
                url: "{{ route("assign_tna_detail") }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}", po_id: po_id},
                dataType: "html",
                success: function (data) {

                    $("#tna_detail_id").append(data);
                    $("#modal-lg-3").modal('show');

                }
            });
        }

        function completePoTnaTerm(po_tna_term_id, po_id) {
            $.ajax({
                url: "{{ route("complete_po_tna_term") }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}", po_tna_term_id: po_tna_term_id},
                dataType: "json",
                success: function (data) {
                    if(data == 'success'){
                        assignTNADetail(po_id);
                    }
                }
            });
        }

        function setPoTnaTermRemarksModal(po_tna_term_id, po_id) {
            $("#po_tna_remarks").val('');
            $("#remarks_po_id").val('');
            $("#remarks_po_tna_term_id").val('');

            $("#remarks_po_id").val(po_id);
            $("#remarks_po_tna_term_id").val(po_tna_term_id);

            $("#modal-lg-3").modal('hide');
            $("#modal-lg-4").modal('show');
        }

        function setPoTnaTermRemarks() {
            var po_id = $("#remarks_po_id").val();
            var po_tna_term_id = $("#remarks_po_tna_term_id").val();
            var po_tna_remarks = $("#po_tna_remarks").val();

            $.ajax({
                url: "{{ route("set_po_tna_term_remarks") }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}", po_tna_term_id: po_tna_term_id, po_tna_remarks: po_tna_remarks},
                dataType: "json",
                success: function (data) {
                    if(data == 'success'){
                        $("#modal-lg-4").modal('hide');
                        assignTNADetail(po_id);
                    }
                }
            });
        }
        
        function changePlantModal() {
            $("#modal-lg-5").modal('show');
        }

        function changePlant() {
            var po_ids = [];
            $('input.checkItem:checkbox:checked').each(function () {
                var sThisVal = $(this).val();

                po_ids.push(sThisVal);
            });

            var change_plant_id = $("#change_plant_id").val();

            if(po_ids.length > 0){
                $.ajax({
                    url: "{{ route("change_plant") }}",
                    type:'POST',
                    data: {_token:"{{csrf_token()}}", po_ids: po_ids, change_plant_id: change_plant_id},
                    dataType: "json",
                    success: function (data) {
                        if(data == "success"){
                            $("#change_plant_id").val("").change();
                            $("#modal-lg-5").modal('hide');
                            $("#search_btn").click();
                        }
                    }
                });
            }else{
                $("#modal-lg-5").modal('hide');
                $("#modal-lg-0").modal('show');
            }
        }

        function changeShipDateModal() {
            $("#modal-lg-6").modal('show');
        }
        
        function changeShipDate() {
            var po_ids = [];
            $('input.checkItem:checkbox:checked').each(function () {
                var sThisVal = $(this).val();

                po_ids.push(sThisVal);
            });

            var change_ship_date = $("#change_ship_date").val();

            if(po_ids.length > 0 && change_ship_date != ''){
                $.ajax({
                    url: "{{ route("change_ship_date") }}",
                    type:'POST',
                    data: {_token:"{{csrf_token()}}", po_ids: po_ids, change_ship_date: change_ship_date},
                    dataType: "json",
                    success: function (data) {
                        if(data == "success"){
                            $("#change_ship_date").val("");
                            $("#modal-lg-6").modal('hide');
                            $("#search_btn").click();
                        }
                    }
                });
            }else{
                $("#modal-lg-6").modal('hide');
                $("#modal-lg-0").modal('show');
            }
        }

        function shipmentInfoUpdateModal(po_id) {
            $("#ship_info_po_id").val(po_id);
            $("#modal-lg-7").modal('show');
        }

        function shipmentInfoUpdate() {
            var actual_ship_date = $("#actual_ship_date").val();
            var actual_ship_qty = $("#actual_ship_qty").val();
            var po_id = $("#ship_info_po_id").val();
            var remarks = $("#remarks").val();

            if(actual_ship_date != '' && actual_ship_qty != ''){
                $.ajax({
                    url: "{{ route("shipment_info_update") }}",
                    type:'POST',
                    data: {_token:"{{csrf_token()}}", po_id: po_id, actual_ship_date: actual_ship_date, actual_ship_qty: actual_ship_qty, remarks: remarks},
                    dataType: "json",
                    success: function (data) {
                        if(data == "success"){
                            $("#actual_ship_date").val("");
                            $("#actual_ship_qty").val("");
                            $("#remarks").val("");
                            $("#modal-lg-7").modal('hide');
                            $("#search_btn").click();
                        }
                    }
                });
            }else{
                $("#modal-lg-7").modal('hide');
                $("#modal-lg-0").modal('show');
            }

        }

        function poInfoUpdateModal(po_id) {

            $.ajax({
                url: "{{ route("get_po_info") }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}", po_id: po_id},
                dataType: "json",
                success: function (data) {

                    if(data.length > 0){
                        $("#po_update_po_no").css('border-color', '');
                        $("#po_update_destination").css('border-color', '');
                        $("#po_update_style_no").css('border-color', '');
                        $("#po_update_style_name").css('border-color', '');
                        $("#po_update_quality").css('border-color', '');
                        $("#po_update_color").css('border-color', '');
                        $("#po_update_order_qty").css('border-color', '');
                        $("#po_update_ship_date").css('border-color', '');
                        $("#po_update_po_type").css('border-color', '');
                        $("#po_update_plant").css('border-color', '');
                        $("#po_update_buyer").css('border-color', '');

                        $("#po_info_update_po_id").val(po_id);
                        $("#po_update_po_no").val(data[0].po);
                        $("#po_update_destination").val(data[0].destination);
                        $("#po_update_style_no").val(data[0].style_no);
                        $("#po_update_style_name").val(data[0].style_name);
                        $("#po_update_quality").val(data[0].quality);
                        $("#po_update_color").val(data[0].color);
                        $("#po_update_plan_qty").val(data[0].plan_quantity);
                        $("#po_update_order_qty").val(data[0].order_quantity);
                        $("#po_update_ship_date").val(data[0].ship_date);
                        $("#po_update_confirm_date").val(data[0].order_confirm_date);
                        $("#po_update_po_remarks").val(data[0].remarks);

                        $('#po_update_po_type option').each(function(index) {
                            if (data[0].po_type == $(this).val()) {
                                $(this).attr('selected', 'selected');
                            }
                        });

                        $('#po_update_plant option').each(function(index) {
                            if (data[0].plant_id == $(this).val()) {
                                $(this).attr('selected', 'selected');
                            }
                        });

                        $('#po_update_buyer option').each(function(index) {
                            if (data[0].buyer_id == $(this).val()) {
                                $(this).attr('selected', 'selected');
                            }
                        });

                        $("#modal-lg-8").modal('show');
                    }

                }
            });

        }
        
        function poInfoUpdate() {
            var po_id = $("#po_info_update_po_id").val();

            var po_update_po_no = $("#po_update_po_no").val();
            if(po_update_po_no == ''){
                $("#po_update_po_no").css('border-color', 'red');
            }

            var po_update_destination = $("#po_update_destination").val();
            if(po_update_destination == ''){
                $("#po_update_destination").css('border-color', 'red');
            }

            var po_update_style_no = $("#po_update_style_no").val();
            if(po_update_style_no == ''){
                $("#po_update_style_no").css('border-color', 'red');
            }

            var po_update_style_name = $("#po_update_style_name").val();
            if(po_update_style_name == ''){
                $("#po_update_style_name").css('border-color', 'red');
            }

            var po_update_quality = $("#po_update_quality").val();
            if(po_update_quality == ''){
                $("#po_update_quality").css('border-color', 'red');
            }

            var po_update_color = $("#po_update_color").val();
            if(po_update_color == ''){
                $("#po_update_color").css('border-color', 'red');
            }

            var po_update_plan_qty = $("#po_update_plan_qty").val();

            var po_update_order_qty = $("#po_update_order_qty").val();
            if(po_update_order_qty == ''){
                $("#po_update_order_qty").css('border-color', 'red');
            }

            var po_update_ship_date = $("#po_update_ship_date").val();
            if(po_update_ship_date == ''){
                $("#po_update_ship_date").css('border-color', 'red');
            }

            var po_update_confirm_date = $("#po_update_confirm_date").val();

            var po_update_po_remarks = $("#po_update_po_remarks").val();

            var po_update_po_type = $('#po_update_po_type').val();
            if(po_update_po_type == ''){
                $("#po_update_po_type").css('border-color', 'red');
            }

            var po_update_plant = $('#po_update_plant').val();
            if(po_update_plant == ''){
                $("#po_update_plant").css('border-color', 'red');
            }

            var po_update_buyer = $('#po_update_buyer').val();
            if(po_update_buyer == ''){
                $("#po_update_buyer").css('border-color', 'red');
            }

            if(po_update_po_no != '' && po_update_destination != '' && po_update_style_no != '' && po_update_style_name != '' && po_update_quality != '' && po_update_color != '' && po_update_order_qty != '' && po_update_ship_date != '' && po_update_po_type != '' && po_update_plant != '' && po_update_buyer != ''){

                $.ajax({
                    url: "{{ route("po_info_update") }}",
                    type:'POST',
                    data: {_token:"{{csrf_token()}}", po_id: po_id, po_update_po_no: po_update_po_no, po_update_destination: po_update_destination, po_update_style_no: po_update_style_no, po_update_style_name: po_update_style_name, po_update_quality: po_update_quality, po_update_color: po_update_color, po_update_plan_qty: po_update_plan_qty, po_update_order_qty: po_update_order_qty, po_update_ship_date: po_update_ship_date, po_update_confirm_date: po_update_confirm_date, po_update_po_remarks: po_update_po_remarks, po_update_po_type: po_update_po_type, po_update_plant: po_update_plant, po_update_buyer: po_update_buyer},
                    dataType: "json",
                    success: function (data) {
                        if(data == "success"){
                            $("#modal-lg-8").modal('hide');
                            $("#po_update_po_no").css('border-color', '');
                            $("#po_update_destination").css('border-color', '');
                            $("#po_update_style_no").css('border-color', '');
                            $("#po_update_style_name").css('border-color', '');
                            $("#po_update_quality").css('border-color', '');
                            $("#po_update_color").css('border-color', '');
                            $("#po_update_order_qty").css('border-color', '');
                            $("#po_update_ship_date").css('border-color', '');
                            $("#po_update_po_type").css('border-color', '');
                            $("#po_update_plant").css('border-color', '');
                            $("#po_update_buyer").css('border-color', '');

                            $("#search_btn").click();
                        }
                    }
                });

            }

        }
    </script>

@endsection
