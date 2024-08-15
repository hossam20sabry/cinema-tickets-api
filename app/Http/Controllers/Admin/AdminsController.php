<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    public function index(){
        $admins = Admin::all();
        return view('admin.admins', compact('admins'));
    }

    public function destroy($id)
    {
        $current_admin = auth()->guard('admin')->user();
        if ($current_admin->id == $id) {
            return redirect()->route('admin.index')->with('error', 'You can not delete your own account');
        }

        if($current_admin->main == 1) {
            $admin = Admin::find($id);
            $admin->delete();
            return redirect()->route('admin.admins.index')->with('status', 'Admin deleted successfully');
        }
        else{
            return redirect()->route('admin.admins.index')->with('error', 'this is process not allowed for you');
        }

    }

    public function main($id)
    {
        $current_admin = auth()->guard('admin')->user();

        if ($current_admin->id == $id) {
            return redirect()->route('admin.admins.index')->with('error', 'You are main admin already'); 
        }
        
        if($current_admin->main == 1) {
            $admin = Admin::find($id);
            $admin->main = 1;
            $admin->save();
            return redirect()->route('admin.admins.index')->with('status', 'Admin become main admin successfully');
        }
        else{
            return redirect()->route('admin.admins.index')->with('error', 'this is process not allowed for you'); 
        }

    }
}
