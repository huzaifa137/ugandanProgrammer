<?php
namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class QuizController extends Controller
{
    public function createQuiz()
    {
        $courses = Course::all();
        return view('Quiz.create-quiz', compact('courses'));
    }

    public function storeQuiz(Request $request)
    {

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id'   => 'required|exists:courses,id',
            'module_id'   => 'nullable|exists:modules,id',
            'lesson_id'   => 'nullable|exists:lessons,id',
        ]);

        $quiz = new Quiz();

        $quiz->title       = $validated['title'];
        $quiz->description = $validated['description'];
        $quiz->course_id   = $request->input('course_id');

        if ($request->quiz_category == 'Module') {
            $quiz->type_id = $validated['module_id'] ?? '';
            $quiz->type    = 'Module' ?? '';
        } elseif ($request->quiz_category == 'Lesson') {
            $quiz->type_id = $validated['lesson_id'] ?? '';
            $quiz->type    = 'Lesson' ?? '';
        } elseif ($request->quiz_category == 'Course') {
            $quiz->type_id = $validated['course_id'] ?? '';
            $quiz->type    = 'Course' ?? '';
        }

        $quiz->save();

        return redirect()->route('quizzes.create.quiz')->with('success', 'Quiz created successfully!');
    }

    public function createAssignment()
    {
        $courses = Course::all();
        return view('Assignment.create-assignment', compact('courses'));
    }

    public function storeAssignment(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'course_id'   => 'required|exists:courses,id',
            'module_id'   => 'nullable|exists:modules,id',
            'lesson_id'   => 'nullable|exists:lessons,id',
        ]);

        $assignment = new Assignment();

        $assignment->title        = $validated['title'];
        $assignment->description  = $validated['description'];
        $assignment->instructions = $request->input('instructions');
        $assignment->course_id    = $request->input('course_id');

        if ($request->quiz_category == 'Module') {
            $assignment->type_id = $validated['module_id'] ?? '';
            $assignment->type    = 'Module' ?? '';
        } elseif ($request->quiz_category == 'Lesson') {
            $assignment->type_id = $validated['lesson_id'] ?? '';
            $assignment->type    = 'Lesson' ?? '';
        } elseif ($request->quiz_category == 'Course') {
            $assignment->type_id = $validated['course_id'] ?? '';
            $assignment->type    = 'Course' ?? '';
        }

        $assignment->save();

        return redirect()->route('create.assignments')->with('success', 'Assignment created successfully!');
    }

    public function getCourseModules($course_id)
    {
        $modules = Module::where('course_id', $course_id)->get(['id', 'title']);
        return response()->json($modules);
    }

    public function getModuleLesson($module_id)
    {
        $lessons = Lesson::where('module_id', $module_id)->get(['id', 'title']);
        return response()->json($lessons);
    }

    public function allQuizzesAndAssignments()
    {
        return view('Dashboards.all-quizzes-and-assignments');
    }

    public function allQuizzes()
    {

        $quizzes = Quiz::orderBy('id', 'desc')->paginate(12);

        return view('Quiz.all-quizzes', compact(['quizzes']));
    }

    public function createQuestions($quizId)
    {

        $quiz = Quiz::findOrFail($quizId);
        return view('Quiz.create-question', compact(['quiz', 'quizId']));
    }

    // public function storeQuestions(Request $request, $quizId)
    // {

    //     $question = new Question();

    //     $question->quiz_id       = $quizId;
    //     $question->question_text = $request->input('question');
    //     $question->question_type = $request->input('type');
    //     $question->options       = $request->input('type') === 'mcq' ? json_encode($request->input('options')) : null;

    //     if ($request->input('type') === 'short_answer') {
    //         $question->correct_answer = $request->input('correct_answer_short_answer');

    //     } elseif ($request->input('type') === 'true_false') {
    //         $question->correct_answer = $request->input('correct_answer_boolean');

    //     } elseif ($request->input('type') === 'mcq') {
    //         $question->correct_answer = $request->input('correct_answer_mcqs');
    //     }

    //     $question->save();

    //     return back()->with('success', 'Question added successfully!');
    // }


    public function storeQuestions(Request $request, $quizId)
    {
        foreach ($request->input('questions', []) as $data) {
    
            $question = new Question();
    
            $question->quiz_id        = $quizId;
            $question->question_text  = Arr::get($data, 'question');
            $question->question_type  = Arr::get($data, 'type');
    
            // Set options if type is MCQ
            $question->options = Arr::get($data, 'type') === 'mcq'
                ? json_encode(Arr::get($data, 'options', []))
                : null;
    
            // Set correct answer based on question type
            if (Arr::get($data, 'type') === 'short_answer') {
                $question->correct_answer = Arr::get($data, 'correct_answer_short_answer');
            } elseif (Arr::get($data, 'type') === 'true_false') {
                $question->correct_answer = Arr::get($data, 'correct_answer_boolean');
            } elseif (Arr::get($data, 'type') === 'mcq') {
                $question->correct_answer = Arr::get($data, 'correct_answer_mcqs');
            }
    
            $question->save();
        }
    
        return response()->json(['success' => true]);
    }
    

}
