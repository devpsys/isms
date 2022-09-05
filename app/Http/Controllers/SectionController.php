<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
use Illuminate\Http\Response;


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
     * @param Index $request
     * @return Application|Factory|View
     */
    public function index(Index $request)
    {
        return view('pages.sections.index', ['sections' => Section::all()]);
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
            $model = Section::find($request->id);
        else
            $model = new Section;
        $model->fill($request->all());

        if ($model->save()) {
            session()->flash('app_message', 'Section saved successfully');
            return redirect()->route('manage.sections');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Section');
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
        $section = Section::find($request->id);
        if ($section->delete()) {
            session()->flash('app_message', 'Section successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Section');
        }

        return redirect()->back();
    }
}
