<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Models\Klass;
use App\Http\Requests\Klasses\Index;
use App\Http\Requests\Klasses\Store;
use App\Http\Requests\Klasses\Destroy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;


/**
 * Description of KlassController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */
class KlassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Index $request
     * @return Application|Factory|View
     */
    public function index(Index $request)
    {
        $klasses = DB::table('klasses')
            ->join('sections', 'sections.id', '=', 'klasses.section_id')
            ->select(['klasses.*', 'sections.title'])
            ->get();

        return view('pages.klasses.index', compact('klasses'));
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
            $model = Klass::find($request->id);
        else
            $model = new Klass;
        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'Class saved successfully');
            return redirect()->route('manage.classes');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Class');
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
        $klass = Klass::find($request->id);

        if ($klass->delete()) {
            session()->flash('app_message', 'Class successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Class');
        }

        return redirect()->back();
    }
}
