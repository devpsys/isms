<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Http\Requests\Sections\Index;
use App\Http\Requests\Sections\Show;
use App\Http\Requests\Sections\Create;
use App\Http\Requests\Sections\Store;
use App\Http\Requests\Sections\Edit;
use App\Http\Requests\Sections\Update;
use App\Http\Requests\Sections\Destroy;


/**
 * Description of SectionController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class SectionController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Index  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Index $request)
    {
        return view('pages.sections.index', ['records' => Section::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Show  $request
     * @param  Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Show $request, Section $section)
    {
        return view('pages.sections.show', [
                'record' =>$section,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Create  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Create $request)
    {

        return view('pages.sections.create', [
            'model' => new Section,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $model=new Section;
        $model->fill($request->all());

        if ($model->save()) {
            
            session()->flash('app_message', 'Section saved successfully');
            return redirect()->route('sections.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving Section');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Edit  $request
     * @param  Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Edit $request, Section $section)
    {

        return view('pages.sections.edit', [
            'model' => $section,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Update  $request
     * @param  Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request,Section $section)
    {
        $section->fill($request->all());

        if ($section->save()) {
            
            session()->flash('app_message', 'Section successfully updated');
            return redirect()->route('sections.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Section');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Destroy  $request
     * @param  Section  $section
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Destroy $request, Section $section)
    {
        if ($section->delete()) {
                session()->flash('app_message', 'Section successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting Section');
            }

        return redirect()->back();
    }
}
