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
                        <h1>Shipment Forecast Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Shipment Forecast Report</li>
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
                                            <button class="form-control btn btn-primary" id="search_btn" onclick="getShipmentForecastChart()">SEARCH</button>
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

                            <!-- Main content -->
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <!-- PIE CHART -->
                                            <div class="card card-danger">
                                                <div class="card-header">
                                                    <h3 class="card-title">Forecast - Pie Chart</h3>

                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <canvas id="pieChart" style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>

                                                    <div class="table-responsive p-0 tableFixHead mt-2">
                                                        <table id="table_id" class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center td" style="background-color: #bef3de" colspan="2">TOTAL</th>
                                                                    <th class="text-center td" style="background-color: #b3f397" colspan="2">ONTIME</th>
                                                                    <th class="text-center td" style="background-color: #f3baba" colspan="2">DELAY</th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-center td" style="background-color: #bef3de">POs</th>
                                                                    <th class="text-center td" style="background-color: #bef3de">POs Qty</th>
                                                                    <th class="text-center td" style="background-color: #b3f397">POs</th>
                                                                    <th class="text-center td" style="background-color: #b3f397">Qty</th>
                                                                    <th class="text-center td" style="background-color: #f3baba">POs</th>
                                                                    <th class="text-center td" style="background-color: #f3baba">Qty</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center" id="total_pos" style="background-color: #bef3de">0</td>
                                                                    <td class="text-center" id="total_pos_qty" style="background-color: #bef3de">0</td>
                                                                    <td class="text-center" id="ontime_shipment" style="background-color: #b3f397">0</td>
                                                                    <td class="text-center" id="ontime_shipment_qty" style="background-color: #b3f397">0</td>
                                                                    <td class="text-center" id="delay_shipment" style="background-color: #f3baba">0</td>
                                                                    <td class="text-center" id="delay_shipment_qty" style="background-color: #f3baba">0</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->

                                        </div>
                                        <!-- /.col (LEFT) -->

                                    </div>
                                    <!-- /.row -->
                                </div><!-- /.container-fluid -->
                            </section>
                            <!-- /.content -->
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
    <script>
        function getShipmentForecastChart() {
            var plant_id = $("#plant_filter").val();
            var buyer_id = $("#buyer_filter").val();

//        Ship Date Range Start
            var ship_dt_range_filter = $("#ship_date_range_filter").val();
            var ship_date_range_filter = ship_dt_range_filter.split(" - ");

            var ship_date_from = ship_date_range_filter[0];
            var ship_date_to = (ship_date_range_filter[1] != undefined ? ship_date_range_filter[1] : '');
//        Ship Date Range End

            $(".loader").css('display', 'block');

            $.ajax({
                url: "{{ route("get_shipment_forecast_data") }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}", plant_id: plant_id, buyer_id: buyer_id, ship_date_from: ship_date_from, ship_date_to: ship_date_to},
                dataType: "json",
                success: function (data) {
                    var total_pos = data.total_pos;
                    var total_pos_sum_order = data.total_pos_sum_order;
                    var total_ontime_shipment = data.total_ontime_shipment;
                    var total_ontime_shipment_quantity = data.total_ontime_shipment_quantity;
                    var total_delay_shipment = data.total_delay_shipment;
                    var total_delay_shipment_quantity = data.total_delay_shipment_quantity;


                    var ontime_shipment_percentage = ((total_ontime_shipment / total_pos) * 100).toFixed(2);
                    ontime_shipment_percentage = (!isNaN(ontime_shipment_percentage) ? ontime_shipment_percentage : 0);
                    var delay_shipment_percentage = ((total_delay_shipment / total_pos) * 100).toFixed(2);
                    delay_shipment_percentage = (!isNaN(delay_shipment_percentage) ? delay_shipment_percentage : 0);

                    var data_array = [];
                    data_array.push(delay_shipment_percentage);
                    data_array.push(ontime_shipment_percentage);

                    var pieData = {
                        labels: [
                            'Delay Shipment',
                            'On-Time Shipment',
                        ],
                        datasets: [
                            {
                                data: data_array,
                                backgroundColor : ['#f56954', '#00a65a',],
                            }
                        ]
                    }

                    //-------------
                    //- PIE CHART -
                    //-------------
                    // Get context with jQuery - using jQuery's .get() method.
                    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                    var pieOptions     = {
                        maintainAspectRatio : false,
                        responsive : true,
                    }
                    //Create pie or douhnut chart
                    // You can switch between pie and douhnut using the method below.
                    chart = new Chart(pieChartCanvas, {
                        type: 'pie',
                        data: pieData,
                        options: pieOptions
                    });


//                    Summary Table Start
                    $("#total_pos").text(total_pos);
                    $("#total_pos_qty").text(total_pos_sum_order);
                    $("#ontime_shipment").text(total_ontime_shipment+"("+ontime_shipment_percentage+"%)");
                    $("#ontime_shipment_qty").text(total_ontime_shipment_quantity);
                    $("#delay_shipment").text(total_delay_shipment+"("+delay_shipment_percentage+"%)");
                    $("#delay_shipment_qty").text(total_delay_shipment_quantity);
//                    Summary Table End

                    $(".loader").css('display', 'none');
                }
            });

        }
    </script>
@endsection