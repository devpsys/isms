<?php

namespace App\Http\Controllers;

use App\Models\KlassSubjectTeacher;
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
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $teachers = Teacher::all();

        return view('pages.teachers.index', compact('teachers'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
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

    public function subjects(Request $request)
    {
        $subjectTeacher = KlassSubjectTeacher::select(['id', 'subject_id'])
            ->where(['session_id' => $request->session_id, 'teacher_id' => $request->teacher_id])
            ->whereIn('class_id', $request->classes)
            ->pluck('subject_id')
            ->toArray();

        $idList = implode(',', $subjectTeacher);
        $idList = empty($idList) ? "0" : $idList;

        return Subject::select(['id', 'title', DB::raw("id IN ($idList) AS assigned")])->get();
    }

    public function assign(Request $request)
    {
        $array = [];
        $array['success'] = true;

//        return $request;

        try {
            $classes = $request->classes;
            $subjects = $request->subjects;

            foreach ($classes as $class_id) {
                $subjectTeachers = KlassSubjectTeacher::where([
                    'session_id' => $request->session_id, 'class_id' => $class_id,
                    'teacher_id' => $request->teacher_id])
                    ->whereIn('subject_id', $subjects)
                    ->pluck('subject_id')->toArray();

                if (isset($subjects)) {
                    foreach ($subjects as $subject) {
                        //  If subject and class are already assigned then skip it.
                        if (in_array($subject, $subjectTeachers) == 1)
                            continue;

                        $subjectTeacher = new KlassSubjectTeacher();
                        $subjectTeacher->session_id = $request->session_id;
                        $subjectTeacher->teacher_id = $request->teacher_id;
                        $subjectTeacher->subject_id = $subject;
                        $subjectTeacher->class_id = $class_id;
                        $subjectTeacher->save();
                    }

                    $subjectTeachers = DB::table('klass_subject_teachers')
//                        ->join('subjects', 'subjects.id', '=', 'klass_subject_teachers.subject_id')
//                        ->join('teachers', 'teachers.id', '=', 'klass_subject_teachers.teacher_id')
                        ->where('klass_subject_teachers.session_id', $request->session_id)
                        ->where('klass_subject_teachers.teacher_id', $request->teacher_id)
                        ->where('klass_subject_teachers.class_id', $class_id)
                        ->pluck('klass_subject_teachers.subject_id')
                        ->toArray();

                    foreach ($subjectTeachers as $subjectTeacher) {
                        if (in_array($subjectTeacher, $subjects) == 0) {
                            $rp = KlassSubjectTeacher::where(['subject_id' => $subjectTeacher])->first();
                            $rp->delete();
                        }
                    }

                    $array['success'] = true;
                    $array['message'] = 'Permission(s) assigned successfully.';
                } else {
                    KlassSubjectTeacher::where(['session_id' => $request->session_id,
                        'teacher_id' => $request->teacher_id, 'class_id' => $class_id])->delete();

                    $array['success'] = true;
                    $array['message'] = 'Permission(s) revoked successfully.';
                }
            }
        } catch (Exception $e) {
            $array['success'] = false;
            $array['message'] = $e->getMessage();// 'Something is wrong while assigning subject(s) to this Teacher.';
        }

        return json_encode($array);
    }

    /**
     * Delete a  resource from  storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request)
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
