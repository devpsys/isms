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
                            @php $tt = $time->time;  @endphp
                            @if(isset($schedule->$d->$class->$tt ))
                                <td>
                                    {{$schedule->$d->$class->$tt->subject}}
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
                            @php $tt =$time->time;  @endphp
                            @if(isset($schedule->$d->$class->$tt ))
                                <td>
                                    {{$schedule->$d->$class->$tt->subject}}
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
