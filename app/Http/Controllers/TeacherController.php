<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Teacher;
use App\Http\Requests\Teachers\Index;
use App\Http\Requests\Teachers\Store;
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
     * @param Index $request
     * @return Application|Factory|View
     */
    public function index(Index $request)
    {
        $teachers = Teacher::all();

        return view('pages.teachers.index', compact('teachers'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return RedirectResponse
     */
    public function store(Store $request)
    {
        if (isset($request->id))
            $model = Teacher::find($request->id);
        else
            $model = new Teacher;

        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'Teacher saved successfully');
            return redirect()->route('manage.teachers');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Teacher');
        }
        return redirect()->back();
    }

    /**
     * Delete a  resource from  storage.
     *
     * @param Destroy $request
     * @return RedirectResponse
     */
    public function destroy(Destroy $request)
    {
        $teacher = Teacher::find($request->id);

        if ($teacher->delete()) {
            session()->flash('app_message', 'Teacher successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Teacher');
        }

        return redirect()->back();
    }
}
