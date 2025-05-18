<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\User;
use App\Models\UserQuizAnswer;
use App\Models\UserQuizAttempt;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mail;

class StudentController extends Controller
{
    public function register(Request $request)
    {
        return view('users.register');
    }

    public function user_terms_and_conditions(Request $request)
    {
        return view('users.terms-and-conditions');
    }

    public function flushSession()
    {
        session()->flush();

        return redirect('/');
    }

    public function userRegistrationOTP()
    {
        return view('users.LoginOTP');
    }

    public function userAccountCreation(Request $request)
    {

        // ACCOUNT STATUSES
// --------------------------------------
        // 1.Banned     ====> 0
        // 2.Locked     ====> 8
        // 3.Suspended  ====> 9
        // 4.Active     ====> 10

        $request->validate([
            'username' => 'required',
            'email'    => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ],
        ], [
            'password.required' => 'The password field is required.',
            'password.string'   => 'The password must be a string.',
            'password.min'      => 'The password must be at least 6 characters.',
            'password.regex'    => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
        ]);

        $password         = $request->password;
        $confirm_password = $request->confirmPassword;

        if ($password != $confirm_password) {
            return response()->json([
                'status'  => false,
                'message' => 'Provided Passwords do not match',
            ]);
        }

        $user = new User;

        $user->username = $request->username;
        $user->email    = $request->email;
        $user->password = Hash::make($password);
        $save           = $user->save();

        $generatedOTP   = rand(10000, 99999);
        $info           = DB::table('users')->where('email', $request->email)->update(['temp_otp' => $generatedOTP]);
        $registeredUser = DB::table('users')->where('email', $request->email)->first();

        if ($registeredUser && Hash::check($request->password, $registeredUser->password)) {

            $generatedOTP = rand(10000, 99999);
            DB::table('users')->where('email', $request->email)->update(['temp_otp' => $generatedOTP]);

            $userId    = $registeredUser->id;
            $username  = $registeredUser->username;
            $useremail = $registeredUser->email;

            $data = [
                'subject'      => 'UGANDAN PROGRAMMER REGISTRATION OTP',
                'body'         => 'Enter the Sent OTP to confirm registration : ',
                'generatedOTP' => $generatedOTP,
                'username'     => $username,
                'email'        => $useremail,
            ];

            try {
                Mail::send('emails.otp', $data, function ($message) use ($data) {
                    $message->to($data['email'], $data['email'])->subject($data['subject']);
                });
            } catch (Exception $e) {
                DB::table('users')->where('email', $request->email)->delete();
                return back()->with('error', 'Email Not, Check Internet or re-register');
            }

            $request->session()->put('userId', $userId);
            $request->session()->put('userEmail', $useremail);
            $request->session()->put('userPassword', $request->password);

            return response()->json([
                'status'       => true,
                'message'      => 'OTP has been sent,check your email to proceed',
                'redirect_url' => '/users/user-otp',
            ]);

        } else {
            return response()->json([
                'status'       => false,
                'message'      => 'There was something wrong in creating this account,try registering again or contact admins',
                'redirect_url' => '/',
            ]);
        }
    }

    public function supplierOtpVerification(Request $request)
    {

        $otp_1 = $request->input('otp_1');
        $otp_2 = $request->input('otp_2');
        $otp_3 = $request->input('otp_3');
        $otp_4 = $request->input('otp_4');
        $otp_5 = $request->input('otp_5');

        $new_otp = $otp_1 . $otp_2 . $otp_3 . $otp_4 . $otp_5;
        $user_id = $request->input('hidden_otp');

        $temp_otp_stored   = DB::table('users')->where('id', $user_id)->value('temp_otp');
        $supplier_username = DB::table('users')->where('id', $user_id)->value('username');
        $userRole          = DB::table('users')->where('id', $user_id)->value('user_role');

        if ($new_otp == $temp_otp_stored) {

            if ($userRole != 1) {
                $request->session()->put('LoggedAdmin', $user_id);
            } else {
                $request->session()->put('LoggedStudent', $user_id);
            }

            $url  = '/';
            $url2 = session()->get('url.intended');
            $url3 = '/student/dashboard';

            if ($userRole != 1) {
                if ($url2 != null) {
                    return response()->json([
                        'status'       => true,
                        'message'      => 'Login successful',
                        'redirect_url' => $url2,
                    ]);
                }

                return response()->json([
                    'status'       => true,
                    'message'      => 'Login successful',
                    'redirect_url' => $url,
                ]);
            } else {
                return response()->json([
                    'status'       => true,
                    'message'      => 'Login successful',
                    'redirect_url' => $url3,
                ]);
            }

        } else {

            return response()->json([
                'status'  => false,
                'title'   => 'Invalid OTP',
                'message' => 'Entered OTP is invalid, please check your email for correct OTP code',
            ]);
        }
    }

    public function studentDashboard(Request $request)
    {
        return view('student.dashboard');
    }

    public function studentProfile(Request $request)
    {
        $user = DB::table('users')->where('id', session('LoggedStudent'))->first();

        return view('student.profile', compact(['user']));
    }

    public function studentCourses()
    {
        $allCourses = Course::orderBy('id', 'desc')->paginate(12);

        return view('student.all-courses', compact(['allCourses']));
    }

    public function editStudentProfile()
    {

        $info = DB::table('users')->where('id', Session('LoggedStudent'))->first();

        return view('student.edit-profile', compact(['info']));
    }

    public function coursesAndLessons()
    {
        $allCourses = Course::orderBy('id', 'desc')->paginate(10);
        $studentId  = Session('LoggedStudent');

        $enrolledCourseIds = DB::table('enrollments')
            ->where('user_id', $studentId)
            ->pluck('course_id')
            ->toArray();

        return view('student.courses-and-lessons', compact(['allCourses', 'enrolledCourseIds']));
    }

    public function addCart()
    {
        $cart = Session::get('cart', []);
        return view('student.cart', compact(['cart']));
    }

    public function addToCartAction($id)
    {
        $course = Course::findOrFail($id);

        $cart = Session::get('cart', []);

        $cleanedPrice = (int) str_replace(',', '', $course->selling_price);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                "id"        => $course->id,
                "title"     => $course->title,
                "thumbnail" => $course->thumbnail,
                "price"     => $cleanedPrice,
                "quantity"  => 1,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Course added to cart successfully!');
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Item removed from cart successfully.');
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('student.cart')->with('error', 'Your cart is empty.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $price = (int) str_replace(',', '', $item['price']);
            $subtotal += $price * $item['quantity'];
        }

        $discount = 0;

        $vat = ($subtotal - $discount) * 0;

        $total = $subtotal - $discount + $vat;

        return view('student.checkout', compact('cart', 'subtotal', 'discount', 'vat', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('student.cart')->with('error', 'Your cart is empty.');
        }

        foreach ($cart as $item) {
            DB::table('enrollments')->updateOrInsert(
                [
                    'user_id'   => Session('LoggedStudent'),
                    'course_id' => $item['id'],
                ],
                [
                    'status'      => 'enrolled',
                    'enrolled_at' => now(),
                    'updated_at'  => now(),
                    'created_at'  => now(),
                ]
            );
        }

        session()->forget('cart');

        return redirect()->route('student.courses.lessons')->with('success', 'Successfully enrolled in selected courses!');
    }

    public function updateQuantity(Request $request)
    {
        $courseId = $request->input('id');
        $quantity = $request->input('quantity');

        $cart = session()->get('cart', []);

        if (isset($cart[$courseId])) {
            $cart[$courseId]['quantity'] = $quantity;
            session()->put('cart', $cart);

            return response()->json(['success' => true, 'message' => 'Cart updated']);
        }

        return response()->json(['success' => false, 'message' => 'Course not found in cart'], 404);
    }

    public function filterCourses(Request $request)
    {
        $studentId = session('LoggedStudent');
        $filter    = $request->query('filter', 'all');

        $enrolledCourseIds = DB::table('enrollments')
            ->where('user_id', $studentId)
            ->pluck('course_id')
            ->toArray();

        if ($filter === 'enrolled') {
            $courses = Course::whereIn('id', $enrolledCourseIds)->orderBy('id', 'desc')->paginate(10);
        } elseif ($filter === 'not_enrolled') {
            $courses = Course::whereNotIn('id', $enrolledCourseIds)->orderBy('id', 'desc')->paginate(10);
        } else {
            $courses = Course::orderBy('id', 'desc')->paginate(10);
        }

        return view('Courses.partials.courses_grid', [
            'allCourses'        => $courses,
            'enrolledCourseIds' => $enrolledCourseIds,
        ])->render();
    }

    public function lessonsAndStudy()
    {
        $studentId = session('LoggedStudent');

        $enrolledCourses = \App\Models\Course::with('modules.lessons')
            ->whereIn('id', function ($query) use ($studentId) {
                $query->select('course_id')
                    ->from('enrollments')
                    ->where('user_id', $studentId);
            })
            ->get();

        $enrolledCourseIds = $enrolledCourses->pluck('id')->toArray();

        return view('student.enrolled-courses', compact('enrolledCourses', 'enrolledCourseIds'));
    }

    public function courseDetails($courseId)
    {
        $studentId = session('LoggedStudent');

        $course = \App\Models\Course::with(['modules.lessons'])->findOrFail($courseId);

        $isEnrolled = \App\Models\Enrollment::where('course_id', $courseId)
            ->where('user_id', $studentId)
            ->exists();

        $followersCount     = null;
        $formattedFollowers = null;
        if ($isEnrolled) {
            $sessionKey = "followers_count_{$studentId}_{$courseId}";

            if (! session()->has($sessionKey)) {
                $randomNumber = rand(1000, 999999);
                session([$sessionKey => $randomNumber]);
            }

            $followersCount     = session($sessionKey);
            $formattedFollowers = $this->formatFollowers($followersCount);
        }

        $enrolledCourseIds = \App\Models\Enrollment::where('user_id', $studentId)
            ->pluck('course_id')
            ->toArray();

        return view('student.course-details', compact(
            'course', 'formattedFollowers', 'enrolledCourseIds', 'isEnrolled'
        ));
    }

    private function formatFollowers($num)
    {
        if ($num >= 1000000) {
            return number_format($num / 1000000, 1) . 'M';
        } elseif ($num >= 1000) {
            return number_format($num / 1000, 1) . 'K';
        }
        return $num;
    }

    public function enrollCourseCartAction($id)
    {
        $course = Course::findOrFail($id);

        $cart = Session::get('cart', []);

        $cleanedPrice = (int) str_replace(',', '', $course->selling_price);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                "id"        => $course->id,
                "title"     => $course->title,
                "thumbnail" => $course->thumbnail,
                "price"     => $cleanedPrice,
                "quantity"  => 1,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('student.cart')->with('success', 'Course added to cart successfully!');
    }

    public function lessonStudying($courseId)
    {
        $studentId = session('LoggedStudent');

        $course = \App\Models\Course::with([
            'modules.lessons.quizzes',
        ])->findOrFail($courseId);

        $isEnrolled = \App\Models\Enrollment::where('course_id', $courseId)
            ->where('user_id', $studentId)
            ->exists();

        $followersCount     = null;
        $formattedFollowers = null;
        if ($isEnrolled) {
            $sessionKey = "followers_count_{$studentId}_{$courseId}";

            if (! session()->has($sessionKey)) {
                $randomNumber = rand(1000, 999999);
                session([$sessionKey => $randomNumber]);
            }

            $followersCount     = session($sessionKey);
            $formattedFollowers = $this->formatFollowers($followersCount);
        }

        $enrolledCourseIds = \App\Models\Enrollment::where('user_id', $studentId)
            ->pluck('course_id')
            ->toArray();

        $modulesCount = $course->modules->count();
        $lessonsCount = $course->modules->flatMap->lessons->count();
        $quizzesCount = $course->modules->flatMap->lessons->flatMap->quizzes->count();

        return view('student.ongoing-studies', compact(
            'course', 'formattedFollowers', 'enrolledCourseIds', 'isEnrolled',
            'modulesCount', 'lessonsCount', 'quizzesCount'
        ));
    }

    public function showLesson($id)
    {

        $lesson = Lesson::with(['module.course'])->findOrFail($id);

        return view('student.lesson-details', compact('lesson'));
    }

    public function showQuizForm($quizId)
    {
        $quiz = Quiz::with('questions')->find($quizId);
        $user = User::find(session('LoggedStudent'));

        $latestResults = DB::table('user_quiz_attempts')
            ->where('quiz_id', $quizId)
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->first();

        $results = [];

        $latestAttempt = UserQuizAttempt::where('quiz_id', $quizId)
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        $answers = collect();
        if ($latestAttempt) {
            $answers = UserQuizAnswer::where('user_quiz_attempt_id', $latestAttempt->id)->get();
        }

        $results = $quiz->questions->map(function ($question) use ($answers) {
            $response = $answers->firstWhere('question_id', $question->id);

            return [
                'question'       => $question->question_text,
                'user_answer'    => $response?->answer ?? null,
                'is_correct'     => $response?->is_correct ?? false,
                'has_answer'     => ! is_null($response),
                'correct_answer' => $question->correct_answer,
            ];
        });

        $hasSubmission = UserQuizAttempt::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->whereHas('answers')
            ->exists();

        $score = $results->filter(function ($result) {
            return $result['is_correct'];
        })->count();

        $total = $quiz->questions->count();

        return view('student.quiz-on-take', compact(['quiz', 'results', 'answers', 'hasSubmission', 'score', 'total']));

    }

    public function submitQuiz(Request $request, Quiz $quiz)
    {
        $submittedAnswers = $request->input('answers', []);
        $questions        = $quiz->questions;

        $score   = 0;
        $total   = $questions->count();
        $results = [];

        if ($questions->isEmpty()) {
            return redirect()->back()->with('error', 'No questions were found in this quiz.');
        }

        $user = User::find(session('LoggedStudent'));

        $userQuizAttempt = UserQuizAttempt::create([
            'user_id'      => $user->id,
            'quiz_id'      => $quiz->id,
            'score'        => 0,
            'completed_at' => now(),
        ]);

        foreach ($questions as $question) {
            $userAnswer    = isset($submittedAnswers[$question->id]) ? trim($submittedAnswers[$question->id]) : null;
            $correctAnswer = trim($question->correct_answer);

            $isCorrect = false;

            if ($question->question_type === 'short_answer') {
                $isCorrect = strtolower($userAnswer) === strtolower($correctAnswer);
            } else {
                $isCorrect = $userAnswer === $correctAnswer;
            }

            if ($isCorrect) {
                $score++;
            }

            $userQuizAttempt->answers()->create([
                'question_id' => $question->id,
                'answer'      => $userAnswer,
                'is_correct'  => $isCorrect,
            ]);

            $results[] = [
                'question'       => $question->question_text,
                'user_answer'    => $userAnswer,
                'correct_answer' => $correctAnswer,
                'is_correct'     => $isCorrect,
            ];
        }

        $userQuizAttempt->update(['score' => $score]);

        $lastAttempt = $user->quizzes()
            ->where('quiz_id', $quiz->id)
            ->orderByDesc('pivot_attempt_number')
            ->first();

        $attemptNumber = $lastAttempt ? $lastAttempt->pivot->attempt_number + 1 : 1;

        $user->quizzes()->attach($quiz->id, [
            'score'          => $score,
            'total'          => $total,
            'attempt_number' => $attemptNumber,
            'completed_at'   => now(),
        ]);

        return view('student.on-take-result', [
            'quiz'          => $quiz,
            'score'         => $score,
            'total'         => $total,
            'results'       => $results,
            'attemptNumber' => $attemptNumber,
        ]);
    }

    public function lessonComplete(Request $request, Lesson $lesson)
    {
        $user = User::find(session('LoggedStudent'));

        $quiz = $lesson->quiz;

        if ($quiz) {

            $result = DB::table('quiz_user')
                ->where('quiz_id', $quiz->id)
                ->where('user_id', $user->id)
                ->orderByDesc('completed_at')
                ->first();

            if (! $result) {
                return response()->json([
                    'message' => 'You must attempt the quiz on this lesson before marking it complete.',
                ], 403);
            }

            $correct = $result->score ?? 0;
            $total   = $result->total ?? 0;

            if ($total == 0) {
                return response()->json([
                    'message' => 'Quiz data is invalid (total questions missing).',
                ], 400);
            }

            $percentage = ($correct / $total) * 100;

            if ($percentage < 50) {
                return response()->json([
                    'message' => 'You must score at least 50% in the lesson quiz before completing this lesson.',
                ], 403);
            }
        }

        if ($user && ! $user->completedLessons->contains($lesson->id)) {
            $user->completedLessons()->attach($lesson->id);
        }

        return response()->json(['message' => 'Lesson marked as completed']);
    }

}
