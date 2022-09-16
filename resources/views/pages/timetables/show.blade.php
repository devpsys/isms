@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Time Table</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Time Table</a></li>
                        <li class="breadcrumb-item active">{{ $timetable->session->session }}</li>
                    </ol>
                </div><!-- /.col -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @php
                                $info = json_decode($timetable->config);

                            @endphp

                            @foreach($info->schedules as $key=>$schedule)
                                <h3>Schedule #{{$loop->iteration}}</h3>
                                <table class="table table-bordered" border="1">
                                    <tr>
                                        <th>Days</th>
                                        <th>Class</th>
                                        @foreach($info->timing as $time)
                                            <th>{{$time->time}}</th>
                                        @endforeach
                                    </tr>
                                    @foreach($info->days as $d=>$day)
                                        @foreach($info->classes as $class)
                                            @if($loop->index==0)
                                                <tr>
                                                    <th class="day" rowspan="{{count($info->classes)}}">{{$day}}</th>
                                                    <th>{{$class}}</th>
                                                    @foreach($info->timing as $time)
                                                        @php $tt = $time->time; @endphp
                                                        @if(isset($schedule->$d->$class->$tt ))
                                                            @php  $teacher = \App\Models\Teacher::find($schedule->$d->$class->$tt->instructor); @endphp
                                                            <td>
                                                                {{$schedule->$d->$class->$tt->subject}} <br>
                                                                <strong>{{$teacher->title . " ".$teacher->fullname}}</strong>
                                                            </td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @else
                                                <tr>
                                                    <th>{{$class}}</th>
                                                    @foreach($info->timing as $time)
                                                        @php $tt = $time->time; @endphp
                                                        @if(isset($schedule->$d->$class->$tt ))
                                                            @php  $teacher = \App\Models\Teacher::find($schedule->$d->$class->$tt->instructor); @endphp
                                                            <td>
                                                                {{$schedule->$d->$class->$tt->subject}} <br>
                                                                <strong>{{$teacher->title . " ".$teacher->fullname}}</strong>
                                                            </td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </table>
                            @endforeach



                            <style>
                                .day {
                                    writing-mode: vertical-rl;
                                    text-orientation: mixed;
                                }
                            </style>

                        </div>
                    </div>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
        })
    </script>
@endsection
