<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Models\Subject;
use App\Http\Requests\Subjects\Index;
use App\Http\Requests\Subjects\Store;
use App\Http\Requests\Subjects\Destroy;
use Illuminate\Http\RedirectResponse;


/**
 * Description of SubjectController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */
class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Index $request
     * @return Application|Factory|View
     */
    public function index(Index $request)
    {
        $subjects = Subject::all();

        return view('pages.subjects.index', compact('subjects'));
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
            $model = Subject::find($request->id);
        else
            $model = new Subject;

        $model->fill($request->all());

        if ($model->save()) {
            session()->flash('app_message', 'Subject saved successfully');
            return redirect()->route('manage.subjects');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Subject');
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
        $subject = Subject::find($request->id);
        if ($subject->delete()) {
            session()->flash('app_message', 'Subject successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Subject');
        }

        return redirect()->back();
    }
}
