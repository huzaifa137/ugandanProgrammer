<?php
namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Models\Course;

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

            // AuditTrailController::register('LOGIN SUCCESSFULL', 'ADMIN Username: <b>' . $supplier_username . '</b> Pasword: <b>*******</b>');

            $url  = '/';
            $url2 = session()->get('url.intended');
            $url3  = '/student/dashboard';

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

        $allCourses = Course::orderBy('id', 'desc')->paginate(8);

        return view('student.courses-and-lessons', compact(['allCourses']));
    }

}
