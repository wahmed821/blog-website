<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    private $entryDate;
    public function __construct()
    {
        $this->entryDate = date("Y-m-d H:i:s");
    }

    # Function to show signup page
    public function signup()
    {
        //session()->forget('user_id');
        //Session::put('user_id', 20);
        return view('user.signup');
    }

    ## Function to register user in DB
    public function register(Request $request)
    {
        ## Validation
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
        ]);

        try {

            //$role_id = DB::table("roles")->select("id")->whre('name', 'user')->first();
            $param = array(
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => 2,
                'password' => Hash::make($request->password),
            );
            $user = User::create($param);

            # Send email verification

            // Entry of verification in DB
            $code = substr(str_shuffle('1234567980'), 0, 4);
            $param = array(
                'user_id' => $user->id,
                'verification_code' => $code,
                'created_at' => $this->entryDate,
                'updated_at' => $this->entryDate,
            );
            $last_id = DB::table('verification_codes')->insertGetId($param);

            if ($last_id) {
                $param = array(
                    'name' => $user->name,
                    'code' => $code,
                    'email' => $user->email
                );

                # Send email
                Mail::send('email.signup', $param, function ($message) use ($param) {
                    $message->subject('Email Verification');
                    $message->to($param['email']);
                });

                # Set user_id in session to use on email verification
                Session::put('user_id', $user->id);

                # Redirect to email verification page
                $msg = "Verification email has been sent to your email";
                return redirect()->route('user.email-verification')->withStatus($msg);
            } else {
                $msg = "Something went wrong, please try again";
                return redirect()->back()->withError($msg);
            }
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    # Function to show verify email page
    public function emailVerification()
    {
        # Validation - you need to apply
        # This page should not be directly accessible without the session user_id

        return view('user.email-verification');
    }

    ## Function to verify user
    public function emailVerificationSubmit(Request $request)
    {
        ## Validation
        $request->validate([
            'code' => 'required'
        ]);

        try {
            # Get the user_id from session
            $user_id = Session::get('user_id');

            # Check the verification code in DB WRT user
            $row = DB::table('verification_codes')->select('*')
                ->where(['verification_code' => $request->code, 'user_id' => $user_id])
                ->first();

            if (!empty($row)) {
                # Update the email verification time in User
                $data = array(
                    'email_verified_at' => $this->entryDate,
                    'updated_at' => $this->entryDate
                );
                $update = User::where('id', $user_id)->update($data);

                if ($update) {

                    # Delete the verification
                    DB::table('verification_codes')->where(['user_id' => $user_id])->delete();

                    # Delete the user_id from session
                    session()->forget('user_id');

                    # Redirect to login
                    return redirect()->route('user.login')->withStatus("Verification successful, you can login now");
                } else {
                    return redirect()->back()->withError("Something went wrong, please try again");
                }
            } else {
                return redirect()->back()->withError("Invalid verification code");
            }
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    # Function to show forgot password page
    public function forgotPassword()
    {
        return view('user.forgot-password');
    }

    ## Function of forgot password functionality
    public function forgotPasswordSubmit(Request $request)
    {
        ## Validation
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $user = User::where(['email' => $request->email])->first();
            if ($user) {
                # Send code to reset password

                // Delete previous codes
                DB::table('verification_codes')->where(['user_id' => $user->id])->delete();

                // Entry of code in DB
                $code = substr(str_shuffle('1234567980'), 0, 4);
                $param = array(
                    'user_id' => $user->id,
                    'verification_code' => $code,
                    'created_at' => $this->entryDate,
                    'updated_at' => $this->entryDate,
                );
                $last_id = DB::table('verification_codes')->insertGetId($param);

                if ($last_id) {
                    $param = array(
                        'name' => $user->name,
                        'code' => $code,
                        'email' => $user->email
                    );

                    # Send email
                    Mail::send('email.forgot-password', $param, function ($message) use ($param) {
                        $message->subject('Code to Reset Password');
                        $message->to($param['email']);
                    });

                    # Set user_id in session to use on email verification
                    Session::put('user_id', $user->id);

                    # Redirect to reset password page
                    $msg = "Reset password code has been sent to your email";
                    return redirect()->route('user.reset-password')->withStatus($msg);
                } else {
                    $msg = "Something went wrong, please try again";
                    return redirect()->back()->withError($msg);
                }
            } else {
                return redirect()->back()->withError("User not found with this email");
            }
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    # Function to show reset password page
    public function resetPassword()
    {
        # Validation - you need to apply
        # This page should not be directly accessible without the session user_id

        return view('user.reset-password');
    }

    ## Function to reset password functionality
    public function resetPasswordSubmit(Request $request)
    {
        ## Validation
        $request->validate([
            'code' => 'required',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
        ]);

        try {
            # Get the user_id from session
            $user_id = Session::get('user_id');

            # Check the verification code in DB WRT user
            $row = DB::table('verification_codes')->select('*')
                ->where(['verification_code' => $request->code, 'user_id' => $user_id])
                ->first();

            if (!empty($row)) {

                # Update the new password in User
                $data = array(
                    'password' => bcrypt($request->password),
                    'updated_at' => $this->entryDate
                );
                $update = User::where('id', $user_id)->update($data);
                if ($update) {

                    # Delete the verification
                    DB::table('verification_codes')->where(['user_id' => $user_id])->delete();

                    # Delete the user_id from session
                    session()->forget('user_id');

                    # Redirect to login
                    return redirect()->route('user.login')->withStatus("Password reset successful, you can login now");
                } else {
                    return redirect()->back()->withError("Something went wrong, please try again");
                }
            } else {
                return redirect()->back()->withError("Invalid verification code");
            }
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    # Function to show login page
    public function login()
    {
        return view('user.login');
    }

    # Function to login functionality
    public function loginSubmit(Request $request)
    {
        # Valildation
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
            if (Auth::attempt(['email' => request('email'), 'password' => request('password'), 'role_id' => 2])) {

                # Check user's email is verified or not
                if (is_null(Auth::user()->email_verified_at)) {
                    # Send email verification code back and Redirect back to email verification page
                    return "Email not verified";
                }

                return redirect()->route('user.dashboard');
            } else {
                return redirect()->back()->withError('Invalid login credentials');
            }
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    # Function to logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('user.login');
    }
}
