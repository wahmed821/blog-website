<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect()->route('dashboard');
        //return view('admin.dashboard');
    }

    public function changePassword()
    {
        return view("admin.change-password");
    }

    public function updatePassword(Request $request)
    {
        $user_id = Auth::user()->id;
        if (!Auth::attempt(['id' => $user_id, 'password' => $request->current_pass])) {
            return redirect()->back()->withError(__('Current password is wrong'));
        }

        if ($request->current_pass == $request->new_pass) {
            return redirect()->back()->withError(__('Current password and new password should be different'));
        }

        $user = new User;
        $user = $user::findOrFail($user_id);
        $user->password = Hash::make($request->new_pass);
        $user->update();

        return redirect()->back()->withStatus(__('Password has been successfully changed'));
    }
}
