<?php
namespace App\Http\Controllers;

use App\Models\password_reset_table;
use App\Models\User;
use App\Models\user_role;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public static $page = "USERS";

    public static function links()
    {
        return $links = [
            [
                "link_name"    => "Register new user",
                "link_address" => "users/users-register",
                "link_icon"    => "fa-calendar",
                "link_page"    => self::$page,
                "link_right"   => "V",
            ],
            [
                "link_name"    => "View users information",
                "link_address" => "users/users-information",
                "link_icon"    => "fa-search",
                "link_page"    => self::$page,
                "link_right"   => "V",
            ],
        ];
    }

    public function createNewPassword($id)
    {
        $generated_id = url('password/reset/' . $id);
        $resetEntry   = DB::table('password_reset_tables')->where('token', $generated_id)->first();

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
        $email    = $request->email;
        $username = DB::table('users')->where('email', $email)->value('username');

        $user = User::where('email', $email)->first();

        if ($user == null) {
            return back()->withInput()->with('fail', 'The email provided is not registered in the system');
        } else {
            $token = Str::random(60);

            $resetUrl = url('password/reset', $token);

            $post = new password_reset_table();

            $post->email      = $email;
            $post->token      = $resetUrl;
            $post->created_at = now();

            $post->save();

            $data = [
                'email'    => $email,
                'username' => $username,
                'resetUrl' => $resetUrl,
                'title'    => 'UP O.T.P:Reset Password Link',
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
                'password.string'   => 'The password must be a string.',
                'password.min'      => 'The password must be at least 6 characters.',
                'password.regex'    => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
            ],
        );

        $password     = $request->password;
        $confirm      = $request->confirmPassword;
        $generated_id = $request->generated_id;

        if ($password == $confirm) {
            $record     = DB::table('password_reset_tables')->where('token', $generated_id)->first();
            $record_id  = $record->id;
            $user_email = $record->email;

            $new_password = Hash::make($password);

            DB::table('users')
                ->where('email', $user_email)
                ->update(['password' => $new_password]);

            $post              = password_reset_table::find($record_id);
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

        $new_otp      = $otp_1 . $otp_2 . $otp_3 . $otp_4 . $otp_5;
        $user_id      = $request->input('hidden_otp');
        $userPassword = $request->input('userPassword');

        $temp_otp_stored   = DB::table('users')->where('email', $user_id)->value('temp_otp');
        $supplier_username = DB::table('users')->where('email', $user_id)->value('username');
        $userId            = DB::table('users')->where('email', $user_id)->value('id');
        $userRole          = DB::table('users')->where('email', $user_id)->value('user_role');

        if ($new_otp == $temp_otp_stored) {

            if ($userRole != 1) {
                $request->session()->put('LoggedAdmin', $userId);
            } else {
                $request->session()->put('LoggedStudent', $userId);
            }

            DB::table('users')
                ->where('id', $userId)
                ->update(['registration_status' => 1]);

            $user = DB::table('users')->where('id', $userId)->first();

            $data = [
                'email'    => $user->email,
                'username' => $user->username,
                'password' => session('userPassword'),
                'title'    => 'UgandanProgrammer - User Account has been created successfully.',
            ];

            try {
                Mail::send('emails.user-account-created', $data, function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });
            } catch (Exception $e) {
                DB::table('users')->where('email', $user->email)->delete();
                return back()->with('error', 'Email Not, Check Internet or re-register');
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

    public function studentLogout()
    {
        if (session()->has('LoggedStudent')) {
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
            'email'    => [
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
        ]);

        $userInfo = User::where('email', '=', $request->email)->first();

        if (! $userInfo) {
            return response()->json([
                'status'  => false,
                'message' => 'We dont recognise the above email or password',
            ]);
        } else {
            if (Hash::check($request->password, $userInfo->password)) {

                $registrationStatus = DB::table('users')->where('email', $request->email)->value('registration_status');

                $user_check_email = $request->email;

                if ($registrationStatus == 0) {

                    $new_otp      = rand(10000, 99999);
                    $generatedOTP = $new_otp;

                    $userId    = DB::table('users')->where('email', $request->email)->value('id');
                    $user_mail = DB::table('users')->where('email', $request->email)->value('email');
                    $username  = DB::table('users')->where('email', $request->email)->value('username');

                    DB::table('users')
                        ->where('email', $request->email)
                        ->update(['temp_otp' => $new_otp]);

                    $data = [
                        'subject'      => 'UP OTP LOGIN',
                        'body'         => 'Enter the Sent OTP to Login : ',
                        'generatedOTP' => $generatedOTP,
                        'username'     => $username,
                        'email'        => $user_mail,
                    ];

                    if ($user_mail) {
                        try {
                            Mail::send('emails.otp', $data, function ($message) use ($data) {
                                $message->to($data['email'], $data['email'])->subject($data['subject']);
                            });
                        } catch (Exception $e) {
                            return back()->with('error', 'Email Not, Check Internet or re-register');
                        }

                        $request->session()->put('userId', $userId);
                        $request->session()->put('userEmail', $user_mail);
                        $request->session()->put('userPassword', $request->password);

                        return response()->json([
                            'status'       => true,
                            'message'      => 'OTP has been sent,check your email to proceed',
                            'redirect_url' => '/users/user-otp',
                        ]);
                    }
                } else {

                    $userId   = DB::table('users')->where('email', $request->email)->value('id');
                    $userRole = DB::table('users')->where('email', $request->email)->value('user_role');

                    if ($userRole != 1) {
                        $request->session()->put('LoggedAdmin', $userId);
                    } else {
                        $request->session()->put('LoggedStudent', $userId);
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
                }
            } else {

                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid password or Email being entered',
                ]);
            }
        }
    }

    public function regenerateOTP(Request $request)
    {

        $user_id      = $request->input('hidden_otp');
        $new_otp      = rand(10000, 99999);
        $generatedOTP = $new_otp;

        $user_mail = DB::table('users')->where('email', $user_id)->value('email');
        $username  = DB::table('users')->where('email', $user_id)->value('username');

        DB::table('users')
            ->where('email', $user_id)
            ->update(['temp_otp' => $new_otp]);

        $data = [
            'subject'      => 'UP RESENT OTP LOGIN',
            'body'         => 'Enter the Sent OTP to Login : ',
            'generatedOTP' => $generatedOTP,
            'username'     => $username,
            'email'        => $user_mail,
        ];

        if ($user_mail) {
            Mail::send('emails.otp', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['email'])->subject($data['subject']);
            });
        }

        return response()->json([
            'status'  => true,
            'message' => 'New OTP code has been sent to your email' . ' ' . $user_mail,
        ]);
    }

    public function userProfile()
    {

        $user = DB::table('users')->where('id', session('LoggedAdmin'))->first();

        return view('users.user-profile', compact(['user']));
    }

    public function userRegister()
    {

        $user_supervisors = DB::table("users")
            ->select('firstname', 'lastname')
            ->get();

        return view('users.user-register', compact(['user_supervisors']));
    }

    public function editUserInformation()
    {

        $info = DB::table('users')->where('id', Session('LoggedAdmin'))->first();

        return view('users.edit-user-information', compact(['info']));
    }

    public function editSpecificUser($userId)
    {

        $info = DB::table('users')->where('id', $userId)->first();

        return view('users.edit-user-information', compact(['info']));
    }

    public function userInformation(Request $request)
    {
        $users   = User::all();
        $mc_code = DB::table('master_datas')
            ->join('master_codes', 'md_master_code_id', '=', 'master_codes.id')
            ->get();

        if ($request->ajax()) {
            return datatables()->of($users)
                ->addColumn('action', function ($user) {
                    $links   = [];
                    $links[] = '<a class="dropdown-item" href="user-account-information/' . $user->id . '"><i class="fa fa-fw fa-eye"></i> View</a>';
                    $links[] = '<a class="dropdown-item" href="/users/edit-specific-user/' . $user->id . '"><i class="fa fa-fw fa-edit"></i> Edit</a>';
                    $links[] = '<a onclick="return confirm(\'Are you sure you want to delete ' . $user->firstname . ' ' . $user->lastname . '?\'); " class="dropdown-item" href="delete-user/' . $user->id . '"><i class="fa fa-fw fa-times"></i> Delete</a>';

                    return '<div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton' . $user->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $user->id . '">
                                ' . implode('', $links) . '
                            </ul>
                        </div>';
                })
                ->make(true);
        }

        return view('users.user-information', [
            'mc_code'         => $mc_code,
            'users'           => $users,
            'LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first(),
        ]);
    }

    public function userAccountInformation($id)
    {

        $next = DB::table('users')->where('id', '>', $id)->orderBy('id', 'ASC')->value('id');
        $prev = DB::table('users')->where('id', '<', $id)->orderBy('id', 'DESC')->value('id');

        $user_profile_data = DB::table('users')->where('id', $id)->first();

        $data = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];

        return view('users.user-account-information', $data, compact(['user_profile_data']))
            ->with('next', $next)
            ->with('prev', $prev);
    }

    public function storeUpdatedInformation(Request $request)
    {

        $id = $request->hidden_id;

        $reference = DB::table('users')->where('id', $id)->value('user_reference');

        $request->validate([

            'email'       => 'required',
            'firstname'   => 'required',
            'lastname'    => 'required',
            'username'    => 'required',
            'gender'      => 'required',
            'user_role'   => 'required',
            'phonenumber' => 'required',
            'title'       => 'required',
        ]);

        $role_name = $request->user_role;

        $userRoleId = DB::table('user_roles')->where('user_name', $role_name)->value('user_id');

        $email          = $request->email;
        $firstname      = $request->firstname;
        $lastname       = $request->lastname;
        $username       = $request->username;
        $gender         = $request->gender;
        $user_role      = $request->user_role;
        $phonenumber    = $request->phonenumber;
        $account_status = $request->account_status;
        $title          = $request->title;
        $user_title     = $request->user_title;

        $user_supervisior = $request->user_supervisor;
        $passport         = $request->passport;
        $country          = $request->country;
        $password         = $request->password;

        $all_emails   = DB::table('users')->pluck('email');
        $all_username = DB::table('users')->pluck('username');

        foreach ($all_emails as $specific_email) {

            if ($email == $specific_email) {
                $user_id = DB::table('users')->where('email', $email)->value('id');
                if ($user_id != $id) {
                    return back()->with('fail', 'The provided Email id is already registered to another user');
                }
            }
        }

        foreach ($all_username as $specific_username) {

            if ($username == $specific_username) {

                $user_id = DB::table('users')->where('username', $username)->value('id');

                if ($user_id != $id) {
                    return back()->with('fail', 'The provided username is already registered to another user');
                }
            }
        }

        DB::table('users')->where('id', $id)
            ->update([
                'email'           => $email,
                'firstname'       => $firstname,
                'lastname'        => $lastname,
                'username'        => $username,
                'gender'          => $gender,
                'user_role'       => $user_role,
                'phonenumber'     => $phonenumber,
                'account_status'  => $account_status,
                'user_id'         => $userRoleId,
                'Title'           => $title,
                'user_supervisor' => $user_supervisior,
                'user_title'      => $user_title,
                'passport_number' => $passport,
                'country'         => $country,
            ]);

        $units = $request->requisitionunits;

        $currentTimestamp = time();
        $twoYearsFromNow  = strtotime('+2 years', $currentTimestamp);

        return back()->with('success', 'User Information has been updated successfully');
    }

    public function deleteUser($id)
    {
        $data = User::find($id);

        $data->delete();

        return back()->with('success', 'user ' . $data->username . ' has been deleted successfully');
    }

    public function editRecord($md_id)
    {

        $data = ['LoggedUserAdmin' => Admin::where('id', '=', session('LoggedAdmin'))->first()];

        $tb_record = DB::table('master_datas')
            ->where('md_id', $md_id)
            ->get();

        $md_master_code_id = DB::table('master_datas')->where('md_id', $md_id)->pluck('md_master_code_id');
        $md_master_code_id = $md_master_code_id[0];

        $selected = DB::select('select id, mc_name from master_codes');

        if (is_numeric($md_master_code_id)) {

            $master_code_name = DB::table('master_codes')->where('id', $md_master_code_id)->pluck('mc_name');
            $master_code_id   = DB::table('master_codes')->where('id', $md_master_code_id)->pluck('mc_id');

            if (isset($master_code_name[0])) {

                $master_code_name = $master_code_name[0];
                $master_code_id   = $master_code_id[0];

                return view('master-logic.edit-record', $data, compact(['tb_record', 'selected', 'master_code_name', 'master_code_id', 'md_id']));
            } else {
                $master_code_name = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_name');
                $master_code_id   = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_id');

                $master_code_name = $master_code_name[0];
                $master_code_id   = $master_code_id[0];

                return view('master-logic.edit-record', $data, compact(['tb_record', 'selected', 'master_code_name', 'master_code_id', 'md_id']));

            }
        } else {
            $master_code_name = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_name');
            $master_code_id   = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_id');

            $master_code_name = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_name');
            $master_code_id   = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_id');

            $master_code_name = $master_code_name[0];
            $master_code_id   = $master_code_id[0];

            return view('master-logic.master-logic.edit-record', $data, compact(['tb_record', 'selected', 'master_code_name', 'master_code_id', 'md_id']));

        }
    }

    public function storeInternalUser(Request $request)
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

        return back()->with('success', 'User account has been created successfully');
    }

    public function storeUpdatedInternalUser(Request $request)
    {

        // ACCOUNT STATUSES
// --------------------------------------
        // 1.Banned     ====> 0
        // 2.Locked     ====> 8
        // 3.Suspended  ====> 9
        // 4.Active     ====> 10

        $request->validate([
            'username' => 'required',
            'email'    => 'required|email',
        ]);

        if ($request->password != null && $request->confirmPassword != null) {
            $request->validate(
                [
                    'password' => [
                        'required',
                        'string',
                        'min:6',
                        'regex:/[A-Z]/',
                        'regex:/[a-z]/',
                        'regex:/[0-9]/',
                        'regex:/[@$!%*?&#]/',
                    ],
                ],
                [
                    'password.required' => 'The password field is required.',
                    'password.string'   => 'The password must be a string.',
                    'password.min'      => 'The password must be at least 6 characters.',
                    'password.regex'    => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
                ]
            );
        }

        $password = trim($request->password);

        if ($request->password != null) {
            
            User::updateOrCreate(
                ['id' => $request->user_id],
                [
                    'username'    => $request->username,
                    'email'       => $request->email,
                    'password'    => Hash::make($password),
                    'firstname'   => $request->firstname,
                    'lastname'    => $request->lastname,
                    'gender'      => $request->gender,
                    'phonenumber' => $request->phonenumber,
                    'country'     => $request->country,
                ]);

            return back()->with('success', 'User account has been updated successfully');

        } else {

            User::updateOrCreate(
                ['id' => $request->user_id],
                [
                    'username'    => $request->username,
                    'email'       => $request->email,
                    'firstname'   => $request->firstname,
                    'lastname'    => $request->lastname,
                    'gender'      => $request->gender,
                    'phonenumber' => $request->phonenumber,
                    'country'     => $request->country,
                ]);

            return back()->with('success', 'User account has been updated successfully');
        }

    }
}
