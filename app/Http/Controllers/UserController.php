<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Users\Index;
use App\Http\Requests\Users\Show;
use App\Http\Requests\Users\Create;
use App\Http\Requests\Users\Store;
use App\Http\Requests\Users\Edit;
use App\Http\Requests\Users\Update;
use App\Http\Requests\Users\Destroy;


/**
 * Description of UserController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */

class UserController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @param  Index  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Index $request)
    {
        return view('pages.users.index', ['records' => User::paginate(10)]);
    }    /**
     * Display the specified resource.
     *
     * @param  Show  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Show $request, User $user)
    {
        return view('pages.users.show', [
                'record' =>$user,
        ]);

    }    /**
     * Show the form for creating a new resource.
     *
     * @param  Create  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Create $request)
    {

        return view('pages.users.create', [
            'model' => new User,

        ]);
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $model=new User;
        $model->fill($request->all());

        if ($model->save()) {
            
            session()->flash('app_message', 'User saved successfully');
            return redirect()->route('users.index');
            } else {
                session()->flash('app_message', 'Something is wrong while saving User');
            }
        return redirect()->back();
    } /**
     * Show the form for editing the specified resource.
     *
     * @param  Edit  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Edit $request, User $user)
    {

        return view('pages.users.edit', [
            'model' => $user,

            ]);
    }    /**
     * Update a existing resource in storage.
     *
     * @param  Update  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request,User $user)
    {
        $user->fill($request->all());

        if ($user->save()) {
            
            session()->flash('app_message', 'User successfully updated');
            return redirect()->route('users.index');
            } else {
                session()->flash('app_error', 'Something is wrong while updating User');
            }
        return redirect()->back();
    }    /**
     * Delete a  resource from  storage.
     *
     * @param  Destroy  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Destroy $request, User $user)
    {
        if ($user->delete()) {
                session()->flash('app_message', 'User successfully deleted');
            } else {
                session()->flash('app_error', 'Error occurred while deleting User');
            }

        return redirect()->back();
    }
}
