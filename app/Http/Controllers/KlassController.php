<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Klass;
use App\Http\Requests\Klasses\Index;
use App\Http\Requests\Klasses\Show;
use App\Http\Requests\Klasses\Create;
use App\Http\Requests\Klasses\Store;
use App\Http\Requests\Klasses\Edit;
use App\Http\Requests\Klasses\Update;
use App\Http\Requests\Klasses\Destroy;
use Illuminate\Http\Response;


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
        return view('pages.klasses.index', ['records' => Klass::paginate(10)]);
    }

    /**
     * Display the specified resource.
     *
     * @param Show $request
     * @param Klass $klass
     * @return Response
     */
    public function show(Show $request, Klass $klass)
    {
        return view('pages.klasses.show', [
            'record' => $klass,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Create $request
     * @return Response
     */
    public function create(Create $request)
    {

        return view('pages.klasses.create', [
            'model' => new Klass,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return Response
     */
    public function store(Store $request)
    {
        $model = new Klass;
        $model->fill($request->all());

        if ($model->save()) {

            session()->flash('app_message', 'Klass saved successfully');
            return redirect()->route('klasses.index');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Klass');
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Edit $request
     * @param Klass $klass
     * @return Response
     */
    public function edit(Edit $request, Klass $klass)
    {

        return view('pages.klasses.edit', [
            'model' => $klass,

        ]);
    }

    /**
     * Update a existing resource in storage.
     *
     * @param Update $request
     * @param Klass $klass
     * @return Response
     */
    public function update(Update $request, Klass $klass)
    {
        $klass->fill($request->all());

        if ($klass->save()) {

            session()->flash('app_message', 'Klass successfully updated');
            return redirect()->route('klasses.index');
        } else {
            session()->flash('app_error', 'Something is wrong while updating Klass');
        }
        return redirect()->back();
    }

    /**
     * Delete a  resource from  storage.
     *
     * @param Destroy $request
     * @param Klass $klass
     * @return Response
     * @throws Exception
     */
    public function destroy(Destroy $request, Klass $klass)
    {
        if ($klass->delete()) {
            session()->flash('app_message', 'Klass successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Klass');
        }

        return redirect()->back();
    }
}
