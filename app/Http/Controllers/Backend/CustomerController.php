<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CustomerRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //هنا هنعطي لكل واحد الدور بتاعه و صلاحياته
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,show_customers')) {
            return redirect('admin/index');
        }

        $customers = User::whereHas('roles', function($query){
            $query->where('name', 'customer');
        })

        ->when(\request()->keyword !=null, function($query){
            $query->search(\request()->keyword);
        })
        ->when(\request()->status !=null, function($query){
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id' ,  \request()->order_by ?? 'desc')

        ->paginate(\request()->limit_by ?? 10);  //بمعني وانت راجع بالكاتبجوري هات معاك مجمع المنتجات الخاصة بكل كاتبجوري

        return view('backend.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,create_customers')) {
            return redirect('admin/index');
        }

        return view('backend.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,create_customers')) {
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
            $path = ('assets/customers/' . $filename);
            Image::make($image->getRealPath())->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();  //لتنسيق العرض مع الطول
            })->save($path, 100);  //الجودة و درجة الوضوح تكون 100%
            $input['user_image']  = $filename;
        }

        $customer = User::create($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت
        $customer->markEmailAsVerified();
        $customer->attachRole(Role::whereName('customer')->first()->id);

        return redirect()->route('admin.customers.index')->with([
            'message' => 'Customer Created Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $customer)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,display_customers')) {
            return redirect('admin/index');
        }

        return view('backend.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $customer)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,update_customers')) {
            return redirect('admin/index');
        }

        return view('backend.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, User $customer)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,update_customers')) {
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

            if ($customer->user_image != null && File::exists('assets/customers/' . $customer->user_image )) {
                unlink('assets/customers/' . $customer->user_image );
            }

            $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();   //علشان تكون اسم الصورة نفس اسم الكاتيجوري
            $path = ('assets/customers/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();  //لتنسيق العرض مع الطول
            })->save($path, 100);  //الجودة و درجة الوضوح تكون 100%
            $input['user_image']  = $filename;
        }

        $customer->update($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

        return redirect()->route('admin.customers.index')->with([
            'message' => 'Customer Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $customer)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,delete_customers')) {
            return redirect('admin/index');
        }

        if ($customer->user_image != null && File::exists('assets/customers/' . $customer->user_image)) {
            unlink('assets/customers/' . $customer->user_image);
        }
        $customer->delete();

        return redirect()->route('admin.customers.index')->with([
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success'
        ]);

    }



    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('superAdmin', 'manage_customers,delete_customers')) {
            return redirect('admin/index');
        }

        $customer = User::whereId($request->customer_id)->first();
        if ($customer) {
            if (File::exists('assets/customers/' . $customer->user_image)) {
                unlink('assets/customers/' . $customer->user_image);

                $customer->user_image = null;
                $customer->save();
            }
        }
        return true;
    }


}
