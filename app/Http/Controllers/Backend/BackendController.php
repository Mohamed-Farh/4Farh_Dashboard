<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UserRequest;
use App\Permission;
use App\User;
use App\UserPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class BackendController extends Controller
{
    public function index()
    {
        return view('backend.index');
    }

    public function login()
    {
        return view('backend.login');
    }

    public function forget_password()
    {
        return view('backend.forgot-password');
    }

    //----------------------------------------------------------------------------
    public function mySettings(User $user)
    {
        $user = Auth::user();

        return view('backend.mySettings', compact('user'));
    }
    public function update_mySettings(Request $request, User $user)
    {
        $user = auth()->user();
        if (!\auth()->user()->ability('superAdmin', 'manage_users,update_users')) {
            return redirect('admin/index');
        }

        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'username'      => 'required|max:50|unique:users,username,'.auth()->user()->id,
            'email'         => 'required|email|max:255|unique:users,email,'.auth()->user()->id,
            'mobile'        => 'required|numeric|unique:users,mobile,'.auth()->user()->id,
            'status'        => 'required',
            'password'      => 'nullable|min:8',
            'user_image'    => 'nullable|mimes:png,jpg,jpeg,svg|max:5048'
        ]);

        $input['first_name']    = $request->first_name;
        $input['last_name']     = $request->last_name;
        $input['username']      = $request->username;
        $input['email']         = $request->email;
        $input['mobile']        = $request->mobile;

        if(trim($request->password) != ''){
            $input['password']      = bcrypt($request->password);
        }

        if ($image = $request->file('user_image')) {

            if ($user->user_image != null && File::exists('assets/users/' . $user->user_image )) {
                unlink('assets/users/' . $user->user_image );
            }

            $filename = Str::slug($request->username).'.'.$image->getClientOriginalExtension();   //علشان تكون اسم الصورة نفس اسم الكاتيجوري
            $path = ('assets/users/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();  //لتنسيق العرض مع الطول
            })->save($path, 100);  //الجودة و درجة الوضوح تكون 100%
            $input['user_image']  = $filename;
        }

        $user->update($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        return redirect()->route('admin.mySettings')->with([
            'message' => 'Your Settings Updated Successfully',
            'alert-type' => 'success'
        ]);
    }
    //----------------------------------------------------------------------------
}
