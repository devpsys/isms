<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Models\Timetable;
use App\Models\Timing;
use App\Models\ClassSubjectTeacher;
use App\Http\Requests\Periods\Index;
use App\Http\Requests\Periods\Show;
use App\Http\Requests\Periods\Create;
use App\Http\Requests\Periods\Store;
use App\Http\Requests\Periods\Edit;
use App\Http\Requests\Periods\Update;
use App\Http\Requests\Periods\Destroy;


/**
 * Description of PeriodController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class PeriodController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Index  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Index $request)
    {
        return view('pages.periods.index', ['records' => Period::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Show  $request
     * @param  Period  $period
     * @return \Illuminate\Http\Response
     */
    public function show(Show $request, Period $period)
    {
        return view('pages.periods.show', [
                'record' =>$period,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Create  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Create $request)
    {
		$timetables = Timetable::all(['id']);
		$timings = Timing::all(['id']);
		$class_subject_teachers = ClassSubjectTeacher::all(['id']);

        return view('pages.periods.create', [
            'model' => new Period,
			"timetables" => $timetables,
			"timings" => $timings,
			"class_subject_teachers" => $class_subject_teachers,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $model=new Period;
        $model->fill($request->all());

        if ($model->save()) {
            
            session()->flash('app_message', 'Period saved successfully');
            return redirect()->route('periods.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving Period');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Edit  $request
     * @param  Period  $period
     * @return \Illuminate\Http\Response
     */
    public function edit(Edit $request, Period $period)
    {
		$timetables = Timetable::all(['id']);
		$timings = Timing::all(['id']);
		$class_subject_teachers = ClassSubjectTeacher::all(['id']);

        return view('pages.periods.edit', [
            'model' => $period,
			"timetables" => $timetables,
			"timings" => $timings,
			"class_subject_teachers" => $class_subject_teachers,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Update  $request
     * @param  Period  $period
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request,Period $period)
    {
        $period->fill($request->all());

        if ($period->save()) {
            
            session()->flash('app_message', 'Period successfully updated');
            return redirect()->route('periods.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Period');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Destroy  $request
     * @param  Period  $period
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Destroy $request, Period $period)
    {
        if ($period->delete()) {
                session()->flash('app_message', 'Period successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting Period');
            }

        return redirect()->back();
    }
}
