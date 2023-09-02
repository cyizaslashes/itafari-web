<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function AdminDashboard(){
        return view('admin.index');
    }

    public function AdminLogout(Request $request) ///custom logout for the admin
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
    public function AdminLogin(){
        return view('admin.admin_login');
    }
    public function AdminProfile(){
    $id=Auth::user()->id;
    $profileData = User::find($id);
    return view('admin.admin_profile',compact('profileData'));
    }
    public function AdminProfileStore(Request $request){
        $id=Auth::user()->id;
        $data = User::find($id);
        $data->username=$request->username;
        $data->name=$request->name;
        $data->email=$request->email;
        $data->phone=$request->phone;
        $data->address=$request->address;

        if ($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName(); // Corrected method name
            $file->move(public_path('upload/admin_images'), $filename);
            $data->photo = $filename;
        }
        $data->save();
        $notification = array('message'=>'Admin Profile Updated successfully',
        'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function  AdminChangePassword(){
        $id=Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password',compact('profileData'));
    }

    public function AdminUpdatePassword(Request $request){
         //validation
        $request->validate([
            'old_password' => 'required',
            'new_password'=> 'required|confirmed'
        ]);
        ///another validation
        if(!Hash::check($request->old_password, auth::user()->password)){
           
        $notification = array('message'=>'Old password does not much',
        'alert-type'=>'error');
        return redirect()->back()->with($notification);
        }
        ///update new password
        user::whereId(auth()->user()->id)->update([
            'password'=> Hash::make($request->new_password)
        ]);
        $notification = array('message'=>'password changed succefully',
        'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }
}
