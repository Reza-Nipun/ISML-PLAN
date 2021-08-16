@extends((Auth::user()->user_type == 0) ? 'layouts.admin_app' : 'layouts.user_app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create TNA</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tna.index') }}">TNA List</a></li>
                            <li class="breadcrumb-item active">Create TNA</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Form</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ route('tna.store') }}" method="post">

                        @csrf

                    <div class="card-body">

                        @if($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li >{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                {!! \Session::get('success') !!}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tna_name">TNA Name <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="tna_name" name="tna_name" placeholder="Enter TNA Name" value="{{ old('tna_name') }}" autocomplete="off">
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="card-body">
                                <table id="tna_table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center">TNA Term</th>
                                        <th class="text-center">Days</th>
                                        <th class="text-center">Responsible Department</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">
                                            <span class="btn btn-sm btn-success" onclick="addNewTNA()">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                    <!-- /.card-footer -->
                    </form>
                </div>
                <!-- /.card -->

                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <script type="text/javascript">

        function addNewTNA(){
            $("#tna_table > tbody").append('<tr><td class="text-center"><input type="text" id="" class="form-control" name="tna_term[]" required="required" autocomplete="off"></td><td class="text-center"><input type="number" class="form-control" name="days[]" required="required" autocomplete="off"></td><td class="text-center"><select class="form-control" name="responsible_department[]" required="required"><option value="">Select Department</option><option value="1">SD</option><option value="2">Commercial</option><option value="3">Planner</option><option value="4">Store</option></select></td><td class="text-center"><input type="checkbox" name="tna_term_status[]" checked="checked" value="1"></td><td class="text-center"><span class="btn btn-sm btn-danger" id="DeleteTnaTermButton"><i class="fas fa-trash"></i></span></td></tr>');
        }

        $("#tna_table").on("click", "#DeleteTnaTermButton", function() {
            $(this).closest("tr").remove();
        });

    </script>

@endsection