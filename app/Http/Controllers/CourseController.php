<?php
namespace App\Http\Controllers;

class CourseController extends Controller
{
    public function addCourse()
    {
        $instructors = [
            (object) ['id' => 1, 'name' => 'Huzaifa'],
            (object) ['id' => 2, 'name' => 'Bukenya'],
            (object) ['id' => 3, 'name' => 'Hashim'],
        ];

        $categories = [
            (object) ['id' => 1, 'name' => 'Web Development'],
            (object) ['id' => 2, 'name' => 'Mobile Apps'],
            (object) ['id' => 3, 'name' => 'Design'],
        ];

        $languages = [
            (object) ['id' => 1, 'name' => 'English'],
            (object) ['id' => 2, 'name' => 'Luganda'],
            (object) ['id' => 3, 'name' => 'Arabic'],
        ];

        return view('courses.add-course', compact(['instructors', 'categories','languages']));
    }
}
