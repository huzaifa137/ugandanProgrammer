<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Mail;
use App\Models\password_reset_table;


class UserController extends Controller
{

    public function createNewPassword($id)
    {
        $generated_id = url('password/reset/' . $id);
        $resetEntry = DB::table('password_reset_tables')->where('token', $generated_id)->first();

        if ($resetEntry) {
            if ($resetEntry->link_status == 0) {
                if (now()->diffInMinutes($resetEntry->created_at) <= 30) {
                    return view('users.reset-password-2', compact(['generated_id']));
                } else {
                    return ('users.login')->with('fail', 'This reset password link has expired');
                }
            } else {
                return redirect()->route('users.login')->with('fail', 'This link has already been used, request for a new link');
            }
        } else {
            return redirect()->route('users.login')->with('fail', 'Invalid Link');
        }
    }

    public function generateForgotPasswordLink(Request $request)
    {
        $email = $request->email;
        $username = DB::table('users')->where('email', $email)->value('username');

        $user = User::where('email', $email)->first();

        if ($user == null) {
            return back()->withInput()->with('fail', 'The email provided is not registered in the system');
        } else {
            $token = Str::random(60);

            $resetUrl = url('password/reset', $token);

            $post = new password_reset_table();

            $post->email = $email;
            $post->token = $resetUrl;
            $post->created_at = now();

            $post->save();

            $data = [
                'email' => $email,
                'username' => $username,
                'resetUrl' => $resetUrl,
                'title' => 'PTS O.T.P:Reset Password Link',
            ];

            Mail::send('emails.reset_email', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['email'])->subject($data['title']);
            });

            return back()->with('success', 'Link has been sent to your email : ' . ' ' . $email);
        }
    }

    public function store_new_password(Request $request)
    {
        $request->validate(
            [
                'password' => ['required', 'string', 'min:6', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&#]/'],
            ],
            [
                'password.required' => 'The password field is required.',
                'password.string' => 'The password must be a string.',
                'password.min' => 'The password must be at least 6 characters.',
                'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
            ],
        );

        $password = $request->password;
        $confirm = $request->confirmPassword;
        $generated_id = $request->generated_id;

        if ($password == $confirm) {
            $record = DB::table('password_reset_tables')->where('token', $generated_id)->first();
            $record_id = $record->id;
            $user_email = $record->email;

            $new_password = Hash::make($password);

            DB::table('users')
                ->where('email', $user_email)
                ->update(['password' => $new_password]);

            $post = password_reset_table::find($record_id);
            $post->link_status = 1;
            $post->save();

            return redirect()->route('users.login')->with('success', 'Password has been updated successfully');
        } else {
            return back()->with('fail', 'Passwords do not match');
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

        $temp_otp_stored = DB::table('users')->where('id', $user_id)->value('temp_otp');
        $supplier_username = DB::table('users')->where('id', $user_id)->value('username');

        if ($new_otp == $temp_otp_stored) {

            $request->session()->put('LoggedAdmin', $user_id);
            // $request->session()->put('ACTIVE_MODULE', 'SUPPLIERS');

            AuditTrailController::register('LOGIN SUCCESSFULL', 'ADMIN Username: <b>' . $supplier_username . '</b> Pasword: <b>*******</b>');

            $url = '/';

            $url2 = session()->get('url.intended');

            if ($url2 != null) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login successful',
                    'redirect_url' => $url2,
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'redirect_url' => $url,
            ]);

        } else {
            AuditTrailController::register('INVALID OTP', 'ADMIN Username: <b>' . $supplier_username . '</b> Pasword: <b>*******</b>');

            return response()->json([
                'status' => false,
                'title' => 'Invalid OTP',
                'message' => 'Entered OTP is invalid, please check your email for correct OTP code',
            ]);
        }
    }

    public function reload_captcha()
    {
        return response()->json(['captcha' => captcha_img('flat')]);
    }

    public function userLogout()
    {
        if (session()->has('LoggedAdmin')) {
            session()->flush();
            return redirect('/');
        } else {
            return redirect('/');
        }
        return back();
    }

    public function forgotPassword()
    {
        return view('users.forgot-password');
    }

    public function login(Request $request)
    {
        return view('users.login');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function checkUser(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/\d/',
                'regex:/[\W_]/',
            ],
            'captcha' => 'required|captcha',
        ]);

        $userInfo = User::where('email', '=', $request->email)->first();

        if (!$userInfo) {
            return back()->with('fail', 'We dont recognise the above email or password');
        } else {
            if (Hash::check($request->password, $userInfo->password)) {
                $user_check_email = $request->email;

                $new_otp = rand(10000, 99999);

                $info = DB::table('users')
                    ->where('email', $user_check_email)
                    ->update(['temp_otp' => $new_otp]);

                $user_id_check = DB::table('users')->where('email', $user_check_email)->value('id');
                $username = DB::table('users')->where('id', $user_id_check)->value('username');

                $data = [
                    'subject' => 'PTS LOGIN OTP',
                    'body' => 'Enter the Sent OTP to Login : ',
                    'otp' => $new_otp,
                    'username' => $username,
                    'email' => $user_check_email,
                ];

                if ($user_check_email) {
                    $error = "";
                    try {
                        Mail::send('emails.otp', ['otp' => $new_otp, 'username' => $username], function ($message) use ($data) {
                            $message->to($data['email'])->subject($data['subject']);
                        });
                    } catch (\Exception $e) {

                        Log::error('Failed to send email: ' . $e->getMessage());
                        $error = "Failed to send email: " . $e->getMessage();

                        return redirect()->back()->withInput()->with('fail', $error);
                    }

                    return view('users.otp', compact(['user_id_check', 'user_check_email']))
                    ;

                } else {
                    return redirect()->back()->withInput()->with('fail', 'Invalid password or Email being entered');
                }
            } else {
                return redirect()->back()->withInput()->with('fail', 'Invalid password or email being entered');
            }
        }
    }

    public function regenerateOTP(Request $request)
    {

        $user_id = $request->input('hidden_otp');

        $new_otp = rand(10000, 99999);

        $user_mail = DB::table('users')->where('id', $user_id)->value('email');
        $username = DB::table('users')->where('id', $user_id)->value('username');

        DB::table('users')
            ->where('id', $user_id)
            ->update(['temp_otp' => $new_otp]);

        $data = [
            'subject' => 'PTS RESENT OTP LOGIN',
            'body' => 'Enter the Sent OTP to Login : ',
            'otp' => $new_otp,
            'username' => $username,
            'email' => $user_mail,
        ];

        if ($user_mail) {
            Mail::send('emails.otp', ['otp' => $new_otp, 'username' => $username], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['subject']);
            });
        }

        return response()->json([
            'status' => true,
            'message' => 'New OTP code has been sent to your email' . ' ' . $user_mail,
        ]);
    }

    public function userProfile()
    {

        $user = DB::table('users')->where('id', session('LoggedAdmin'))->first();

        return view('users.user-profile', compact(['user']));
    }

}
