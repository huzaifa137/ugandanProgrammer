<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;

class codEditorController extends Controller
{
    public function programmingCodeEditor()
    {

        return view('code.editor');
    }

    public function preview(Course $course)
    {
        $user = User::find(session('LoggedAdmin'));

        $allLessons = \App\Models\Lesson::whereHas('module', function ($query) use ($course) {
            $query->where('course_id', $course->id);
        })->count();

        $completedLessons = $user->lessons()
            ->whereHas('module', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->count();

        return view('certificates.preview', compact('course', 'allLessons', 'completedLessons'));
    }

    public function download(Course $course)
    {
        $user      = User::find(session('LoggedAdmin'));
        $total     = $course->lessons()->count();
        $completed = $user->lessons()->where('course_id', $course->id)->count();

        if ($total !== $completed) {
            return redirect()->back()->with('error', 'You must complete all lessons to download the certificate.');
        }

        $pdf = PDF::loadView('certificates.template', ['user' => $user, 'course' => $course]);
        return $pdf->download($course->slug . '-certificate.pdf');
    }

    public function template(Course $course)
    {
        $user = User::find(session('LoggedAdmin'));
        return view('certificates.template', compact('course', 'user'));
    }

    public function previewAllCertificates()
    {
        $user    = User::find(session('LoggedAdmin'));
        $courses = Course::with('modules.lessons')->get(); 

        $certificates = [];

        foreach ($courses as $course) {
            $allLessons = \App\Models\Lesson::whereHas('module', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })->count();

            $completedLessons = $user->lessons()
                ->whereHas('module', function ($query) use ($course) {
                    $query->where('course_id', $course->id);
                })->count();

            $certificates[] = [
                'course'           => $course,
                'allLessons'       => $allLessons,
                'completedLessons' => $completedLessons,
            ];
        }

        return view('certificates.all-preview', [
            'user'         => $user,
            'certificates' => $certificates,
        ]);
    }

}
