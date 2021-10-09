<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UserRequest;
use App\Permission;
use App\Role;
use App\User;
use App\UserPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //هنا هنعطي لكل واحد الدور بتاعه و صلاحياته
        if (!\auth()->user()->ability('superAdmin', 'manage_users,show_users')) {
            return redirect('admin/index');
        }

        $users = User::whereHas('roles', function($query){
            $query->where('name', 'user');
        })

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);  //بمعني وانت راجع بالكاتبجوري هات معاك مجمع المنتجات الخاصة بكل كاتبجوري

        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_users,create_users')) {
            return redirect('admin/index');
        }

        $permissions = Permission::get(['id', 'display_name']);

        return view('backend.users.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_users,create_users')) {
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

        $user = User::create($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت
        $user->markEmailAsVerified();

        $user->attachRole(Role::whereName('user')->first()->id);

        if(isset($request->permissions) && count($request->permissions) > 0){
            $user->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.users.index')->with([
            'message' => 'User Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_users,display_users')) {
            return redirect('admin/index');
        }

        return view('backend.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_users,update_users')) {
            return redirect('admin/index');
        }

        $permissions = Permission::get(['id', 'display_name']);
        $userPermissions = UserPermissions::whereUserId($user->id)->pluck('permission_id')->toArray();


        return view('backend.users.edit', compact('user', 'permissions', 'userPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_users,update_users')) {
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

            if ($user->user_image != null && File::exists('assets/users/' . $user->user_image )) {
                unlink('assets/users/' . $user->user_image );
            }

            $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();   //علشان تكون اسم الصورة نفس اسم الكاتيجوري
            $path = ('assets/users/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();  //لتنسيق العرض مع الطول
            })->save($path, 100);  //الجودة و درجة الوضوح تكون 100%
            $input['user_image']  = $filename;
        }

        $user->update($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        if (isset($request->permissions) && count($request->permissions) > 0 ){
            $user->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.users.index')->with([
            'message' => 'User Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_users,delete_users')) {
            return redirect('admin/index');
        }

        if ($user->user_image != null && File::exists('assets/users/' . $user->user_image)) {
            unlink('assets/users/' . $user->user_image);
        }
        $user->delete();

        return redirect()->route('admin.users.index')->with([
            'message' => 'User Deleted Successfully',
            'alert-type' => 'success'
        ]);

    }



    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_users,delete_users')) {
            return redirect('admin/index');
        }

        $user = User::whereId($request->user_id)->first();
        if ($user) {
            if (File::exists('assets/users/' . $user->user_image)) {
                unlink('assets/users/' . $user->user_image);

                $user->user_image = null;
                $user->save();
            }
        }
        return true;
    }


}
