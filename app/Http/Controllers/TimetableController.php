<?php

namespace App\Http\Controllers;

use Exception;
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
}
