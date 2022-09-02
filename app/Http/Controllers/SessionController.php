<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Http\Requests\Sessions\Index;
use App\Http\Requests\Sessions\Show;
use App\Http\Requests\Sessions\Create;
use App\Http\Requests\Sessions\Store;
use App\Http\Requests\Sessions\Edit;
use App\Http\Requests\Sessions\Update;
use App\Http\Requests\Sessions\Destroy;


/**
 * Description of SessionController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class SessionController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Index  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Index $request)
    {
        return view('pages.sessions.index', ['records' => Session::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Show  $request
     * @param  Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show(Show $request, Session $session)
    {
        return view('pages.sessions.show', [
                'record' =>$session,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Create  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Create $request)
    {

        return view('pages.sessions.create', [
            'model' => new Session,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $model=new Session;
        $model->fill($request->all());

        if ($model->save()) {
            
            session()->flash('app_message', 'Session saved successfully');
            return redirect()->route('sessions.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving Session');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Edit  $request
     * @param  Session  $session
     * @return \Illuminate\Http\Response
     */
    public function edit(Edit $request, Session $session)
    {

        return view('pages.sessions.edit', [
            'model' => $session,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Update  $request
     * @param  Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request,Session $session)
    {
        $session->fill($request->all());

        if ($session->save()) {
            
            session()->flash('app_message', 'Session successfully updated');
            return redirect()->route('sessions.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating Session');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Destroy  $request
     * @param  Session  $session
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Destroy $request, Session $session)
    {
        if ($session->delete()) {
                session()->flash('app_message', 'Session successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting Session');
            }

        return redirect()->back();
    }
}
