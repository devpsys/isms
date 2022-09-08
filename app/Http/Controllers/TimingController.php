<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Timing;
use App\Http\Requests\Timings\Index;
use App\Http\Requests\Timings\Store;
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
     * @param Index $request
     * @return Application|Factory|View
     */
    public function index(Index $request)
    {
        $timings = Timing::orderBy('time_from')->get();
        foreach ($timings as $timing) {
            $timing->time_from = Carbon::parse($timing->time_from)->isoFormat('hh:mm');
            $timing->time_to = Carbon::parse($timing->time_to)->isoFormat('hh:mm');
        }

        return view('pages.timings.index', compact('timings'));
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
            $model = Timing::find($request->id);
        else
            $model = new Timing;
        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'Timing saved successfully');
            return redirect()->route('manage.timings');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Timing');
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
        $timing = Timing::find($request->id);

        if ($timing->delete()) {
            session()->flash('app_message', 'Timing successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Timing');
        }

        return redirect()->back();
    }
}
