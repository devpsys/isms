<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Http\Requests\Teachers\Index;
use App\Http\Requests\Teachers\Show;
use App\Http\Requests\Teachers\Create;
use App\Http\Requests\Teachers\Store;
use App\Http\Requests\Teachers\Edit;
use App\Http\Requests\Teachers\Update;
use App\Http\Requests\Teachers\Destroy;


/**
 * Description of TeacherController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class TeacherController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Index  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Index $request)
    {
        return view('pages.teachers.index', ['records' => Teacher::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Show  $request
     * @param  Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Show $request, Teacher $teacher)
    {
        return view('pages.teachers.show', [
                'record' =>$teacher,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Create  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Create $request)
    {
		$users = User::all(['id']);

        return view('pages.teachers.create', [
            'model' => new Teacher,
			"users" => $users,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $model=new Teacher;
        $model->fill($request->all());

        if ($model->save()) {
            
            session()->flash('app_message', 'Teacher saved successfully');
            return redirect()->route('teachers.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving Teacher');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Edit  $request
     * @param  Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Edit $request, Teacher $teacher)
    {
		$users = User::all(['id']);

        return view('pages.teachers.edit', [
            'model' => $teacher,
			"users" => $users,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Update  $request
     * @param  Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request,Teacher $teacher)
    {
        $teacher->fill($request->all());

        if ($teacher->save()) {
            
            session()->flash('app_message', 'Teacher successfully updated');
            return redirect()->route('teachers.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Teacher');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Destroy  $request
     * @param  Teacher  $teacher
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Destroy $request, Teacher $teacher)
    {
        if ($teacher->delete()) {
                session()->flash('app_message', 'Teacher successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting Teacher');
            }

        return redirect()->back();
    }
}
