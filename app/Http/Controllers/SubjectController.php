<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Http\Requests\Subjects\Index;
use App\Http\Requests\Subjects\Show;
use App\Http\Requests\Subjects\Create;
use App\Http\Requests\Subjects\Store;
use App\Http\Requests\Subjects\Edit;
use App\Http\Requests\Subjects\Update;
use App\Http\Requests\Subjects\Destroy;


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
     * @param  Index  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Index $request)
    {
        return view('pages.subjects.index', ['records' => Subject::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Show  $request
     * @param  Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Show $request, Subject $subject)
    {
        return view('pages.subjects.show', [
                'record' =>$subject,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Create  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Create $request)
    {

        return view('pages.subjects.create', [
            'model' => new Subject,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $model=new Subject;
        $model->fill($request->all());

        if ($model->save()) {
            
            session()->flash('app_message', 'Subject saved successfully');
            return redirect()->route('subjects.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving Subject');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Edit  $request
     * @param  Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Edit $request, Subject $subject)
    {

        return view('pages.subjects.edit', [
            'model' => $subject,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Update  $request
     * @param  Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request,Subject $subject)
    {
        $subject->fill($request->all());

        if ($subject->save()) {
            
            session()->flash('app_message', 'Subject successfully updated');
            return redirect()->route('subjects.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Subject');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Destroy  $request
     * @param  Subject  $subject
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Destroy $request, Subject $subject)
    {
        if ($subject->delete()) {
                session()->flash('app_message', 'Subject successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting Subject');
            }

        return redirect()->back();
    }
}
