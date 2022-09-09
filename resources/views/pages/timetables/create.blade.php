@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Time Table</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Time Table</a></li>
                        <li class="breadcrumb-item active">Create Time Table</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">New Time Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Sections</label>
                                    <select class="select2" name="section_ids" id="section" multiple="multiple"
                                            data-placeholder="Select Section" style="width: 100%;">
                                        @foreach(\App\Models\Section::all() as $section)
                                            <option value="{{ $section->id }}">{{  $section->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Sessions</label>
                                    <select class="select2" name="session_ids" id="session" multiple="multiple"
                                            data-placeholder="Select Session" style="width: 100%;">
                                        @foreach(\App\Models\Session::orderBy('session','desc')->get() as $session)
                                            <option value="{{ $session->id }}">{{  $session->session }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Term</label>
                                    <input type="text" class="form-control" id="term" name="term"
                                           placeholder="Term" required>
                                </div>
                                <button type="submit" class="btn btn-outline-primary pull-right" style="width:100%">
                                    Generate
                                </button>
                            </div>
                            <!-- /.card-body -->
                        </form>

                        {{--                        <div class="card-body">--}}
                        {{--                            <div>--}}

                        {{--                            </div>--}}

                        {{--                            <table class="table table-bordered">--}}
                        {{--                                <thead>--}}
                        {{--                                <tr>--}}
                        {{--                                    <th style="width: 15px">#</th>--}}
                        {{--                                    <th>Section</th>--}}
                        {{--                                    <th>Session</th>--}}
                        {{--                                    <th>Term</th>--}}
                        {{--                                    <th>Published on</th>--}}
                        {{--                                    <th>Actions</th>--}}
                        {{--                                </tr>--}}
                        {{--                                </thead>--}}
                        {{--                                <tbody>--}}

                        {{--                                </tbody>--}}
                        {{--                            </table>--}}
                        {{--                        </div>--}}
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Time Table</h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <div>

                            </div>

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 15px">#</th>
                                    <th>Section</th>
                                    <th>Session</th>
                                    <th>Term</th>
                                    <th>Published on</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.container-fluid -->

        <div class="modal fade" id="modal-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Section</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this section?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <form action="{{route('manage.sessions.destroy')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="id" id="del-id">
                            <button type="submit" class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                        {{--                        <button type="button" class="btn btn-danger"></button>--}}
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

        })
    </script>
@endsection
