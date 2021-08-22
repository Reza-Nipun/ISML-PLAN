@extends((Auth::user()->is_admin == 1) ? 'layouts.admin_app' : 'layouts.user_app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Excel Upload</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('po.index') }}">PO List</a></li>
                            <li class="breadcrumb-item active">Excel Upload</li>
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
                            <a href="{{ asset('storage/po_file_format.xlsx') }}" class="btn btn-sm btn-info">
                                <i class="fas fa-file-download"></i> Excel Format
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ route('upload_file') }}" method="post" enctype="multipart/form-data">

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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="plant">Plant <span style="color: red">*</span></label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="plant" id="plant">
                                            <option value="">Select Plant</option>

                                            @foreach($plants as $plant)
                                                <option value="{{ $plant->id }}">{{ $plant->plant_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="buyer">Buyer <span style="color: red">*</span></label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="buyer" id="buyer">
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
                                        <label for="po_type">PO Type <span style="color: red">*</span></label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="po_type" id="po_type">
                                            <option value="">Select Type</option>
                                            <option value="0">Bulk</option>
                                            <option value="1">Sample</option>
                                            <option value="2">Size-Set</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Select File <span style="color: red">*</span></label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="upload_file">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">UPLOAD</button>
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

    </script>

@endsection