<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;
use Auth;
use DB;

class StaffController extends Controller
{
    public function __construct()
    { }

    ## Categories function
    public function staffs()
    {
        $users = User::select('*')->where('role_id', 3)->with('role')->orderBy('id', 'desc')->get();
        return view("admin.staff.index", compact('users'));
    }

    ## Add Staff function
    public function addStaff()
    {
        return view('admin.staff.add');
    }

    ## Function to insert/update staff in DB
    public function storeStaff(Request $request)
    {
        ## Validation - Todo (You need to do this)
        try {
            # Update staff
            if (isset($request->id)) {
                $param = array(
                    'name' => $request->name,
                    'email' => $request->email,
                );
                User::where('id', $request->id)->update($param);
                $msg = "User has been updated successfully";
            }
            # Insert
            else {
                $param = array(
                    'name' => $request->name,
                    'email' => $request->email,
                    'role_id' => 3,
                    'password' => Hash::make($request->password),
                );
                User::create($param);
                $msg = "User has been created successfully";
            }
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
        # Redirect to all categories
        return redirect()->route('staffs')->withStatus($msg);
    }
}
