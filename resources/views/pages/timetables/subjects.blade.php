<form action="{{route('timetables.generate')}}" method="post">
    <input type="hidden" name="session" value="{{$session}}" >
    @csrf
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Subject</th>
            <th>Times a week</th>
        </tr>
        </thead>
        <tbody>

        @foreach($subjects as $subject)
            <tr>
                <td width="70%">
                    <span class="text-info">{{$subject->subject}}</span>
                    &mdash; <span class="text-warning">{{$subject->class}}</span> by
                    <span class="text-danger">{{$subject->teacher}}</span>
                </td>
                <th><input type="number" name="subject[{{$subject->id}}]" class="form-control" value="1"></th>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <th colspan="2">
            <button type="submit" class="btn btn-outline-primary pull-right" style="width:100%">
                Generate
            </button>
        </th>
        </tfoot>
    </table>

</form>
