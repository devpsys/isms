@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Teachers</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Manage</a></li>
                        <li class="breadcrumb-item active">Teachers</li>
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
                            <h3 class="card-title">Available Teachers</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 8%">Staff No.</th>
                                    <th>Title</th>
                                    <th>Full Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th style="width: 17%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <form method="post" action="{{route('manage.teachers.store')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" id="id">
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>
                                            <select class="form-control select2" name="title" id="title"
                                                    style="width: 100%;" required>
                                                <option>Select Title</option>
                                                <option value="Malam">Malam</option>
                                                <option value="Malama">Malama</option>
                                                <option value="Ustaz">Ustaz</option>
                                                <option value="Ustaziya">Ustaziya</option>
                                                <option value="Sheikh">Sheikh</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="fullname" id="fullname"
                                                   placeholder="Full Name">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="gsm" id="gsm"
                                                   placeholder="Phone Number">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="address" id="address"
                                                   placeholder="Address">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                                <i class="fa fa-save"></i> Save
                                            </button>
                                        </td>
                                    </tr>
                                </form>
                                @if(count($teachers)==0)
                                    <tr>
                                        <td colspan="7" style="text-align: center; font-size: 1.5em">
                                            No teacher added yet. Use the form above to add a teacher.
                                        </td>
                                    </tr>
                                @elseif(count($teachers)>0)
                                    @foreach($teachers as $teacher)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>&nbsp;</td>
                                            <td>{{ $teacher->title }}</td>
                                            <td>{{ $teacher->fullname }}</td>
                                            <td>{{ $teacher->gsm }}</td>
                                            <td>{{ $teacher->address }}</td>
                                            <td>
                                                <a class="btn btn-outline-primary btn-sm edit"
                                                   data-id="{{ $teacher->id }}" data-title="{{ $teacher->title }}"
                                                   data-name="{{ $teacher->fullname }}" data-gsm="{{ $teacher->gsm }}"
                                                   data-address="{{ $teacher->address }}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                &nbsp;
                                                <a class="btn btn-outline-danger btn-sm delete" data-toggle="modal"
                                                   data-id="{{ $teacher->id }}" data-target="#modal-delete">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
                        <h4 class="modal-title">Delete Teacher</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this teacher?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <form action="{{route('manage.teachers.destroy')}}" method="post">
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
                $('#title').val($(this).data('title'))
                $('#fullname').val($(this).data('name'))
                $('#gsm').val($(this).data('gsm'))
                $('#address').val($(this).data('address'))
            })
            $(document).on('click', '.delete', function () {
                $('#del-id').val($(this).data('id'))
            })
        })
    </script>
@endsection
