@extends((Auth::user()->is_admin == 1) ? 'layouts.admin_app' : 'layouts.user_app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User List</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
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
                    <form action="{{ route('user.update', $user->id) }}" method="post">

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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $user->name }}" autocomplete="off">
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email <span style="color: red">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $user->email }}" autocomplete="off">
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_admin">Is Admin? <span style="color: red">*</span></label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="is_admin" id="is_admin">
                                        <option value="">Select Type</option>
                                        <option value="1" @if($user->is_admin == 1) selected="selected" @endif>Yes</option>
                                        <option value="0" @if($user->is_admin == 0) selected="selected" @endif>No</option>
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span style="color: red">*</span></label>
                                    <select class="form-control select2bs4" style="width: 100%;" name="status" id="status">
                                        <option value="">Select Status</option>
                                        <option value="1" @if($user->status == 1) selected="selected" @endif>Active</option>
                                        <option value="0" @if($user->status == 0) selected="selected" @endif>Inactive</option>
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_type">User Type </label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="user_type" id="user_type">
                                            <option value="">Select User Type</option>
                                            @foreach($user_types as $user_type)
                                                <option value="{{ $user_type->id }}"
                                                        @if($user->user_type == $user_type->id) selected="selected" @endif>
                                                    {{ $user_type->user_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Default Password </label>
                                        <input type="text" class="form-control" id="password" name="password" placeholder="Enter Password" autocomplete="off" value="">
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">

                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
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
@endsection