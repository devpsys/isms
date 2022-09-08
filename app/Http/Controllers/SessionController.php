<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Models\Session;
use App\Http\Requests\Sessions\Index;
use App\Http\Requests\Sessions\Store;
use App\Http\Requests\Sessions\Destroy;
use Illuminate\Http\RedirectResponse;


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
     * @param Index $request
     * @return Application|Factory|View
     */
    public function index(Index $request)
    {
        $sessions = Session::orderBy('session', 'desc')->get();

        return view('pages.sessions.index', compact('sessions'));
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
            $model = Session::find($request->id);
        else
            $model = new Session;
        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'Session saved successfully');
            return redirect()->route('manage.sessions');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Session');
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
        $session = Session::find($request->id);
        if ($session->delete()) {
            session()->flash('app_message', 'Session successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Session');
        }

        return redirect()->back();
    }
}
