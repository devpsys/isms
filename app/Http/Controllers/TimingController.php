<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Timing;
use App\Http\Requests\Timings\Index;
use App\Http\Requests\Timings\Show;
use App\Http\Requests\Timings\Create;
use App\Http\Requests\Timings\Store;
use App\Http\Requests\Timings\Edit;
use App\Http\Requests\Timings\Update;
use App\Http\Requests\Timings\Destroy;


/**
 * Description of TimingController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class TimingController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Index  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Index $request)
    {
        return view('pages.timings.index', ['records' => Timing::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Show  $request
     * @param  Timing  $timing
     * @return \Illuminate\Http\Response
     */
    public function show(Show $request, Timing $timing)
    {
        return view('pages.timings.show', [
                'record' =>$timing,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Create  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Create $request)
    {

        return view('pages.timings.create', [
            'model' => new Timing,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $model=new Timing;
        $model->fill($request->all());

        if ($model->save()) {
            
            session()->flash('app_message', 'Timing saved successfully');
            return redirect()->route('timings.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving Timing');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Edit  $request
     * @param  Timing  $timing
     * @return \Illuminate\Http\Response
     */
    public function edit(Edit $request, Timing $timing)
    {

        return view('pages.timings.edit', [
            'model' => $timing,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Update  $request
     * @param  Timing  $timing
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request,Timing $timing)
    {
        $timing->fill($request->all());

        if ($timing->save()) {
            
            session()->flash('app_message', 'Timing successfully updated');
            return redirect()->route('timings.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Timing');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Destroy  $request
     * @param  Timing  $timing
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Destroy $request, Timing $timing)
    {
        if ($timing->delete()) {
                session()->flash('app_message', 'Timing successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting Timing');
            }

        return redirect()->back();
    }
}
