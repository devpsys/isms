<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SubjectTeacher;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * Description of TeacherController
 *
 * @author Tuhin Bepari <digitaldreams40@gmail.com>
 */
class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Index $request
     * @return Application|Factory|View
     */
    public function index(Index $request)
    {
        $teachers = Teacher::all();

        return view('pages.teachers.index', compact('teachers'));
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
            $model = Teacher::find($request->id);
        else
            $model = new Teacher;

        $model->fill($request->all());

        if ($model->save()) {
            if (!isset($request->id)) {
                $model->staff_number = $this->staffNumber($model->id);
                $model->save();
            }

            session()->flash('app_message', 'Teacher saved successfully');
            return redirect()->route('manage.teachers');
        } else {
            session()->flash('app_message', 'Something is wrong while saving Teacher');
        }
        return redirect()->back();
    }

    public function subjects($teacher)
    {
        $subjectTeacher = SubjectTeacher::select(['id', 'subject_id'])->where(['teacher_id' => $teacher])->pluck('subject_id')->toArray();
        $idList = implode(',', $subjectTeacher);
        $idList = empty($idList) ? "0" : $idList;

        return Subject::select(['id', 'title', DB::raw("id IN ($idList) AS assigned")])->get();
    }

    public function assign(Request $request)
    {
        $array = [];
        $array['success'] = true;

        try {
            $subjectTeachers = SubjectTeacher::where(['teacher_id' => $request->teacher_id])->pluck('subject_id')->toArray();

            $subjects = $request->subjects;

            if (isset($subjects)) {
                foreach ($subjects as $subject) {
                    //  If permission is already assigned then skip it.
                    if (in_array($subject, $subjectTeachers) == 1)
                        continue;

                    $subjectTeacher = new SubjectTeacher();
                    $subjectTeacher->teacher_id = $request->teacher_id;
                    $subjectTeacher->subject_id = $subject;
                    $subjectTeacher->save();
                }

                $subjectTeachers = DB::table('subject_teachers')
                    ->join('subjects', 'subjects.id', '=', 'subject_teachers.subject_id')
                    ->join('teachers', 'teachers.id', '=', 'subject_teachers.teacher_id')
                    ->where('subject_teachers.teacher_id', $request->teacher_id)
                    ->pluck('subject_teachers.subject_id')
                    ->toArray();

                foreach ($subjectTeachers as $subjectTeacher) {
                    if (in_array($subjectTeacher, $subjects) == 0) {
                        $rp = SubjectTeacher::where(['permission_id' => $subjectTeacher])->first();
                        $rp->delete();
                    }
                }

                $array['success'] = true;
                $array['message'] = 'Permission(s) assigned successfully.';
            } else {
                SubjectTeacher::where(['teacher_id' => $request->teacher_id])->delete();

                $array['success'] = true;
                $array['message'] = 'Permission(s) revoked successfully.';
            }
        } catch (Exception $e) {
            $array['success'] = false;
            $array['message'] = 'Something is wrong while assigning subject(s) to this Teacher.';
        }

        return json_encode($array);
    }

    /**
     * Delete a  resource from  storage.
     *
     * @param Destroy $request
     * @return RedirectResponse
     */
    public function destroy(Destroy $request)
    {
        $teacher = Teacher::find($request->id);

        if ($teacher->delete()) {
            session()->flash('app_message', 'Teacher successfully deleted');
        } else {
            session()->flash('app_error', 'Error occurred while deleting Teacher');
        }

        return redirect()->back();
    }

    private function staffNumber($id)
    {
        return 'FN' . sprintf("%04d", $id);
    }
}
