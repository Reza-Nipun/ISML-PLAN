@extends((Auth::user()->is_admin == 1) ? 'layouts.admin_app' : 'layouts.user_app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit TNA</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tna.index') }}">TNA List</a></li>
                            <li class="breadcrumb-item active">Edit TNA</li>
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
                    <form action="{{ route('tna.update', $tna->id) }}" method="post">

                        @csrf
                        @method('PUT')

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
                                    <input type="text" class="form-control" id="tna_name" name="tna_name" placeholder="Enter TNA Name" value="{{ $tna->tna_name }}" autocomplete="off" required="required" />
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status <span style="color: red">*</span></label>
                                    <select class="form-control" id="status" name="status" required="required">
                                        <option value="">Select Status</option>
                                        <option value="1" @if($tna->status == 1) selected="selected" @endif>Active</option>
                                        <option value="0" @if($tna->status == 0) selected="selected" @endif>Inactive</option>
                                    </select>
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
                                        @foreach($tna_terms as $tna_term)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="text" id="" class="form-control" name="tna_term_old[]" value="{{ $tna_term->tna_term }}" required="required" autocomplete="off">
                                                    <input type="hidden" id="" class="form-control" name="tna_term_id[]" value="{{ $tna_term->id }}" required="required" autocomplete="off" readonly="readonly">
                                                </td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control" name="days_old[]" value="{{ $tna_term->days }}" required="required" autocomplete="off">
                                                </td>
                                                <td class="text-center">
                                                    <select class="form-control" name="responsible_department_old[]" required="required">
                                                        <option value="">Select Department</option>

                                                        @foreach($user_types AS $user_type)
                                                            <option value="{{ $user_type->id }}" @if($tna_term->responsible_user_type == $user_type->id) selected="selected" @endif>
                                                                {{ $user_type->user_type }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="tna_term_status_old[]" @if($tna_term->status == 1) checked="checked" @endif  value="{{ $tna_term->status }}">
                                                </td>
                                                <td class="text-center">

                                                </td>
                                            </tr>
                                        @endforeach
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
            $.ajax({
                url: "{{ route("add_new_tna_row") }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}"},
                dataType: "html",
                success: function (data) {
                    $("#tna_table > tbody").append(data);
                }
            });
        }

        $("#tna_table").on("click", "#DeleteTnaTermButton", function() {
            $(this).closest("tr").remove();
        });

    </script>

@endsection