<?php

namespace App\Http\Controllers;

use App\Http\Requests\Timetables\Create;
use App\Http\Requests\Timetables\Destroy;
use App\Http\Requests\Timetables\Edit;
use App\Http\Requests\Timetables\Index;
use App\Http\Requests\Timetables\Show;
use App\Http\Requests\Timetables\Store;
use App\Http\Requests\Timetables\Update;
use App\Models\Klass;
use App\Models\KlassSubjectTeacher;
use App\Models\Section;
use App\Models\Session;
use App\Models\Teacher;
use App\Models\Timetable;
use App\TTAlgo\TheBox;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

;


/**
 * Description of TimetableController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */
class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Index $request
     * @return Application|Factory|View
     */
    public function index(Index $request)
    {
        $timetables = DB::table('timetables')
            ->join('sections', 'sections.id', '=', 'timetables.section_id')
            ->join('sessions', 'sessions.id', '=', 'timetables.session_id')
            ->select(['timetables.id', 'sections.title as section', 'sessions.session', 'timetables.term',
                'timetables.published'])
            ->get();


        return view('pages.timetables.index', compact('timetables'));
    }

    /**
     * Display the specified resource.
     *
     * @param Show $request
     * @param Timetable $timetable
     * @return Application|Factory|View
     */
    public function show(Show $request, Timetable $timetable)
    {
//        return $timetable->config;
        return view('pages.timetables.show', compact('timetable'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Create $request
     * @return Application|Factory|View
     */
    public function create(Create $request)
    {
        return view('pages.timetables.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return Response
     */
    public function store(Store $request)
    {
        $model = new Timetable;
        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'Timetable saved successfully');
            return redirect()->route('timetables.index');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Timetable');
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Edit $request
     * @param Timetable $timetable
     * @return Response
     */
    public function edit(Edit $request, Timetable $timetable)
    {
        $sessions = Session::all(['id']);
        $sections = Section::all(['id']);

        return view('pages.timetables.edit', [
            'model' => $timetable,
            "sessions" => $sessions,
            "sections" => $sections,

        ]);
    }

    /**
     * Update a existing resource in storage.
     *
     * @param Update $request
     * @param Timetable $timetable
     * @return Response
     */
    public function update(Update $request, Timetable $timetable)
    {
        $timetable->fill($request->all());

        if ($timetable->save()) {

            session()->flash('app_message', 'Timetable successfully updated');
            return redirect()->route('timetables.index');
        } else {
            session()->flash('app_error', 'Something is wrong while updating Timetable');
        }
        return redirect()->back();
    }

    /**
     * Delete a  resource from  storage.
     *
     * @param Destroy $request
     * @param Timetable $timetable
     * @return Response
     * @throws Exception
     */
    public function destroy(Destroy $request, Timetable $timetable)
    {
        if ($timetable->delete()) {
            session()->flash('app_message', 'Timetable successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Timetable');
        }

        return redirect()->back();
    }

    public function assignedSubject(Request $request)
    {
//        return $request;
        $session = $request->input("session");

        $subjects  = KlassSubjectTeacher::
                join("klasses","klasses.id","=","klass_subject_teachers.class_id")
                ->join("subjects","subjects.id","=","klass_subject_teachers.subject_id")
                ->join("teachers","teachers.id","=","klass_subject_teachers.teacher_id")
                ->select(DB::raw("CONCAT(teachers.title,' ',teachers.fullname) AS teacher"),"subjects.title AS subject","klasses.class_name AS class","klass_subject_teachers.*")
                ->where(["session_id"=>$session])->get();
        return \view("pages.timetables.subjects",compact('subjects','session'));
    }

    public function generate(Request $request)
    {
//        return $request;
        $timetable = Timetable::where([
            "section_id"=>$request->section_id,
            "session_id"=>$request->session_id
        ])->first();
        if(!$timetable){
            $timetable = new Timetable();
            $timetable->section_id = $request->section_id;
            $timetable->session_id = $request->session_id;
            $timetable->term = 1;
        }
        $date   = Carbon::parse("2022-01-01 {$request->time_from}:00");
        $dateTo = Carbon::parse("2022-01-01 {$request->time_to}:00");
        $days = $request->days;
        $dayMap = [
            "MO"=>"Monday","TU"=>"Tuesday","WE"=>"Wednesday",
            "TH"=>"Thursday","FR"=>"Friday","SA"=>"Saturday",
            "SU"=>"Sunday"
        ];

        $i = 1;
        $timings = [];
        while($date < $dateTo){
            $time = new \stdClass();
            $time->id = $i;
            $time->time_from = $date->format("h:i");
            $date->addMinutes($request->time_length);
            $time->time_to = $date->format("h:i");
            $time->time = $time->time_from."-".$time->time_to;
            $timings[] = $time;
            $timing[] = $time->time;
            $i++;
        }
//        return $timings;
        $session = $request->input("session");
        $teachers  = Teacher::whereIn('id',KlassSubjectTeacher::where(["session_id"=>$session])->pluck("teacher_id"))->get();
        $rooms = Klass::whereIn("id",KlassSubjectTeacher::where(["session_id"=>$session])->pluck("class_id"))->get();
        $courses = KlassSubjectTeacher::where(["session_id"=>$session])
            ->join("subjects","subjects.id","=","klass_subject_teachers.subject_id")
            ->select("subjects.title AS subject","klass_subject_teachers.*")
            ->get();

        $courseData = [];
        $clx = [];
        $z = 0;

        foreach ($courses as $course){
            if(isset($request->subject[$course->id])){
                $count = $request->subject[$course->id];
                for ($i=0;$i<$count;$i++){
                    $cls = new \stdClass();
                    $cls->id = $course->id.".".$i;
                    $cls->class_name = $course->subject;
                    $cls->teachers = [$course->teacher_id];
                    $cls->subject = $course->subject;
                    $cls->teacher = $course->teacher_id;
                    $cls->class = $cls->id;
                    $courseData[] = $cls;
                    $clx[] = $cls->id;
                    $z++;
                }
            }
        }
        shuffle($courseData);
        $theBox = new TheBox($courseData,$timing,$days,$clx);
        $theBox->__init();
        $pot = [];
        $classMap = KlassSubjectTeacher::where(["session_id"=>$session])->pluck('class_id');
        $box = $theBox->box;
        for ($i=0;$i<count($days); $i++){
            for ($j=0;$j<count($timing);$j++){
                if($box[$i][$j]==null)continue;
                $sub = explode('.',$box[$i][$j]->class);
                $claxxMap = KlassSubjectTeacher::find($sub[0]);
                $claxx = Klass::find($claxxMap->class_id);
                $pot["sch"][$days[$i]][$claxx->class_name][$timing[$j]]=[
                    "id"=>$box[$i][$j]->class,
                    "subject" => $box[$i][$j]->subject,
                    "instructor" => $box[$i][$j]->teacher,
                    "time" => $timing[$j]
                ];
            }

        }

        $dxz = [];
        foreach ($days as $ds){
            $dxz[$ds] = $dayMap[$ds];
        }
        $info =[
            "schedules"=>$pot,
            "classes"=>Klass::whereIn("id",$classMap)->orderBy("id","ASC")->pluck("class_name"),
            "days"=>$dxz,
            "timing"=>$timings
        ];
        $timetable->config = json_encode($info);
        $timetable->save();
//        return $info;
        return redirect(route("timetables.display",[$timetable->id]));

    }

    public function displayTimes(Request $request,$id)
    {
        $timetable = Timetable::find($id);
//        return $timetable->config;
        return view("pages.timetables.displaytimes",compact('timetable'));
    }
}
