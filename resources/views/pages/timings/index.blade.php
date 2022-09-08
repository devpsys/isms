@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Timings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Manage</a></li>
                        <li class="breadcrumb-item active">Timings</li>
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
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Available Timings</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th>Starting Time</th>
                                    <th>Ending Time</th>
                                    <th style="width: 17%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <form method="post" action="{{route('manage.timings.store')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" id="id">
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <input type="time" class="form-control" name="time_from" id="time_from"
                                                   placeholder="Starting Time" required>
                                        </td>
                                        <td>
                                            <input type="time" class="form-control" name="time_to" id="time_to"
                                                   placeholder="Ending Time" required>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                                <i class="fa fa-save"></i> Save
                                            </button>
                                        </td>
                                    </tr>
                                </form>
                                @foreach($timings as $timing)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ $timing->time_from }}</td>
                                        <td>{{ $timing->time_to }}</td>
                                        <td>
                                            <a class="btn btn-outline-primary btn-sm edit"
                                               data-id="{{ $timing->id }}" data-time-to="{{ $timing->time_to }}"
                                               data-time-from="{{ $timing->time_from }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            &nbsp;
                                            <a class="btn btn-outline-danger btn-sm delete" data-toggle="modal"
                                               data-id="{{ $timing->id }}" data-target="#modal-delete">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
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
                        <h4 class="modal-title">Delete Timing</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this timing?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <form action="{{route('manage.timings.destroy')}}" method="post">
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
    <script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('body').on('click', '.edit', function () {

                $('#id').val($(this).data('id'))
                $('#time_from').val($(this).data('time-from'))
                $('#time_to').val($(this).data('time-to'))
            })
            $(document).on('click', '.delete', function () {
                $('#del-id').val($(this).data('id'))
            })
        })
    </script>
@endsection
