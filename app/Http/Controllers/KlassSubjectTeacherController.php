<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KlassSubjectTeacher;
use App\Models\Klass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Section;
use App\Http\Requests\KlassSubjectTeachers\Index;
use App\Http\Requests\KlassSubjectTeachers\Show;
use App\Http\Requests\KlassSubjectTeachers\Create;
use App\Http\Requests\KlassSubjectTeachers\Store;
use App\Http\Requests\KlassSubjectTeachers\Edit;
use App\Http\Requests\KlassSubjectTeachers\Update;
use App\Http\Requests\KlassSubjectTeachers\Destroy;
use Illuminate\Http\Response;


/**
 * Description of KlassSubjectTeacherController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class KlassSubjectTeacherController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Index  $request
     * @return Application|Factory|View
        */
    public function index(Index $request)
    {
        return view('pages.klass_subject_teachers.index', ['records' => KlassSubjectTeacher::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Show  $request
     * @param  KlassSubjectTeacher  $klasssubjectteacher
     * @return Application|Factory|View
 */
    public function show(Show $request, KlassSubjectTeacher $klasssubjectteacher)
    {
        return view('pages.klass_subject_teachers.show', [
                'record' =>$klasssubjectteacher,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Create  $request
     * @return Application|Factory|View
 */
    public function create(Create $request)
    {
		$klasses = Klass::all(['id']);
		$subjects = Subject::all(['id']);
		$teachers = Teacher::all(['id']);
		$sections = Section::all(['id']);

        return view('pages.klass_subject_teachers.create', [
            'model' => new KlassSubjectTeacher,
			"klasses" => $klasses,
			"subjects" => $subjects,
			"teachers" => $teachers,
			"sections" => $sections,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Store  $request
     * @return RedirectResponse
 */
    public function store(Store $request)
    {
        $model=new KlassSubjectTeacher;
        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'KlassSubjectTeacher saved successfully');
            return redirect()->route('klass_subject_teachers.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving KlassSubjectTeacher');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Edit  $request
     * @param  KlassSubjectTeacher  $klasssubjectteacher
     * @return Response
     */
    public function edit(Edit $request, KlassSubjectTeacher $klasssubjectteacher)
    {
		$klasses = Klass::all(['id']);
		$subjects = Subject::all(['id']);
		$teachers = Teacher::all(['id']);
		$sections = Section::all(['id']);

        return view('pages.klass_subject_teachers.edit', [
            'model' => $klasssubjectteacher,
			"klasses" => $klasses,
			"subjects" => $subjects,
			"teachers" => $teachers,
			"sections" => $sections,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Update  $request
     * @param  KlassSubjectTeacher  $klasssubjectteacher
     * @return Response
     */
    public function update(Update $request,KlassSubjectTeacher $klasssubjectteacher)
    {
        $klasssubjectteacher->fill($request->all());

        if ($klasssubjectteacher->save()) {

            session()->flash('app_message', 'KlassSubjectTeacher successfully updated');
            return redirect()->route('klass_subject_teachers.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating KlassSubjectTeacher');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Destroy  $request
     * @param  KlassSubjectTeacher  $klasssubjectteacher
     * @return Response
     * @throws Exception
     */
    public function destroy(Destroy $request, KlassSubjectTeacher $klasssubjectteacher)
    {
        if ($klasssubjectteacher->delete()) {
                session()->flash('app_message', 'KlassSubjectTeacher successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting KlassSubjectTeacher');
            }

        return redirect()->back();
    }
}
