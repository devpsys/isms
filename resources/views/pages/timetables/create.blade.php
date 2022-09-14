@extends('layouts.app')
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
            <form action="{{route('timetables.generate')}}" method="post" id="genFrm">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">New Time Table</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Sections</label>
                                            <select class="form-control select2" name="section_id" id="section"
                                                    data-placeholder="Select Section" style="width: 100%;">
                                                <option value="">Select Section</option>
                                                @foreach(\App\Models\Section::all() as $section)
                                                    <option value="{{ $section->id }}">{{  $section->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Sessions</label>
                                            <select class="form-control select2" name="session_id" id="session"
                                                    data-placeholder="Select Session" style="width: 100%;">
                                                <option value="">Select Session</option>
                                                @foreach(\App\Models\Session::orderBy('session','desc')->get() as $session)
                                                    <option value="{{ $session->id }}">{{  $session->session }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Time From</label>
                                            <input type="time" class="form-control" name="time_from" id="time_from"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Time To</label>
                                            <input type="time" class="form-control" name="time_to" id="time_to"
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-6 form-group">
                                        <label>Period Length</label>
                                        <input type="number" class="form-control" placeholder="Length in minutes"
                                               name="time_length" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label>Days</label>
                                    <div class="row form-group clearfix">
                                        <div class="col-3">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="SU" value="SU" name="days[]">
                                                <label for="SU">SUN</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="mo" value="MO" name="days[]">
                                                <label for="mo">MON</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="tu" value="TU" name="days[]">
                                                <label for="tu">TUE</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="we" value="WE" name="days[]">
                                                <label for="we">WED</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-3">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="th" value="TH" name="days[]">
                                                <label for="th">THU</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="fr" value="FR" name="days[]">
                                                <label for="fr">FRI</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="st" value="SA" name="days[]">
                                                <label for="st">SAT</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Subjects</h3>
                            </div>
                            <div class="card-body" id="loadArea">

                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>

                <!-- /.col -->
            </form>
            <div class="row">


                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Time Table</h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body" id="loadTimetable">
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
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
        function loadSubjects(session, section) {
            if (section && session) {
                $.ajax({
                    data: {session: session, section: section, _token: "{{csrf_token()}}"},
                    type: "POST",
                    url: "{{route('timetables.assigned.subject')}}",
                    success: function (data) {
                        $("#loadArea").html(data);
                    }
                });
            }
        }

        $(document).ready(function () {
            $("#session,#section").on("change", function () {
                loadSubjects($("#session").val(), $("#section").val());
            });

            $("body").on('click', "#genBtn", function (e) {
                e.preventDefault();
                $.ajax({
                    type: "get",
                    data: $("#genFrm").serialize(),
                    url:$("#genFrm").attr('action'),
                    success:function (data){
                        $("#loadTimetable").html(data);
                    }
                });
                // console.log();
            });

        })
    </script>
@endsection
