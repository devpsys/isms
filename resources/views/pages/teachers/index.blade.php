@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endsection
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
                                    <th style="width: 32%">Actions</th>
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
                                                   placeholder="Full Name" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="gsm" id="gsm"
                                                   placeholder="Phone Number" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="address" id="address"
                                                   placeholder="Address" required>
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
                                            <td>{{ $teacher->staff_number }}</td>
                                            <td>{{ $teacher->title }}</td>
                                            <td>{{ $teacher->fullname }}</td>
                                            <td>{{ $teacher->gsm }}</td>
                                            <td>{{ $teacher->address }}</td>
                                            <td>
                                                <a style="font-size: 0.8em"
                                                   class="btn btn-outline-success btn-sm assign" data-toggle="modal"
                                                   data-target="#modal-assign" data-id="{{ $teacher->id }}">
                                                    <i class="fa fa-link"></i> Assign Subject(s)
                                                </a>
                                                &nbsp;
                                                <a style="font-size: 0.8em" class="btn btn-outline-primary btn-sm edit"
                                                   data-id="{{ $teacher->id }}" data-title="{{ $teacher->title }}"
                                                   data-name="{{ $teacher->fullname }}" data-gsm="{{ $teacher->gsm }}"
                                                   data-address="{{ $teacher->address }}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                &nbsp;
                                                <a style="font-size: 0.8em" class="btn btn-outline-danger btn-sm delete"
                                                   data-toggle="modal"
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

        <div class="modal fade" id="modal-assign">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Assign Subject(s)</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="subjects-form" action="#" method="post">
                        <div class="modal-body">
                            {{csrf_field()}}
                            <input type="hidden" name="teacher_id" id="teacher-id">
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label>Session</label>
                                    <select class="form-control" name="session_id" id="session_id" required>
                                        <option value="">Select Session</option>
                                        @foreach(\App\Models\Session::orderBy('session','desc')->get() as $session)
                                            <option value="{{ $session->id }}">{{ $session->session }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 form-group">
                                    <label>Class</label>
                                    <select class="form-control" name="class_id" id="klass" required>
                                        <option value="">Select Class</option>
                                        @foreach(\App\Models\Klass::all() as $class)
                                            <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="subjects">
                                <table class="table table-bordered table-head-fixed table-sm text-nowrap">
                                    <thead>
                                    <tr>
                                        <th style="width:5%">#</th>
                                        <th>Subject</th>
                                        <th style="text-align: center; width:20%">
                                            {{--                                            <span>Assign All</span>--}}
                                            <input type="checkbox" id="checkAll">
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="subjects-body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">
                                Assign
                            </button>
                        </div>
                    </form>
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
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.assign', function () {
                $('#teacher-id').val($(this).data('id'))
            })

            $('#klass').on('change', function () {
                $('#subjects-body').html('')

                let teacher_id = $(this).data('id')

                $.get('{{ route('manage.teachers.teacher.subjects',[':session', ':class', ':teacher']) }}'
                        .replace(':session', $('#session_id').val()).replace(':class', $('#klass').val())
                        .replace(':teacher', teacher_id),
                    function (data) {

                        let rows = ''
                        let all = true
                        $.each(data, function (i, v) {
                            if (v.assigned === 0)
                                all = false
                            rows += `<tr>
                                        <td>${i + 1}</td>
                                        <td>${v.title}</td>
                                        <td style='text-align: center;'>
                                            <input type='checkbox' class='checkbox' name='subjects[]' value='${v.id}' ${v.assigned == 1 ? 'checked' : ''} >
                                        </td>
                                    </tr>`
                        })

                        $('#subjects-body').html(rows)
                        $('#checkAll').prop("checked", all)
                    })
            })

            //  On Submit
            $('#subjects-form').on('submit', function (e) {
                e.preventDefault()

                $.post('{{route('manage.teachers.assign')}}', $(this).serialize(), function (data) {
                    let response = JSON.parse(data)
                    if (response.success) toastr.success(response.message)
                    else toastr.error(response.message)

                    $('#modal-assign').modal('hide')
                })
            })

            $('#checkAll').on('click', function () {
                if ($(this).is(":checked"))
                    $('.checkbox').prop("checked", true);
                else $('.checkbox').prop("checked", false);
            })

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
