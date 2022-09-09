<?php

namespace App\Http\Controllers;

use App\Models\Klass;
use App\Models\KlassSubjectTeacher;
use App\Models\Teacher;
use App\Models\Timing;
use App\TTAlgo\Data;
use App\TTAlgo\Population;
use Exception;;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Models\Timetable;
use App\Models\Session;
use App\Models\Section;
use App\Http\Requests\Timetables\Index;
use App\Http\Requests\Timetables\Show;
use App\Http\Requests\Timetables\Create;
use App\Http\Requests\Timetables\Store;
use App\Http\Requests\Timetables\Edit;
use App\Http\Requests\Timetables\Update;
use App\Http\Requests\Timetables\Destroy;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


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
        $session = $request->input("session");
        $teachers  = Teacher::whereIn('id',KlassSubjectTeacher::where(["session_id"=>$session])->pluck("teacher_id"))->get();
        $rooms = Klass::whereIn("id",KlassSubjectTeacher::where(["session_id"=>$session])->pluck("class_id"))->get();
        $courses = KlassSubjectTeacher::where(["session_id"=>$session])
            ->join("subjects","subjects.id","=","klass_subject_teachers.subject_id")
            ->select("subjects.title AS subject","klass_subject_teachers.*")
            ->get();
        $timings = Timing::whereIn('id',[8,9,10])->get();
        $courseData = [];
        foreach ($courses as $course){
            if(isset($request->subject[$course->id])){
                $count = $request->subject[$course->id];
                for ($i=0;$i<$count;$i++){
                    $cls = new \stdClass();
                    $cls->id = $course->id.".".$i;
                    $cls->class_name = $course->subject;
                    $cls->teachers = [$course->teacher_id];
                    $courseData[] = $cls;
                }
            }

        }
//        return [$courseData];
        $data = new Data($teachers,$timings,$rooms,$courseData);
        $population_size = 9;
        $population = new Population($population_size, $data);
        $pot = [];
        $i = 0;
        foreach ($population->getSchedules() as $schedule){
            $schedule->calculate_fitness();
            $i++;
            foreach ($schedule->getClasses() as $clx){
                $pot["sch".$i][] = [
                    $clx->getId(),$clx->getCourse()->name,
                    $clx->getCourse()->getNumber(),
                    $clx->getInstructor()->getName(),
                    $clx->getMeetingTime()->time,$schedule->_noOfConflicts];
            }
        }
        return json_encode($pot);

    }
}
