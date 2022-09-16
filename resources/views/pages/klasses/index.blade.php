@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Classes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Manage</a></li>
                        <li class="breadcrumb-item active">Classes</li>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Available Classes</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="post" id="qwerty" action="{{ route('manage.classes.store') }}">
                                {{csrf_field()}}
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 5%; text-align:center;">#</th>
                                        <th>Class Name</th>
                                        <th>Section</th>
                                        <th style="width: 20%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <input type="hidden" name="id" id="id">
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <input type="text" class="form-control" name="class_name" id="class_name"
                                                   placeholder="Section Name" required>
                                        </td>
                                        <td>
                                            <select class="form-control select2" name="section_id" id="section_id"
                                                    style="width: 100%;" required>
                                                <option>Select Section</option>
                                                @foreach(\App\Models\Section::all() as $section)
                                                    <option value="{{ $section->id }}">
                                                        {{ $section->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            &nbsp;
                                            <button type="submit" class="btn btn-outline-success btn-sm">
                                                <i class="fa fa-save"></i> Save
                                            </button>
                                        </td>
                                    </tr>
                                    @foreach($klasses as $klass)
                                        <tr>
                                            <td style="width: 5%; text-align:center;">{{$loop->iteration}}</td>
                                            <td>{{ $klass->class_name }}</td>
                                            <td>{{ $klass->title }}</td>
                                            <td>
                                                {{--                                                <a style="font-size: 0.8em" class="btn btn-outline-success btn-sm assign">--}}
                                                {{--                                                    <i class="fa fa-link"></i> Assign Subject(s)--}}
                                                {{--                                                </a>--}}
                                                {{--                                                &nbsp;--}}
                                                <a style="font-size: 0.8em" class="btn btn-outline-primary btn-sm edit"
                                                   data-id="{{ $klass->id }}" data-class-name="{{ $klass->class_name }}"
                                                   data-section-id="{{ $klass->section_id }}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                &nbsp;
                                                <a style="font-size: 0.8em" class="btn btn-outline-danger btn-sm delete"
                                                   data-toggle="modal"
                                                   data-id="{{ $klass->id }}" data-target="#modal-delete">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </form>
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
                        <h4 class="modal-title">Delete Class</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this class?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <form action="{{route('manage.classes.destroy')}}" method="post">
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
            $(document).on('click', '.edit', function () {
                $('#id').val($(this).data('id'))
                $('#class_name').val($(this).data('class-name'))
                $('#section_id').val($(this).data('section-id'))
            })

            $(document).on('click', '.delete', function () {
                $('#del-id').val($(this).data('id'))
            })
        })
    </script>
@endsection
