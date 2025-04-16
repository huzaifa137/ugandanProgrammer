<?php
namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $user->password = Hash::make($request->password);
        $save           = $user->save();

        $data = [
            'email'    => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'title'    => 'UgandanProgrammer - User Account has been created successfully.',
        ];

        Mail::send('emails.user-account-created', $data, function ($message) use ($data) {
            $message->to($data['email'])->subject($data['title']);
        });

        $userRegistered = DB::table('users')->where('email', $request->email)->first();
        if ($userRegistered && Hash::check($request->password, $userRegistered->password)) {

            $request->session()->put('LoggedAdmin', $userRegistered->id);

            return response()->json([
                'status'       => true,
                'message'      => 'Account has been created successfully, Enroll in a course to become a senior developer',
                'redirect_url' => '/',
            ]);

        } else {

            return response()->json([
                'status'       => false,
                'message'      => 'There was something wrong in creating this account, please contract admins',
                'redirect_url' => '/',
            ]);
        }
    }

}
