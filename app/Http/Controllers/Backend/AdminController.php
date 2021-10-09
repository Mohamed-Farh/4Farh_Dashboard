<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AdminRequest;
use App\Permission;
use App\Role;
use App\User;
use App\UserPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //هنا هنعطي لكل واحد الدور بتاعه و صلاحياته
        if (!\auth()->user()->ability('superAdmin', 'manage_admins,show_admins')) {
            return redirect('admin/index');
        }

        $admins = User::whereHas('roles', function($query){
            $query->where('name', 'admin');
        })

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);  //بمعني وانت راجع بالكاتبجوري هات معاك مجمع المنتجات الخاصة بكل كاتبجوري

        return view('backend.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_admins,create_admins')) {
            return redirect('admin/index');
        }

        $permissions = Permission::get(['id', 'display_name']);

        return view('backend.admins.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_admins,create_admins')) {
            return redirect('admin/index');
        }

        $input['first_name']    = $request->first_name;
        $input['last_name']     = $request->last_name;
        $input['username']      = $request->username;
        $input['email']         = $request->email;
        $input['email_verified_at']  = Carbon::now();
        $input['mobile']        = $request->mobile;
        $input['password']      = bcrypt($request->password);
        $input['status']        = $request->status;

        if ($image = $request->file('user_image')) {
            $filename = Str::slug($request->username).'.'.$image->getClientOriginalExtension();   //علشان تكون اسم الصورة نفس اسم الكاتيجوري
            $path = ('assets/users/' . $filename);
            Image::make($image->getRealPath())->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();  //لتنسيق العرض مع الطول
            })->save($path, 100);  //الجودة و درجة الوضوح تكون 100%
            $input['user_image']  = $filename;
        }

        $admin = User::create($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت
        $admin->markEmailAsVerified();

        $admin->attachRole(Role::whereName('admin')->first()->id);

        if(isset($request->permissions) && count($request->permissions) > 0){
            $admin->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.admins.index')->with([
            'message' => 'Admin Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $admin)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_admins,display_admins')) {
            return redirect('admin/index');
        }

        return view('backend.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $admin)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_admins,update_admins')) {
            return redirect('admin/index');
        }

        $permissions = Permission::get(['id', 'display_name']);
        $adminPermissions = UserPermissions::whereUserId($admin->id)->pluck('permission_id')->toArray();

        return view('backend.admins.edit', compact('admin', 'permissions', 'adminPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, User $admin)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_admins,update_admins')) {
            return redirect('admin/index');
        }

        $input['first_name']    = $request->first_name;
        $input['last_name']     = $request->last_name;
        $input['username']      = $request->username;
        $input['email']         = $request->email;
        $input['mobile']        = $request->mobile;
        $input['status']        = $request->status;

        if(trim($request->password) != ''){
            $input['password']      = bcrypt($request->password);
        }

        if ($image = $request->file('user_image')) {

            if ($admin->user_image != null && File::exists('assets/users/' . $admin->user_image )) {
                unlink('assets/users/' . $admin->user_image );
            }

            $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();   //علشان تكون اسم الصورة نفس اسم الكاتيجوري
            $path = ('assets/users/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();  //لتنسيق العرض مع الطول
            })->save($path, 100);  //الجودة و درجة الوضوح تكون 100%
            $input['user_image']  = $filename;
        }

        $admin->update($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        if (isset($request->permissions) && count($request->permissions) > 0 ){
            $admin->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.admins.index')->with([
            'message' => 'Admin Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $admin)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_admins,delete_admins')) {
            return redirect('admin/index');
        }

        if ($admin->user_image != null && File::exists('assets/users/' . $admin->user_image)) {
            unlink('assets/users/' . $admin->user_image);
        }
        $admin->delete();

        return redirect()->route('admin.admins.index')->with([
            'message' => 'Admin Deleted Successfully',
            'alert-type' => 'success'
        ]);

    }



    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_admins,delete_admins')) {
            return redirect('admin/index');
        }

        $admin = User::whereId($request->admin_id)->first();
        if ($admin) {
            if (File::exists('assets/users/' . $admin->user_image)) {
                unlink('assets/users/' . $admin->user_image);

                $admin->user_image = null;
                $admin->save();
            }
        }
        return true;
    }


}
